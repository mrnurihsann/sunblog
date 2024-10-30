<?php
require 'config/constants.php';

$username_email = $_SESSION['signin-data']['username_email'] ?? null;
$password = $_SESSION['signin-data']['password']  ?? null;



unset($_SESSION['signin-data']);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/signin.css
    ">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <section class="form__section">
        <div class="form-container">
            <p class="title">Welcome back</p>
             <?php if(isset($_SESSION['signup-success'])) : ?>
                <div class="alert__overlay"></div>
                    <div class="alert__message success">
                    <p>
                        <?= $_SESSION['signup-success']; 
                        unset($_SESSION['signup-success'])    
                        ?>
                    </p>
                </div>
            <?php elseif(isset($_SESSION['signin'])) : ?>
             <div class="alert__overlay"></div>
                    <div class="alert__message error">
                    <p>
                        <?= $_SESSION['signin']; 
                        unset($_SESSION['signin'])    
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <form class="form" action="<?= ROOT_URL ?>signin-logic.php" method="POST">
                <input type="text" name="username_email" value="<?= $username_email ?>" class="input" placeholder="Username or Email">
                <input type="password" name="password" value="<?= $password ?>" class="input" placeholder="Password">
                <p class="page-link">
                    <span class="page-link-label">Forgot Password?</span>
                </p>
                <button type="submit" name="submit" class="form-btn">Log in</button>
            </form>
            <p class="sign-up-label">
                Don't have an account?<span class="sign-up-link"><a href="./signup.php">Sign up</span>
            </p>
            <div class="buttons-container">
                <div class="apple-login-button">
                    <!-- Unicons icon untuk Apple -->
                    <i class="uil uil-apple unicon"></i>
                    <span>Log in with Apple</span>
                </div>
                <div class="google-login-button">
                    <!-- Unicons icon untuk Google -->
                    <i class="uil uil-google unicon"></i>
                    <span>Log in with Google</span>
                </div>
            </div>
        </div>
    </section>
</body>

</html>