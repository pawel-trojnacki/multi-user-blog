<article class="card mb-4">
    <div class="row h-100">
        <div class="col-12 col-md-4 card-image">
            <a href="<?php echo '/post?id=' . $post['post_id'] ?>">
                <img src="<?php echo $post['post_image'] ?>" class="image-cover rounded-start" alt="<?php echo $post['post_title'] ?>">
            </a>
        </div>
        <div class="col-12 col-md-8">
            <div class="card-body">
                <p class="card-text">
                    <small class="text-muted">
                        <a href="<?php echo '/user?id=' . $post['post_author'] ?>">
                            <?php echo $post['user_name'] ?>
                        </a>
                    </small>
                </p>
                <h3 class="card-title fs-6">
                    <a href="<?php echo '/post?id=' . $post['post_id'] ?>">
                        <?php echo $post['post_title'] ?>
                    </a>
                </h3>
                <p class="card-text">
                    <small>
                    <?php echo $post['post_description'] ?>
                    </small>
                </p>
                <p class="card-text">
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
            </div>
        </div>
    </div>
</article>