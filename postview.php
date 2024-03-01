<?php
include("./db/db.php");

$post_title = '';
$post_content = '';
$post_category = '';
$post_image = '';
$post_comments = '';
$post_date = '';

$post_id = isset($_GET['id']) ? $_GET['id'] : null;

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
        $post_image = $row['post_image'];
        $date = $row['post_date'];

        $dateTime = DateTime::createFromFormat('d-m-Y', $date);

        // Format the DateTime object as words
        $post_date = $dateTime->format('jS F Y');
    }
}
?>

<style>
    .view-img {
        background-image: linear-gradient(to bottom,
                rgba(255, 255, 255, 0),
                rgba(0, 0, 0, 1)), url("<?php echo "./admin/postImages/{$post_image}"; ?>");
        background-size: cover;
        background-position: center;
        height: 300px;
        color: #fff;
        border-radius: 10px;
        margin-bottom: 1.5rem;
        display: grid;
        grid-template-rows: 1fr auto;
    }
</style>

<?php include('./components/navigation.php') ?>

<div class="main-container">
    <section class="view-container">
        <div class="postview-container">
            <div class="view-img">
                <div class="view-header">
                    <h1 class="view-post-title">
                        <?php echo $post_title; ?>
                    </h1>
                    <div class="post-sub-info">
                        <p>
                            <?php echo $post_category; ?>
                        </p>
                        <p>
                            <?php echo $post_date; ?>
                        </p>
                    </div>
                </div>
            </div>
            <div class="view-post-container">

                <div class="view-body">
                    <p>
                        <?php echo nl2br(htmlspecialchars(stripslashes($post_content))); ?>
                    </p>
                </div>
            </div>
        </div>
        <?php include('./comments.php'); ?>
    </section>
    <?php include('./components/sidebar.php'); ?>
</div>