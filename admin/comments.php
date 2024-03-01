<?php include("./reusableComponents/session.php"); ?>
<?php include './reusableComponents/header.php'; ?>

<?php
include("../db/db.php");

$user_id = "";

//$user was gotten from session.php to get the user's name
if (isset($user)) {
    $getUsers_query = "SELECT id FROM users WHERE username=?";

    $getUsers_stmt = $db->prepare($getUsers_query);
    $getUsers_stmt->bind_param("s", $user);
    $getUsers_stmt->execute();
    $usersResult = $getUsers_stmt->get_result();
    
    while($userRow = mysqli_fetch_assoc($usersResult)) {
        $user_id = $userRow["id"];
    }


    $getComments_query = "SELECT comments.*, posts.post_title, users.username
                     FROM comments
                     LEFT JOIN posts ON comments.post_id = posts.id
                     LEFT JOIN users ON comments.user_id = users.id
                     WHERE posts.user_id = ?";

    $getComments_stmt = $db->prepare($getComments_query);
    $getComments_stmt->bind_param("i", $user_id);  // Assuming $user_id is the user's ID
    $getComments_stmt->execute();
    $commentsResult = $getComments_stmt->get_result();
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
            $commentCounter = 1;
            while ($row = mysqli_fetch_assoc($commentsResult)) {
                $comment_id = $row['id'];
                // $postId = $row['post_id'];
                $comment_content = $row['comment_content'];
                // $userId = $row['user_id'];
                $comment_date = $row['comment_date'];
                $username = $row["username"];
                $post_title = $row["post_title"];
                ?>
                <tr>
                    <td class="comment_id">
                        <?php echo $commentCounter; ?>
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
            <?php   $commentCounter++; } ?>
        </tbody>
    </table>
</div>


<?php include './reusableComponents/footer.php'; ?>