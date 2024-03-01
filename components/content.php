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
                $post_id = $row['id'];
                ?>
                <div class="post-container">
                    <?php echo "<img class='post-image' src='./admin/postImages/$post_image' alt='post-image'>"; ?>
                    <a href="./postview.php?id=<?php echo $post_id ?>" class="post-title">
                        <?php echo $post_title; ?>
                    </a>
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