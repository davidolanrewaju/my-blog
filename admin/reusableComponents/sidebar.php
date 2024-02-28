<?php 
$type = isset($_GET['type']) ? $_GET['type'] : 'drafts';
$post_id = isset($_GET['p_id']) ? $_GET['p_id'] : null;
$types = array('view', 'edit', 'drafts', 'published');
?>

<div class="side-nav">
    <div class="logo">
        <h1>TechInfo</h1>
        <p>Admin</p>
    </div>
    <div class="tabs">
        <a class="tab" href="./">Dashboard</a>
        <?php
        // Loop through types and generate links dynamically
        foreach ($types as $postType) {
            $isActive = ($type == $postType) ? 'active' : ''; // Apply a different style for the active link

            $link = ($postType == 'view' || $postType == 'edit') ? "posts.php?type=$postType&p_id=$post_id" : "posts.php?type=$postType";
        }
        echo "<a class='tab $isActive' href='$link'>Posts</a>";
        ?>
        <a class="tab" href="add-posts.php">Add Posts</a>
        <a class="tab" href="comments.php" data-id="p_id">Comments</a>
        <a class="tab" href="profile.php">Your Profile</a>
    </div>
    <!-- Return user to blog website on logout -->
    <a class="logout-container" href="logout.php">
        <p>Logout</p>
        <img class="logout-icon" src="css/assets/logout.svg" alt="logout-icon">
    </a>
</div>