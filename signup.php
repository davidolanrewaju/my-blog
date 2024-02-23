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
    $email = sanitize($_POST['email']);
    $password = sanitize($_POST['password']);
    $confirm_password = sanitize($_POST['confirm-pwd']);

    //Validate form  password
    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 6) {
        $errors['password'] = 'Password should be at least 6 characters';
    } elseif (!preg_match('/[A-Z]/', $password) || !preg_match('/[0-9]/', $password) || !preg_match('/[^a-zA-Z0-9]/', $password)) {
        $errors['password'] = 'Password should contain at least one capital letter, number and special character';
    }

    //Validate confirm password
    if (empty($password)) {
        $errors['confirm_password'] = 'Please confirm password';
    } else if ($password != $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    //Validate for email
    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    } elseif (isset($db)) {
        $query = 'SELECT * FROM users WHERE email=?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['email'] = 'Email already exists';
        }
        $stmt->close();
    } else {
        die('Database connection not available');
    }

    //Validate form username
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (isset($db)) {
        $query = 'SELECT * FROM users WHERE username=?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();

        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $errors['username'] = 'Username already exists';
        }
        $stmt->close();
    } else {
        die('Database connection not available');
    }

    //Add Users in the absence of errors
    if (empty($errors)) {
        $hashed_password = password_hash($password, PASSWORD_BCRYPT);
        $query = 'INSERT INTO users (username, email, password) VALUES (?, ?, ?)';
        $stmt = $db->prepare($query);
        $stmt->bind_param('sss', $username, $email, $hashed_password);
        $stmt->execute();

        //Close connection and database
        $stmt->close();
        $db->close();

        echo 'User Registered Successfully';
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        header("Location: admin/");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="css/signup.css" />
    <title>Sign Up</title>
</head>

<body>
    <div class="main-container">
        <div class="logo-container">
            <div class="logo">
                <h2>TechInfo</h2>
            </div>
        </div>
        <div class="signup-container">
            <div class="signup-header">
                <h2 class="welcome-msg">Welcome to TechInfo</h2>
                <p>
                    Let's ensure everything is prepared for you, initiating the
                    commencement of your exploration into the realm of knowledge.
                </p>
            </div>
            <div class="signin">
                <p>Already have an account?<a href="login.php">Log In</a></p>
            </div>
            <form class="signup-form" action="signup.php" method="post">
                <div class="input-section">
                    <div class="input-container">
                        <label for="username">Username</label>
                        <input type="text" name="username" id="username" value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>"/>
                        <?php
                        if (!empty($errors['username'])) {
                            echo '<span class="error-msg">' . $errors['username'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="input-container">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" />
                        <?php
                        if (!empty($errors['email'])) {
                            echo '<span class="error-msg">' . $errors['email'] . '</span>';
                        }
                        ?>
                    </div>
                </div>
                <div class="input-section">
                    <div class="input-container">
                        <label for="password">Password</label>
                        <input type="password" name="password" id="password" value="<?php echo isset($_POST['password']) ? htmlspecialchars($_POST['password']) : ''; ?>"/>
                        <?php
                        if (!empty($errors['password'])) {
                            echo '<span class="error-msg">' . $errors['password'] . '</span>';
                        }
                        ?>
                    </div>
                    <div class="input-container">
                        <label for="confirm-pwd">Confirm Password</label>
                        <input type="password" name="confirm-pwd" id="confirm-pwd" value="<?php echo isset($_POST['confirm_pwd']) ? htmlspecialchars($_POST['confirm_pwd']) : ''; ?>"/>
                        <?php
                        if (!empty($errors['confirm_password'])) {
                            echo '<span class="error-msg">' . $errors['confirm_password'] . '</span>';
                        }
                        ?>
                    </div>
                </div>
                <input class="signup-btn" name="submit" type="submit" value="Create Account">
            </form>
            <div class="third-party-login">
                <div class="google-container">
                    <img class="google-logo" src="css/assets/google.svg" alt="google" width="40" height="40"/>
                    <p>Sign Up using Google</p>
                </div>
                <div class="facebook-container">
                    <img class="facebook-logo" src="css/assets/facebook.svg" alt="facebook" width="40" height="40"/>
                    <p>Sign Up using Facebook</p>
                </div>

            </div>
        </div>
    </div>
    </div>
</body>

</html>