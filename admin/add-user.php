<?php
    include 'partials/header.php';

// get back add-user form data if submitted
$username = $_SESSION['add-user-data']['username'] ?? null;
$email = $_SESSION['add-user-data']['email'] ?? null;
$password = $_SESSION['add-user-data']['password'] ?? null;

// delete add-user data from session
unset($_SESSION['add-user-data']);

?>

<head>
    <link rel="stylesheet" href="../css/add.css">
</head>




    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add User</h2>
            <?php if(isset($_SESSION['add-user'])) : ?>
                <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-user'];
                    unset($_SESSION['add-user'])
                    ?>
                 </p>
            </div>
            
            <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-user-logic.php" enctype="multipart/form-data" method="POST">
                <input type="text" name="username" value="<?= $username ?>" placeholder="Username">
                <input type="text" name="email" value="<?= $email ?>" placeholder="Email">
                <input type="password" name="password" value="<?= $password ?>" placeholder="Password">
                <select name="userrole">
                    <option value="0">Author</option>
                    <option value="1">Admin</option>
                </select>
                <div class="form__control">
                    <label for="avatar">Add Avatar</label>
                    <input type="file" id="avatar" name="avatar">
                </div>
                <button type="submit" name="submit" class="btn">Add User</button>
            </form>
        </div>
    </section>
    <!-- ================== END OF FORM SECTION ================-->


    <script src="../js/main.js"></script>
</body>

</html>