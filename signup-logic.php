<?php
require 'config/database.php';

// get signup form data if submitted
if(isset($_POST['submit'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'],  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $avatar = $_FILES['avatar'];
    
    // validate form data
    if(!$username) {
        $_SESSION['signup'] = "Please enter a username";
    } elseif (!$email){
        $_SESSION['signup'] = "Please enter a valid email";
    } elseif (strlen($password) < 8 || strlen($password) < 8) {
        $_SESSION['signup'] = "Password must be at least 8 characters";
    } elseif (!$avatar['name']) {
        $_SESSION['signup'] = "Please add a profile picture";
    } else {
        // hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        

        // check if username or email already exists
        $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $user_check_result = mysqli_query($connection, $user_check_query);
        if(mysqli_num_rows($user_check_result) > 0) {
            $_SESSION['signup'] = "Username or email already exists";
        } else {
            // create avatar
            $time = time(); // get current time
            $avatar_name = $time . $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination_path = 'images/' . $avatar_name;

            // make sure file is an image
            $allowed_files = ['png',  'jpg', 'jpeg'];
            $extention = explode('.', $avatar_name);
            $extention = end($extention);

            if (in_array($extention, $allowed_files)) {
                // make sure image is not too large
                if ($avatar['size'] < 1000000) {
                    // upload avatar
                    move_uploaded_file($avatar_tmp_name, $avatar_destination_path);
                } else {
                    $_SESSION['signup'] = "File size too large";
                }
            } else {
                $_SESSION['signup'] = "File type not allowed";
            }

        }
    }

    // redirect back to signup page if there are any errors
    if(isset($_SESSION['signup'])) {
        // pass form data back to signup page
        $_SESSION['signup-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signup.php');
        die();
    } else {
        // insert user data into database
        $insert_user_query = "INSERT INTO users SET username = '$username', email = '$email', password = '$hashed_password', avatar = '$avatar_name', is_admin = 0";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        
        if(!mysqli_errno($connection)) {
            // redirect to login page
            $_SESSION['signup-success'] = "Registration successful. Please log in.";
            header('location: ' . ROOT_URL . 'signin.php');
            die();
        }
    }

} else {
    // if not submitted, redirect to signup page
    header('location: ' . ROOT_URL . 'signup.php');
    die();
}