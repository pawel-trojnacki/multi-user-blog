<?php

use App\Components\PostCard;

?>

<div class="row">
    <?php if (sizeof($posts) > 0) {
        foreach ($posts as $post) {
            $postCard = new PostCard($post, $categories);
            $postCard->start(true);

            $postCard->image();

            $postCard->startBody();

            $postCard->title();

            $postCard->description();

            $postCard->info();

            if ($isAuthor) {
                $postCard->startActions();
                $postCard->editButton();
                $postCard->deleteButton();
                $postCard->endActions();
            }

            $postCard->endBody();

            $postCard->end();
        }
    } else {
        echo '<p>There are no posts.</p>';
    } ?>
</div>