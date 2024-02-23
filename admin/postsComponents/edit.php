<?php
include('../db/db.php');

//Get category_id from categories table
$getCategory_query = 'SELECT * FROM category';
$getCategory_stmt = $db->prepare($getCategory_query);
$getCategory_stmt->execute();
$categoryResult = $getCategory_stmt->get_result();

//Create empty varaibles
$post_title = '';
$post_content = '';
$post_category = '';
$post_categoryId = '';
$post_image = '';
$post_status = '';

$post_id = isset($_GET['p_id']) ? $_GET['p_id'] : null;

if (isset($post_id)) {
    $getPosts_query = "SELECT posts.*, users.username AS user_name, category.category_title
    FROM posts
    LEFT JOIN users ON posts.user_id = users.id
    LEFT JOIN category ON posts.category_id = category.id
    WHERE posts.id=?";

    $getPosts_stmt = $db->prepare($getPosts_query);
    $getPosts_stmt->bind_param("s", $post_id);
    $getPosts_stmt->execute();
    $postsResult = $getPosts_stmt->get_result();

    if ($postsResult->num_rows > 0) {
        $row = $postsResult->fetch_assoc();

        $post_title = $row['post_title'];
        $post_content = $row['post_content'];
        $post_category = $row['category_title'];
        $post_categoryId = $row['category_id']; 
        $post_image = $row['post_image'];
        $post_status = $row['post_status'];
    }
}

//Update POST
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Add post information to table
if (isset($_POST['update'])) {
    $post_title = sanitize($_POST['post-title']);
    $post_status = sanitize($_POST['post-status']);
    $post_content = ($_POST['post-content']);
    $post_category_id = $_POST['post-category-id'];

    $post_image_name = $_FILES['post-image']['name'];
    $post_image_tmp = $_FILES['post-image']['tmp_name'];
    $post_image_path = '../admin/postImages/' . $post_image_name;

    //Checks if the file doesn't exists in the directory to prevent duplicates
    if (file_exists($post_image_path)) {
        echo "File already exists.";
    } else {
        // Move the uploaded file to the destination directory
        if (move_uploaded_file($post_image_tmp, $post_image_path)) {
            exit();
        } else {
            echo "Error moving file.";
        }
    }

    $update_query = 'UPDATE posts SET category_id=?, post_title=?, post_content=?, post_image=?, post_status=? WHERE id=?';
    $update_stmt = $db->prepare($update_query);
    $update_stmt->bind_param('issssi', $post_category_id, $post_title, $post_content, $post_image_name, $post_status, $post_id);
    $update_stmt->execute();

    if (!$update_stmt->errno) {
        // Redirect to a success page
        $status_message = (isset($_POST['update'])) ? 'Post update successful!' : '';
        header("Location: ../admin/success.php?status=" . urlencode($status_message));
        exit();
    }
    $update_stmt->close();
}
?>

<div class="form-container">
    <form action="" method="post" enctype="multipart/form-data">
        <div class="post-title post-view">
            <label for="post-title">Post Title:</label>
            <input type="text" name="post-title" id="post-title"
                value="<?php echo htmlspecialchars(stripslashes($post_title)); ?>">
        </div>

        <div class="options">
            <div class="post-category post-view">
                <label for="post-category">Post Category:</label>
                <select name="post-category-id" id="post-category-id">
                    <option>Select an Option</option>
                    <?php
                    foreach ($categoryResult as $category) {
                        //Check if selected category is equal to category title and assing selected to option
                        $selected = ($post_category == $category['category_title']) ? 'selected' : '';
                        echo "<option value='{$category['id']}' $selected>{$category['category_title']}</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="post-status post-view">
                <label for="post-status">Post Status:</label>
                <select name="post-status" id="post-status">
                    <option>Select an Option</option>
                    <option value="draft" <?php echo ($post_status == 'Draft') ? 'selected' : ''; ?>>Draft</option>
                    <option value="publish" <?php echo ($post_status == 'Publish') ? 'selected' : ''; ?>>Publish</option>
                </select>
            </div>
        </div>

        <div class="post-image post-view">
            <label for="post-image">Post Image:</label>
            <div class="input-img">
                <input type="file" name="post-image" id="post-image" accept="image/*">
                <img id="post-img" src="<?php echo 'postImages/' . $post_image; ?>" alt="post-img" width="270"
                    height="200">
            </div>
        </div>
        <div class="post-content post-view">
            <label for="post-content">Post Content:</label>
            <textarea name="post-content" id="post-content" cols="30" rows="10">
            <?php echo htmlspecialchars(stripslashes($post_content)); ?>
            </textarea>
        </div>

        <div class="submit-btns">
            <input class="btn publish-btn" type="submit" name="update" value="Update Post">
        </div>
    </form>
</div>

<?php include './reusableComponents/footer.php'; ?>