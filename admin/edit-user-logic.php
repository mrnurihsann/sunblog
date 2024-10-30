<?php
require 'config/database.php';

if(isset($_POST['submit'])) {

    // get form data
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $username = filter_var($_POST['username'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
    $is_admin = filter_var($_POST['userrole'], FILTER_SANITIZE_NUMBER_INT);

    // validate form data
    if(!$username || !$email) {
        $_SESSION['edit-user'] = "Invalid form data sent";
    } else {
        // update user data in database
        $query = "UPDATE users SET username = '$username', email = '$email', is_admin = $is_admin WHERE id = $id LIMIT 1";
        $result = mysqli_query($connection, $query);

        if(mysqli_errno($connection)) {
            $_SESSION['edit-user'] = "Failed to update user";
        } else {
            $_SESSION['edit-user'] = "User $username updated successfully";
        }
    }
}

header('location: ' . ROOT_URL . 'admin/manage-users.php');
die();