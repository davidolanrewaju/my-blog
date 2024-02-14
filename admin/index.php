<?php 
session_start();

if(isset($_SESSION['username']) && isset($_SESSION['email'])) {
    $user = $_SESSION['username'];
    $user_email = $_SESSION['email'];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Blog - Admin</title>
</head>
<body>
    <h1>Welcome <?php echo $user ?></h1>
</body>
</html>