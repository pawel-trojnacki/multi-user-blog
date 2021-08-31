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

        <img class="img-fluid" src="<?php echo $post['post_image'] ?>" alt="">

        <div class="post-content my-5">
            <?php echo $post['post_content'] ?>
        </div>
    </div>
</div>