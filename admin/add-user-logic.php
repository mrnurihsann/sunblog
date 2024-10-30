<?php
require 'config/database.php';

// get form data if submitted was clicked
if(isset($_POST['submit'])) {
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $password = filter_var($_POST['password'],  FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);
    $avatar = $_FILES['avatar'];
    
    // validate form data
    if(!$username) {
        $_SESSION['add-user'] = "Please enter a username";
    } elseif (!$email){
        $_SESSION['add-user'] = "Please enter a valid email";
    } elseif (strlen($password) < 8 || strlen($password) < 8) {
        $_SESSION['add-user'] = "Password must be at least 8 characters";
    } elseif (!$avatar['name']) {
        $_SESSION['add-user'] = "Please add a profile picture";
    } else {
        // hash password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        

        // check if username or email already exists
        $user_check_query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
        $user_check_result = mysqli_query($connection, $user_check_query);
        if(mysqli_num_rows($user_check_result) > 0) {
            $_SESSION['add-user'] = "Username or email already exists";
        } else {
            // create avatar
            $time = time(); // get current time
            $avatar_name = $time . $avatar['name'];
            $avatar_tmp_name = $avatar['tmp_name'];
            $avatar_destination_path = '../images/' . $avatar_name;

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
                    $_SESSION['add-user'] = "File size too large";
                }
            } else {
                $_SESSION['add-user'] = "File type not allowed";
            }

        }
    }

    // redirect back to add-user page if there are any errors
    if(isset($_SESSION['add-user'])) {
        // pass form data back to add-user page
        $_SESSION['add-user-data'] = $_POST;
        header('location: ' . ROOT_URL . '/admin/add-user.php');
        die();
    } else {
        // insert user data into database
        $insert_user_query = "INSERT INTO users SET username = '$username', email = '$email', password = '$hashed_password', avatar = '$avatar_name', is_admin = $is_admin";
        $insert_user_result = mysqli_query($connection, $insert_user_query);
        
        if(!mysqli_errno($connection)) {
            // redirect to login page
            $_SESSION['add-user-success'] = "New user $username added success";
            header('location: ' . ROOT_URL . 'admin/manage-users.php');
            die();
        }
    }

} else {
    // if not submitted, redirect to signup page
    header('location: ' . ROOT_URL . 'admin/add-user.php');
    die();
}