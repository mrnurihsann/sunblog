<?php
    include 'partials/header.php';

    // get back edit-user form data if submitted
    if(isset($_GET['id'])) {
        $id = filter_var($_GET['id'], FILTER_SANITIZE_NUMBER_INT);
        $query = "SELECT * FROM users WHERE id=$id";
        $result = mysqli_query($connection, $query);
        $user = mysqli_fetch_assoc($result);
    } else {
        header('location: ' . ROOT_URL . 'admin/manage-users.php');
    die();
    }
?>

<head>
    <link rel="stylesheet" href="../css/add.css">
</head>




    <section class="form__section">
        <div class="container form__section-container">
            <h2>Edit User</h2>
            <form action="<?= ROOT_URL ?>admin/edit-user-logic.php" method="POST">
                <input type="hidden" value="<?= $user['id'] ?>" name="id">
                <input type="text" value="<?= $user['username'] ?>" name="username" placeholder="Username">
                <input type="text" value="<?= $user['email'] ?>" name="email" placeholder="Email">
                <select name="userrole">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <button type="submit" name="submit" class="btn">Update User</button>
            </form>
        </div>
    </section>
    <!-- ================== END OF FORM SECTION ================-->


    <script src="../js/main.js"></script>
</body>

</html>