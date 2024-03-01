<?php
include("./reusableComponents/session.php");
include("../db/db.php");

//Get category_id from categories table
$getCategory_query = 'SELECT * FROM category';
$getCategory_stmt = $db->prepare($getCategory_query);
$getCategory_stmt->execute();
$categoryResult = $getCategory_stmt->get_result();

$options = '';

while ($row = mysqli_fetch_assoc($categoryResult)) {
    $options .= "<option value='{$row['id']}'>{$row['category_title']}</option>";
}

//Get User ID from users table
$user_id = '';

if(isset($user)) {
    $getUser_query = 'SELECT * FROM users WHERE username=?';
    $getUser_stmt = $db->prepare($getUser_query);
    $getUser_stmt->bind_param('s', $user);
    $getUser_stmt->execute();
    $userResult = $getUser_stmt->get_result();
    
    while($row = mysqli_fetch_assoc($userResult)){
        $user_id .= $row['id'];
    }
}

function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = array();

// Add post information to table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $post_title = sanitize($_POST['post-title']);
    $post_status = sanitize($_POST['post-status']);
    $post_content = ($_POST['post-content']);
    $post_category_id = $_POST['post-category-id'];
    $post_date = date('d-m-Y');
    $post_user_id = $user_id;

    $post_image_name = $_FILES['post-image']['name'];
    $post_image_tmp = $_FILES['post-image']['tmp_name'];
    $post_image_path = '../admin/postImages/' . $post_image_name;

    //Checks if the file doesn't exists in the directory to prevent duplicates
    if (!file_exists($post_image_path)) {
        // If file doesn't exist, check if the directory exists, create it if it doesn't
        if (!file_exists('../admin/postImages/')) {
            mkdir('../admin/postImages/', 0777, true);
        }
    
        // Move the uploaded file to the destination directory
        if (move_uploaded_file($post_image_tmp, $post_image_path)) {
            exit();
        } else {
            echo "Error moving file.";
        }
    } else {
        echo "File already exists.";
    }


    // Check which button was clicked
    if (isset($_POST['publish'])) {
        // Publish button was clicked
        $post_status = 'Publish';
    } elseif (isset($_POST['draft'])) {
        // Save as Draft button was clicked
        $post_status = 'Draft';
    }

    $post_query = 'INSERT INTO posts (user_id, category_id, post_title, post_content, post_image, post_date, post_comments_count, post_status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)';

    $post_stmt = $db->prepare($post_query);

    $post_stmt->bind_param('iissssis', $post_user_id, $post_category_id, $post_title, $post_content, $post_image_name, $post_date, $post_comments_count, $post_status);

    $post_stmt->execute();

    if (!$post_stmt->errno) {
        // Redirect to a success page
        $status_message = (isset($_POST['publish'])) ? 'Post published successfully!' : 'Post saved as draft';
        header("Location: ../admin/success.php?status=" . urlencode($status_message));
        exit();
    }
    $post_stmt->close();
}
?>
<?php include './reusableComponents/header.php'; ?>
<div class="form-container">
    <form action="add-posts.php" method="post" enctype="multipart/form-data">
        <div class="post-title post-view">
            <label for="post-title">Post Title:</label>
            <input type="text" name="post-title" id="post-title">
            <?php
            if (!empty($errors['post_title'])) {
                echo '<span class="error-msg">' . $errors['post_title'] . '</span>';
            }
            ?>
        </div>

        <div class="options">
            <div class="post-category post-view">
                <label for="post-category">Post Category:</label>
                <select name="post-category-id" id="post-category-id">
                    <option>Select an Option</option>
                    <?php echo $options; ?>
                </select>
            </div>
            <div class="post-status post-view">
                <label for="post-status">Post Status:</label>
                <select name="post-status" id="post-status">
                    <option>Select an Option</option>
                    <option value="draft">Draft</option>
                    <option value="publish">Publish</option>
                </select>
            </div>
        </div>

        <div class="post-image post-view">
            <label for="post-image">Post Image:</label>
            <div class="input-img">
                <input type="file" name="post-image" id="post-image" accept="image/*">
                <img id="post-img" src="" alt="post-img" width="250" height="200">
            </div>
        </div>
        <div class="post-content post-view">
            <label for="post-content">Post Content:</label>
            <textarea name="post-content" id="post-content" cols="30" rows="10"></textarea>
        </div>

        <div class="submit-btns">
            <input class="btn publish-btn" type="submit" name="publish" value="Publish">
            <input class="btn save-as-btn" type="submit" name="draft" value="Save as draft">
        </div>
    </form>
</div>

<?php include './reusableComponents/footer.php'; ?>