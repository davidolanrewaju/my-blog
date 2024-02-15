<?php
session_start();
//Import database connection
include("db/db.php");

//Sanitize inputs
function sanitize($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = array();


if (isset($_POST['submit'])) {
    $username = sanitize($_POST['username']);
    $password = sanitize($_POST['password']);

    //Check empty username/email field
    if (empty($username)) {
        $errors['username'] = 'Username or email is required';
    }

    //Check empty password fields
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    }

    //Validate user with database info
    if (empty($errors) && isset($db)) {
        $query = 'SELECT * FROM users WHERE username=? OR email=?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('ss', $username, $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $row['username'];
                $_SESSION['email'] = $row['email'];
                header("Location: admin/");
                exit();

            } else {
                $errors['password'] = "Wrong Password";
            }
        } else {
            $errors['username'] = "User does not exist. Try creating an account";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/login.css" />
    <title>Login</title>
</head>

<body>
    <div class="main-container">
        <div class="logo-container">
            <div class="logo">
                <h2>TechInfo</h2>
            </div>
        </div>
        <div class="login-container">
            <div class="login-header">
                <h2 class="welcome-msg">Log In</h2>
                <p>
                    Welcome back! Please login to your account
                </p>
            </div>
            <div class="signup">
                <p>Don't have an account?<a href="signup.php">Sign Up</a></p>
            </div>

            <!-- Login Form -->
            <form class="login-form" action="login.php" method="post">
                <div class="input-section">
                    <div class="input-container">
                        <label for="username">Username/Email</label>
                        <input type="text" name="username" id="username"
                            value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" />
                        <?php
                        if (!empty($errors['username'])) {
                            echo '<span class="error-msg">' . $errors['username'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="input-container">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" />
                        <?php
                        if (!empty($errors['password'])) {
                            echo '<span class="error-msg">' . $errors['password'] . '</span>';
                        }
                        ?>
                    </div>
                </div>
                <input class="login-btn" name="submit" type="submit" value="Log In">
            </form>
            <div class="third-party-login">
                <div class="google-container">
                    <img class="google-logo" src="css/assets/google.svg" alt="google" />
                    <p>SignUp using Google</p>
                </div>
                <div class="facebook-container">
                    <img class="facebook-logo" src="css/assets/facebook.svg" alt="facebook" />
                    <p>SignUp using Facebook</p>
                </div>
            </div>
        </div>
    </div>
</body>

</html>