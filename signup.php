<?php
require 'config/constants.php';

// get back signup form data if submitted
$username = $_SESSION['signup-data']['username'] ?? null;
$email = $_SESSION['signup-data']['email'] ?? null;
$password = $_SESSION['signup-data']['password']  ?? null;

// delete signup data from session
unset($_SESSION['signup-data']);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Website</title>
    <link rel="stylesheet" href="<?= ROOT_URL ?>css/signup.css
    ">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.8/css/line.css">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body>
    <section class="form__section">
        <div class="form-container">
            <p class="title">Create account</p>
            <?php if(isset($_SESSION['signup'])) : ?>
                <div class="alert__overlay"></div>
                    <div class="alert__message error">
                    <p>
                        <?= $_SESSION['signup']; 
                        unset($_SESSION['signup'])    
                        ?>
                    </p>
                </div>
            <?php endif ?>
            <p class="sub-title">Let's get started with your 30 days free trial</p>
            <form action="<?= ROOT_URL ?>signup-logic.php" class="form" enctype="multipart/form-data" method="POST">
                <input type="text" name="username" value="<?= $username ?>" class="input" placeholder="Name">
                <input type="email" name="email" value="<?= $email ?>" class="input" placeholder="Email">
                <input type="password" name="password" value="<?= $password ?>" class="input" placeholder="Password">
                <p class="sub-title">User Avatar</p>
                <input type="file" id="avatar" name="avatar">
                <button type="submit" name="submit" class="form-btn">Create account</button>
            </form>
            <p class="sign-up-label">
                Already have an account?<span class="sign-up-link"><a href="./signin.php">Log in</span>
            </p>
            <div class="buttons-container">
                
                <div class="google-login-button">
                    <i class="uil uil-google unicon"></i>
                    <span>Sign up with Google</span>
                </div>
            </div>
        </div>
    </section>
</body>

</html>