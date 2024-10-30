<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    // get form data
    $username_email = filter_var($_POST['username_email'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password  = filter_var($_POST['password'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    // validate form data
    if(!$username_email) {
        $_SESSION['signin'] = "Please enter a username or email";
    } elseif(!$password) {
        $_SESSION['signin'] = "Please enter a password";
    } else {
        // fetch user from database
        $fetch_user_query = "SELECT * FROM users WHERE username = '$username_email' OR email = '$username_email'";
        $fetch_user_result = mysqli_query($connection, $fetch_user_query);

        if (mysqli_num_rows($fetch_user_result) == 1) {
            // convert record into array
            $user_record =  mysqli_fetch_assoc($fetch_user_result);
            $db_password = $user_record['password'];

            // compare form password with database password
            if (password_verify($password, $db_password)) {
                // set session
                $_SESSION['user-id']  = $user_record['id'];
                // set session if user  is admin
                if($user_record['is_admin'] == 1) {
                    $_SESSION['user_is_admin'] = true;
                }

                // redirect to home page
                header('location: ' . ROOT_URL . 'admin/');
            } else {
                $_SESSION['signin'] = "No user found with this username or email";
            }

        } else {
            $_SESSION['signin'] = "Please enter correct username or email and password";
        }
    }

    // if any errors, redirect back to login page
    if(isset($_SESSION['signin'])) {
        $_SESSION['signin-data'] = $_POST;
        header('location: ' . ROOT_URL . 'signin.php');
        die();
    }

} else {
    header('location: ' . ROOT_URL . 'signin.php');
    die();
}