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
    <h2 class="mb-4 fs-4">Trending stories</h2>
    <div class="row">
        <?php if (sizeof($posts) > 0) : ?>
            <?php foreach ($posts as $post) : ?>
                <div class="col-xl-6 d-flex align-items-stretch">
                    <?php require ROOT_DIR . '/src/Views/template-parts/post-card.php' ?>
                </div>
            <?php endforeach ?>
        <?php else : ?>
            <p>There are no posts.</p>
        <?php endif ?>
    </div>
</section>