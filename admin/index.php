<?php
session_start();

if (isset($_SESSION['username']) && isset($_SESSION['email'])) {
    $user = $_SESSION['username'];
    $user_email = $_SESSION['email'];
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <title>TechInfo Admin</title>
</head>

<body>
    <div class="main-container">
        <div class="side-nav">
            <div class="logo">
                <h1>TechInfo</h1>
                <p>Admin</p>
            </div>
            <div class="tabs">
                <a class="tab" href="./">Dashboard</a>
                <a class="tab" href="#">Posts</a>
                <a class="tab" href="#">Add Posts</a>
                <a class="tab" href="#">Comments</a>
                <a class="tab" href="#">Categories</a>
                <a class="tab" href="#">Your Profile</a>
            </div>
            <!-- Return user to blog website on logout -->
            <a class="logout-container" href="../">
                <p>Logout</p>
                <img class="logout-icon" src="css/assets/logout.svg" alt="logout-icon">
            </a>
        </div>
        <div class="main-content">
            <div class="top-nav">
                <div class="profile">
                    <div class="profile-img">
                        <img src="css/assets/user-img.jpg" alt="" width="70" height="70">
                    </div>
                    <div class="welcome-msg">
                        <h2>Welcome</h2>
                        <p>
                            <?php echo $user ?>
                        </p>
                    </div>
                </div>
                <div class="search-container">
                    <div class="search-bar">
                        <input type="search" name="search" id="search">
                        <img class="search-icon icon" src="../css/assets/search.svg" alt="search-icon" width="20"
                            height="20">
                    </div>
                    <div class="goto-website">
                        <a href="../">
                            <p>Go to website</p>
                            <img class="icon" src="css/assets/ext-link.svg" alt="ext-link-icon" width="20" height="20">
                        </a>
                    </div>
                </div>
            </div>

            <div class="info-cards">
                <div class="posts-card card">
                    <div class="card-img">
                        <img src="css/assets/posts.svg" alt="post-icon" width="100" height="100">
                    </div>
                    <div class="posts-info info">
                        <p>Posts</p>
                        <h1>12</h1>
                        <a href="#">View Details</a>
                    </div>
                </div>
                <div class="categories-card card">
                    <div class="card-img">
                        <img src="css/assets/category.svg" alt="post-icon" width="100" height="100">

                    </div>
                    <div class="categories-info info">
                        <p>Categories</p>
                        <h1>6</h1>
                        <a href="#">View Details</a>
                    </div>
                </div>
                <div class="comments-card card">
                    <div class="card-img">
                        <img src="css/assets/comment.svg" alt="post-icon" width="100" height="100">

                    </div>
                    <div class="comments-info info">
                        <p>Comments</p>
                        <h1>20</h1>
                        <a href="#">View Details</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="js/active-link.js"></script>
</body>

</html>