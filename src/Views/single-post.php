<?php

$post = $args['post'];
$categories = $args['categories'];

?>

<div class="container-sm">
    <div class="col-md-8 col-xl-7 mx-auto">
        <header>
            <h1 class="mb-3"><?php echo $post['post_title'] ?></h1>
            <p class="lead text-muted"><?php echo $post['post_description'] ?></p>
            <p class="mb-1">
                <small class="text-muted">
                    <a href="<?php echo '/user?id=' . $post['post_author'] ?>">
                        <?php echo $post['user_name'] ?>
                    </a>
                </small>
            </p>
            <p class="mb-4">
                <small class="text-muted">
                    <span>
                        <?php echo $post['post_date'] ?>
                    </span> |
                    <a href="<?php echo '/category?id=' . $post['post_category'] ?>">
                        <?php echo $categories[$post['post_category']] ?>
                    </a> |
                    <span>
                        <?php echo $post['minutes_read'] ?> min read
                    </span>
                </small>
            </p>
        </header>

        <img class="img-fluid mb-5" src="<?php echo $post['post_image'] ?>" alt="">

        <div class="post-content">
            <?php echo $post['post_content'] ?>
        </div>

        <section class="author-info">
            <div class="d-flex">
                <div class="avatar-wrapper">
                    <img class="image-cover avatar" src="<?php echo $post['user_avatar'] ?>" alt="">
                </div>
                <div class="w-100 ps-4">
                    <div class="d-sm-flex w-100 justify-content-between ">
                        <div>
                            <h2 class="fs-6 fw-normal text-muted">Written by</h2>
                            <p class="fs-5">
                                <a href="<?php echo '/user?id=' . $post['post_author'] ?>">
                                    <?php echo $post['user_name'] ?>
                                </a>
                            </p>
                        </div>
                        <div class="mb-3">
                            <button class="btn btn-small btn-primary">Follow</button>
                        </div>
                    </div>
                    <?php if ($post['user_description']) : ?>
                        <p class="text-muted"><?php echo $post['user_description'] ?></p>
                    <?php endif ?>
                </div>

            </div>
        </section>
    </div>
</div>