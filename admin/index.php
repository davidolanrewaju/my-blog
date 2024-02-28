<?php
include './reusableComponents/session.php';
include './reusableComponents/header.php';
include './logic/postCount.php';
include './logic/commentCount.php';
?>
<div class="info-cards">
    <div class="posts-card card">
        <div class="card-img">
            <img src="css/assets/posts.svg" alt="post-icon" width="100" height="100">
        </div>
        <div class="posts-info info">
            <p>Drafts</p>
            <h1><?php echo $totalDraftedPosts; ?></h1>
            <a href="../admin/posts.php?type=drafts">View Details</a>
        </div>
    </div>
    <div class="categories-card card">
        <div class="card-img">
            <img src="css/assets/category.svg" alt="post-icon" width="100" height="100">

        </div>
        <div class="categories-info info">
            <p>Published</p>
            <h1>
                <?php echo $totalPublishedPosts; ?>
            </h1>
            <a href="../admin/posts.php?type=published">View Details</a>
        </div>
    </div>
    <div class="comments-card card">
        <div class="card-img">
            <img src="css/assets/comment.svg" alt="post-icon" width="100" height="100">

        </div>
        <div class="comments-info info">
            <p>Comments</p>
            <h1><?php echo $totalComments; ?></h1>
            <a href="../admin/comments.php">View Details</a>
        </div>
    </div>
</div>
</div>
</div>

<?php include './reusableComponents/footer.php'; ?>