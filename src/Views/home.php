<?php
$posts = $args['posts'] ?? [];
$categories = $args['categories'] ?? [];

?>

<header class="container-sm">
    <div class="col-md-9 col-lg-7">
        <h1 class="mb-3">Medium is a place to write, read and connect</h1>
        <div class="col-md-10">
            <p class="lead mb-3">It's easy and free to post your thinking on any topic and connect with millions of readers.</p>
            <a class="btn btn-outline-primary" href="/publish">Start Writing</a>
        </div>

    </div>
</header>

<section class="container-sm my-5">
    <h2 class="mb-4 fs-4">Trending on Medium</h2>
    <?php require ROOT_DIR . '/src/Views/template-parts/posts-grid.php' ?>
    <div class="d-flex flex-row-reverse">
        <a class="btn btn-primary" href="/posts">See more articles</a>
    </div>
</section>