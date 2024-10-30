<?php
    include 'partials/header.php';

    // get back form data if invalid
    $title = $_SESSION['add-category-data']['title'] ?? null;
    $description = $_SESSION['add-category-data']['description'] ?? null;

unset($_SESSION['add-category-data']);
?>

<head>
    <link rel="stylesheet" href="../css/add.css">
</head>




    <section class="form__section">
        <div class="container form__section-container">
            <h2>Add Category</h2>
            <?php if(isset($_SESSION['add-category'])) : ?>

                <div class="alert__message error">
                <p>
                    <?= $_SESSION['add-category'];
                    unset ($_SESSION['add-category'])
                    ?>
                </p>
            </div>
                <?php endif ?>
            <form action="<?= ROOT_URL ?>admin/add-category-logic.php" method="POST" class="form">
                <input type="text" value="<?= $title ?>" name="title" placeholder="Title">
                <input type="text" value="<?= $description ?>" name="description" placeholder="Description">
                <button type="submit" name="submit" class="btn">Add Category</button>
            </form>
        </div>
    </section>
    <!-- ================== END OF FORM SECTION ================-->


    <script src="../js/main.js"></script>
</body>

</html>