<?php include("./reusableComponents/session.php"); ?>
<?php include './reusableComponents/header.php'; ?>

<?php
include("../db/db.php");

if (isset($user)) {
    $getPosts_query = "SELECT posts.*, users.username AS user_name, category.category_title
    FROM posts
    LEFT JOIN users ON posts.user_id = users.id
    LEFT JOIN category ON posts.category_id = category.id
    WHERE users.username=?";

    $getPosts_stmt = $db->prepare($getPosts_query);
    $getPosts_stmt->bind_param("s", $user);
    $getPosts_stmt->execute();
    $postsResult = $getPosts_stmt->get_result();
}

?>

<div class="post-table">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Post Title</th>
                <th>Comment</th>
                <th>Username</th>
                <th>Date</th>
                <th class="view"></th>
                <th class="edit"></th>
                <th class="delete"></th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($row = mysqli_fetch_assoc($postsResult)) {
                $post_id = $row['id'];
                $getComments_query = "SELECT * FROM comments WHERE post_id = ?";

                $getComments_stmt = $db->prepare($getComments_query);
                $getComments_stmt->bind_param("i", $post_id);
                $getComments_stmt->execute();
                $commentsResult = $getComments_stmt->get_result();

                while ($row = mysqli_fetch_assoc($commentsResult)) {
                    $comment_id = $row['id'];
                    $postId = $row['post_id'];
                    $comment_content = $row['comment_content'];
                    $userId = $row['user_id'];
                    $comment_date = $row['comment_date'];
                    $username = "";
                    $post_title = "";


                    //Get users using user_id in comments table from users table
                    $getUsername_query = "SELECT username FROM users WHERE id = ?";

                    $getUsername_stmt = $db->prepare($getUsername_query);
                    $getUsername_stmt->bind_param("i", $userId);
                    $getUsername_stmt->execute();
                    $usernameResult = $getUsername_stmt->get_result();
                    while ($userRow = mysqli_fetch_assoc($usernameResult)) {
                        $username .= $userRow["username"];
                    }

                    //Get post title using post_id in comments table from posts table
                    $getPostTitle_query = "SELECT post_title FROM posts WHERE id = ?";

                    $getPostTitle_stmt = $db->prepare($getPostTitle_query);
                    $getPostTitle_stmt->bind_param("i", $postId);
                    $getPostTitle_stmt->execute();
                    $postTitleResult = $getPostTitle_stmt->get_result();
                    while ($postTitleRow = mysqli_fetch_assoc($postTitleResult)) {
                        $post_title .= $postTitleRow["post_title"];
                    }
                }
                ?>
                <tr>
                    <td class="comment_id">
                        <?php echo $comment_id; ?>
                    </td>
                    <td class="post_title">
                        <?php echo $post_title; ?>
                    </td>
                    <td class="comment_content">
                        <?php
                        echo $comment_content;
                        ?>
                    </td>
                    <td class="username">
                        <?php echo $username; ?>
                    </td>
                    <td class="comment_date">
                        <?php echo $comment_date; ?>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>


<?php include './reusableComponents/footer.php'; ?>