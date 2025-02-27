<?php
require 'config/database.php';

if(isset($_POST['submit'])) {
    // get form data
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $description = filter_var($_POST['description'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);

    if(!$title) {
        $_SESSION['add-category'] = "Please enter a title";
    } elseif (!$description) {
        $_SESSION['add-category'] = "Please enter a description";
    }

    // redirect back to add-category page if there are any errors
    if(isset($_SESSION['add-category'])) {
        // pass form data back to add-category page
        $_SESSION['add-category-data'] = $_POST;
        header('location: ' . ROOT_URL . 'admin/add-category.php');
        die();
    } else {
        // insert category data into database
        $query = "INSERT INTO categories (title, description) VALUES  ('$title', '$description')";

        $result = mysqli_query($connection, $query);
        
        if(mysqli_errno($connection)) {
            $_SESSION['add-category'] = "Couldn't add category";
            header('location: ' . ROOT_URL . 'admin/add-category.php');
            die();
        } else {
            // redirect to manage-category page
            $_SESSION['add-category-success'] = "Category $title added successfully";
            header('location: ' . ROOT_URL . 'admin/manage-categories.php');
die();
        }
    }
}

