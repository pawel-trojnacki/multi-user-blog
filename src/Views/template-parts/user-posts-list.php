<div>

    <?php foreach ($posts as $post) : ?>
        <article class="mb-5">
            <a href="<?php echo '/post?id=' . $post['post_id'] ?>">
                <img class="img-fluid mb-3" src="<?php echo $post['post_image'] ?>" alt="">
            </a>
            <a href="<?php echo '/post?id=' . $post['post_id'] ?>">
                <h2 class="fs-4"><?php echo $post['post_title'] ?></h2>
            </a>
            <p><?php echo $post['post_description'] ?></p>
            <div class="text-muted">
                <a href="<?php echo '/posts?category=' . $post['post_category'] ?>">
                    <?php echo $categories[$post['post_category']] ?>
                </a>
                |
                <span><?php echo $post['minutes_read'] ?> min read</span>
            </div>
        </article>
    <?php endforeach ?>
</div>