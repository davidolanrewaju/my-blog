<?php
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$post_id = isset($_GET['id']) ? $_GET['id'] : null;

$errors = array();


// Add post information to table
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comment_email = sanitize($_POST['comment-email']);
    $comment_content = ($_POST['comment-content']);
    $comment_date = date('d-m-Y');
    $comment_user_id = '';

    if (empty($comment_email)) {
        $errors['comment_email'] = 'Username or email is required';
    }

    //Get User ID from users table
    //--------------------------------------------------------START---------------------------------------------------------

    $getUser_query = 'SELECT * FROM users WHERE username=? OR email=?';
    $getUser_stmt = $db->prepare($getUser_query);
    $getUser_stmt->bind_param('ss', $comment_email, $comment_email);
    $getUser_stmt->execute();
    $userResult = $getUser_stmt->get_result();

    while ($row = mysqli_fetch_assoc($userResult)) {
        $comment_user_id .= $row['id'];
    }
    //Get User ID from users table 
    //---------------------------------------------------------END----------------------------------------------------------
    if (empty($errors)) {
        $post_query = 'INSERT INTO comments (user_id, post_id, comment_content, comment_date) VALUES (?, ?, ?, ?)';
        $post_stmt = $db->prepare($post_query);
        $post_stmt->bind_param('iiss', $comment_user_id, $post_id, $comment_content, $comment_date);

        $post_stmt->execute();
        $post_stmt->close();
    }
}
?>

<div class="comment-section">
    <form action="" method="post">
        <div class="comment-title comment-view">
            <label for="comment-email">Email or Username:</label>
            <input type="text" name="comment-email" id="comment-email" placeholder="Enter your username or password...">
            <?php
            if (!empty($errors['comment_email'])) {
                echo '<span class="error-msg">' . "*" . $errors['comment_email'] . '</span>';
            }
            ?>
        </div>
        <div class="comment-content comment-view">
            <label for="comment-content">Post Content:</label>
            <textarea name="comment-content" id="comment-content" placeholder="Write your comment here..." cols="20"
                rows="5"></textarea>
        </div>

        <div class="submit-btns">
            <input class="btn comment-btn" type="submit" name="comment" value="Comment">
        </div>
    </form>
</div>