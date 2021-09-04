<?php

$post = $args['post'];
$categories = $args['categories'];

?>

<div class="container-sm">
    <div class="col-md-8 col-xl-7 mx-auto">
        <div id="post-wrapper">

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

            <div class="post-content mb-5">
                <?php echo $post['post_content'] ?>
            </div>

        </div>

        <div class="actions mb-5">
            <input type="hidden" name="post_id" id="post-id" value="<?php echo $post['post_id'] ?>">
            <button id="like-button" class="btn">
                <span class="fs-5">
                    <i id="like-thumb" class="bi-hand-thumbs-up"></i>
                </span>
                <span id="likes-number">Loading...</span>
            </button>
            <button id="comments-button" class="btn">
                <span class="fs-5">
                    <i class="bi-chat"></i>
                </span>
                <span id="comments-number">Loading...</span>
            </button>
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
                            <button class="btn btn-small btn-primary" data-toggle="modal" data-target="#comments-modal">Follow</button>
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

<div class="comments-modal hidden" id="comments-modal">

    <aside class="comments-wrapper comments-wrapper-hidden p-5" id="comments-wrapper">
        <div class="comments-title d-flex justify-content-between align-items-center mb-5">
            <h2 class="fs-4">Responses</h2>
            <button class="btn fs-4" id="comments-close-button">
                <i class="bi-x-circle"></i>
            </button>
        </div>
        <div class="mb-4">
            <form action="#" id="comment-form">
                <div class="form-floating mb-3">
                    <textarea class="form-control" name="comment-field" placeholder="Leave a comment here" id="comment-field" style="height: 100px"></textarea>
                    <label for="comment-field">What do you think?</label>
                </div>
                <div class="text-danger mb-2" id="comment-invalid"></div>
                <div class="d-flex flex-row-reverse">
                    <input type="submit" class="btn btn-primary btn-sm" value="Send">
                </div>
            </form>
        </div>
        <div id="comments" class="comments">

        </div>
    </aside>

</div>