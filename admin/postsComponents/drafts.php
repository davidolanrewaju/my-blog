<?php
include("../db/db.php");

$post_id = '';
$post_title = '';
$post_content = '';
$post_category = '';
$post_image = '';
$post_comments = '';
$post_date = '';
$draft_keyword = 'Draft';

if (isset($user)) {
    $getPosts_query = "SELECT posts.*, users.username AS user_name, category.category_title
    FROM posts
    LEFT JOIN users ON posts.user_id = users.id
    LEFT JOIN category ON posts.category_id = category.id
    WHERE users.username=? AND posts.post_status=?";

    $getPosts_stmt = $db->prepare($getPosts_query);
    $getPosts_stmt->bind_param("ss", $user, $draft_keyword);
    $getPosts_stmt->execute();
    $postsResult = $getPosts_stmt->get_result();
}

?>

<div class="posts-container">
    <nav class="posts-nav">
        <a class="post-sub-link" href="?type=published">Published</a>
        <a id="drafts-link" class="post-sub-link" href="?type=drafts">Drafts</a>
    </nav>
</div>

<div class="post-table">
    <table>
        <thead>
            <tr>
                <th>Id</th>
                <th>Title</th>
                <th>Content</th>
                <th>Category</th>
                <th>Image</th>
                <th>Comments</th>
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
                $post_title = $row['post_title'];
                $post_content = $row['post_content'];
                $post_category = $row['category_title'];
                $post_image = $row['post_image'];
                $post_comments = $row['post_comments_count'];
                $post_date = $row['post_date'];
                ?>
                <tr>
                    <td class="post_id">
                        <?php echo $post_id; ?>
                    </td>
                    <td class="post_title">
                        <?php echo $post_title; ?>
                    </td>
                    <td class="post_content">
                        <?php
                        $words = explode(' ', $post_content);
                        $trimmed_content = implode(' ', array_slice($words, 0, 20)) . '...';
                        echo $trimmed_content;
                        ?>
                    </td>
                    <td class="post_category">
                        <?php echo $post_category; ?>
                    </td>
                    <td class="post_img">
                        <?php echo "<img src='postImages/$post_image' alt='post-image' width='50' height='50'>"; ?>
                    </td>
                    <td class="post_comment">
                        <?php echo $post_comments; ?>
                    </td>
                    <td class="post_date">
                        <?php echo $post_date; ?>
                    </td>
                    <td class="icon-link">
                        <a href="?type=view&p_id=<?php echo $post_id; ?>">
                            <img class="view-icon" src="../admin/css/assets/view.svg" alt="" width="25" height="25">
                        </a>
                    </td>
                    <td class="icon-link">
                        <a href="?type=edit&p_id=<?php echo $post_id; ?>">
                            <img class="edit-icon" src="../admin/css/assets/edit.svg" alt="" width="23" height="23">
                        </a>
                    </td>
                    <td class="icon-link">
                        <a href="#">
                            <img class="delete-icon" src="../admin/css/assets/delete.svg" alt="" width="23" height="23">
                        </a>
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
