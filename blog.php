<?php
include 'partials/header.php';


// fetch all post  from database
$query = "SELECT * FROM posts ORDER BY date_time DESC";
$posts = mysqli_query($connection, $query);

?>



    <section class="search__bar">
        <form action="<?= ROOT_URL ?>seacrh.php" class="container search__bar-container" method="GET">
            <div>
                <i class="uil uil-search search__icon"></i>
                <input type="text" name="search" placeholder="Search for anything">
            </div>
            <button type="submit" class="btn">Go</button>
        </form>
    </section>
    <!-- ================== END OF SEARCH BAR ================= -->



     <section class="posts <?= $featured ? '' : 'section__extra-margin' ?>">
        <div class="container posts__container">
        <?php while ($post = mysqli_fetch_assoc($posts)) : ?>
            <article class="post">
                <div class="post__thumbnail">
                    <img src="./images/<?= $post['thumbnail'] ?>">
                </div>
                <div class="post__info">
                     <?php 
                // fetch category from categories table using category_id
                $category_id = $post['category_id'];
                $category_query = "SELECT * FROM categories WHERE id=$category_id";
                $category_result = mysqli_query($connection, $category_query);
                $category =  mysqli_fetch_assoc($category_result);

                ?>
                    <a href="<?= ROOT_URL ?>category-posts.php?id=<?=  $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>

                    <h3 class="post__title">
                        <a href="<?= ROOT_URL ?>post.php?id=<?= $post['id'] ?>"><?= $post['title'] ?></a>
                    </h3>
                    <p class="post__body">
                        <?= substr($post['body'], 0, 150) ?>...
                    </p>
                    <div class="post__author">
                        <?php
                    // fetch author from users table using author_id
                    $author_id = $post['author_id'];
                    $author_query = "SELECT * FROM users WHERE id=$author_id";
                    $author_result = mysqli_query($connection, $author_query);
                    $author =  mysqli_fetch_assoc($author_result);
                    ?>
                        <div class="post__author-avatar">
                            <img src="./images/<?= $author['avatar'] ?>">
                        </div>
                        <div class="post__author-info">
                             <h5>By: <?= $author['username'] ?></h5>
                            <small>
                                <?= isset($featured['date_time']) ? date("M d, Y - H:i", strtotime($post['date_time'])) : "Tanggal tidak tersedia" ?>

                        </small>
                        </div>
                    </div>
                </div>
            </article>
            <?php endwhile ?>
        </div>
    </section>
    <!-- ================== END OF POSTS =================-->



    <section class="category__buttons">
        <div class="container category__buttons-container">
            <?php 
                $all_categories_query = "SELECT * FROM categories";
                $all_categories = mysqli_query($connection, $all_categories_query);
            
            ?>
            <?php  while($category = mysqli_fetch_assoc($all_categories)): ?>

            <a href="<?= ROOT_URL ?>category-posts.php?id=<?= $category['id'] ?>" class="category__button"><?= $category['title'] ?></a>
            <?php endwhile ?>
        </div>
    </section>
    <!-- ================== END OF CATEGORY BUTTONS =================-->



    <?php
include 'partials/footer.php';
?>