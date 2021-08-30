<?php
$posts = $args['posts'] ?? [];
$categories = $args['categories'] ?? [];

?>

<div class="container-sm">
    <h1 class="col-md-7">Medium is a place to write, read and connect</h1>
</div>

<div class="container-sm my-5">
    <h2 class="mb-4">Trending stories</h2>
    <div class="row">
        <div class="col-md-8">
            <?php if (sizeof($posts) > 0) : ?>
                <?php foreach ($posts as $post) {
                    require ROOT_DIR . '/src/Views/template-parts/post-card.php';
                }
                ?>
            <?php else : ?>
                <p>There are no posts.</p>
            <?php endif ?>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>