<?php

use App\Components\PostCard;

?>

<div class="row">
    <?php if (sizeof($posts) > 0) {
        foreach ($posts as $post) {
            $postCard = new PostCard($post, $categories);
            $postCard->start();
            $postCard->startRow();

            $postCard->image(true);

            $postCard->startBody(true);

            $postCard->author();

            $postCard->title();

            $postCard->description();

            $postCard->info();

            $postCard->endBody(true);

            $postCard->endRow();

            $postCard->end();
        }
    } else {
        echo '<p>There are no posts.</p>';
    } ?>
</div>