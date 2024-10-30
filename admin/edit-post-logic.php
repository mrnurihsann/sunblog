<?php
require 'config/database.php';

// make sure edit post button was clicked
if (isset($_POST['submit'])) {
    $id = filter_var($_POST['id'], FILTER_SANITIZE_NUMBER_INT);
    $previous_thumbnail_name = filter_var($_POST['previous_thumbnail_name'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $title = filter_var($_POST['title'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $body = filter_var($_POST['body'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $category_id = filter_var($_POST['category'], FILTER_SANITIZE_NUMBER_INT);
    $is_featured = filter_var($_POST['is_featured'], FILTER_SANITIZE_NUMBER_INT);
    $thumbnail = $_FILES['thumbnail'];


    // set is_featured to 0 if is_featured checkbox is not checked
    $is_featured = $is_featured == 1 ?: 0;

    // validate form data
    if (!$title) {
        $_SESSION['edit-post'] = "Please enter a title";
    } elseif (!$category_id) {
        $_SESSION['edit-post'] = "Please enter a category";
    } elseif (!$body) {
        $_SESSION['edit-post'] = "Please enter a body";
    } else {
        // delete existing thumbnail if new thumbnail is uploaded
        if ($thumbnail['name']) {
            $previous_thumbnail_path = '../images/' . $previous_thumbnail_name;
            if ($previous_thumbnail_path) {
                unlink($previous_thumbnail_path);
            }

            // rename image
            $time = time();
            $thumbnail_name = $time . $thumbnail['name'];
            $thumbnail_tmp_name =  $thumbnail['tmp_name'];
            $thumbnail_destination_path =  '../images/' . $thumbnail_name;

            // make sure file is an image
            $allowed_files = ['png', 'jpg',  'jpeg'];
            $extention = explode('.', $thumbnail_name);
            $extention = end($extention);

            if (in_array($extention, $allowed_files)) {
                // make sure image is not too large
                if ($thumbnail['size'] < 2000000) {
                    // upload thumbnail
                    move_uploaded_file($thumbnail_tmp_name, $thumbnail_destination_path);
                } else {
                    $_SESSION['edit-post'] = "File size too large";
                }
            } else {
                $_SESSION['edit-post'] = "File type not allowed";
            }



        }
    }

    if ($_SESSION['edit-post']) {
        // redirect back to edit post page if there is any error
        header('location: ' . ROOT_URL . 'admin/');
        die();
    } else {
        // set is_featured of all posts to 0 if current post is not featured
        if ($is_featured == 1) {
            $zero_all_is_featured_query = "UPDATE posts SET is_featured = 0";
            $zero_all_is_featured_result = mysqli_query($connection, $zero_all_is_featured_query);
        }

        // set thumbnail name if new thumbnail is uploaded
        $thumbnail_to_insert = $thumbnail_name ?? $previous_thumbnail_name;

        $query = "UPDATE posts SET title = '$title', body = '$body', thumbnail = '$thumbnail_to_insert', category_id = $category_id, is_featured = $is_featured WHERE id = $id LIMIT 1";
        $result = mysqli_query($connection, $query);
    }

    if (!mysqli_errno($connection)) {
        $_SESSION['edit-post-success'] = "Post updated successfully";
    }
}

header('location: ' . ROOT_URL . 'admin/');
die();


