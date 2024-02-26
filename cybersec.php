<?php
include(__DIR__ . "/db/db.php");

$post_title = '';
$post_content = '';
$post_category = '';
$post_image = '';
$post_comments = '';
$post_date = '';
$post_author = '';

$category_title = 'Cybersecurity';

$getPosts_query = "SELECT posts.*, users.username AS user_name, category.category_title
    FROM posts
    LEFT JOIN users ON posts.user_id = users.id
    LEFT JOIN category ON posts.category_id = category.id
    WHERE category_title=?";

$getPosts_stmt = $db->prepare($getPosts_query);
$getPosts_stmt->bind_param("s", $category_title);
$getPosts_stmt->execute();
$postsResult = $getPosts_stmt->get_result();
?>

<?php include('./components/navigation.php'); ?>

<div class="hero-container">
    <div class="hero-content-container">
        <h1 class="hero-title">Explore the Boundless Horizons of Knowledge</h1>
        <h2 class="hero-subtitle">Your Gateway to Inspiration, Insight, and Imagination</h2>
        <p class="hero-content">Welcome to TechInfo, where curiosity meets content, and exploration knows no bounds.
            Embark on a journey with us as we navigate through the vast landscapes of ideas, insights, and
            imagination.</p>
        <h3 class="hero-motto">Discover. Learn. Inspire.</h3>
    </div>
</div>

<div class="main-container">
    <section class="articles-container">
        <h2>Latest Posts</h2>
        <hr class="underline">
        <div class="post-list">
            <?php
            while ($row = mysqli_fetch_assoc($postsResult)) {
                $post_title = $row['post_title'];
                $post_content = $row['post_content'];
                $post_category = $row['category_title'];
                $post_image = $row['post_image'];
                $post_author = $row['user_name'];
                $post_date = $row['post_date'];
                ?>
                <div class="post-container">
                    <?php echo "<img class='post-image' src='./admin/postImages/$post_image' alt='post-image'>"; ?>
                    <h3 class="post-title">
                        <?php echo $post_title; ?>
                    </h3>
                    <p class="post-content">
                        <?php echo $post_content; ?>
                    </p>
                    <div class="post-footer">
                        <img class="post-footer-img" src="css/assets/retrosupply.jpg" alt="profile-pic" width="30"
                            height="30">
                        <div class="post-footer-content">
                            <p class="post-author">
                                <?php echo $post_author; ?>
                            </p>
                            <p class="post-date">
                                <?php echo $post_date; ?>
                            </p>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </section>

    <?php include('./components/sidebar.php'); ?>

    <?php include('./components/footer.php'); ?>