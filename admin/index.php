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
                <a class="tab" href="index.php">Dashboard</a>
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
                <h1>Welcome</h1>
                <p>
                    <?php echo $user ?>
                </p>
            </div>
        </div>
    </div>

    <script src="js/active-link.js"></script>
</body>

</html>