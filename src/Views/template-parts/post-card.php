<article class="card mb-4">
    <div class="row">
        <div class="col-12 col-md-4">
            <a href="<?php echo '/post?id=' . $post['post_id'] ?>">
                <img src="<?php echo $post['post_image'] ?>" class="image-fix rounded-start" alt="<?php echo $post['post_title'] ?>">
            </a>
        </div>
        <div class="col-12 col-md-8">
            <div class="card-body">
                <p>
                    <small class="text-muted">
                        <a href="<?php echo '/user?id=' . $post['post_author'] ?>">
                            <?php echo $post['user_name'] ?>
                        </a> | <?php echo $post['post_date'] ?>
                    </small>
                </p>
                <h3 class="card-title fs-5">
                    <a href="<?php echo '/post?id=' . $post['post_id'] ?>">
                        <?php echo $post['post_title'] ?>
                    </a>
                </h3>
                <p class="card-text">
                    <?php echo $post['post_description'] ?>
                </p>
                <p>
                    <a href="<?php echo '/category?id=' . $post['post_category'] ?>">
                        <?php echo $categories[$post['post_category']] ?>
                    </a>
                </p>
            </div>
        </div>
    </div>
</article>