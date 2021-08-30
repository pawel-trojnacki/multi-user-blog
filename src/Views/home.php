<?php
$posts = $args['posts'] ?? [];
?>

<div class="container-sm">
    <h1 class="col-md-7">Medium is a place to write, read and connect</h1>
</div>


<div class="container-sm my-5">
    <h2 class="mb-4">Trending stories</h2>
    <div class="row">
        <div class="col-md-8">
            <?php if (sizeof($posts) > 0) : ?>
                <?php foreach ($posts as $post) : ?>
                    <article class="card mb-4">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <img src="<?php echo $post['post_image'] ?>" class="image-fix rounded-start" alt="<?php echo $post['post_title'] ?>">
                            </div>
                            <div class="col-12 col-md-8">
                                <div class="card-body">
                                    <p>
                                        <small class="text-muted">
                                            <?php echo $post['user_name'] ?> | <?php echo $post['post_create_date'] ?>
                                        </small>
                                    </p>
                                    <h3 class="card-title fs-5">
                                        <?php echo $post['post_title'] ?>
                                    </h3>
                                    <p class="card-text">
                                        <?php echo $post['post_description'] ?>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </article>
                <?php endforeach ?>
            <?php else : ?>
                <p>There are no posts.</p>
            <?php endif ?>
        </div>
        <div class="col-md-4"></div>
    </div>
</div>