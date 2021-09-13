<?php

use App\Components\Pagination;

$user = $args['user'];
$posts = $args['posts'];
$categories = $args['categories'];
$pages = $args['pages'];
$activePage = $args['activePage'];

$isAuthor = $args['isAuthor'] ?? false;

$paginationBaseLink = '/user?id=' . $user['user_id'] . '&page=';

$previous = $activePage > 1 ? $activePage - 1 : null;
$next = $activePage < $pages ? $activePage + 1  : null;

?>

<div class="container-sm">
    <div class="col-md-8 col-xl-7 mx-auto">
        <?php
        require_once ROOT_DIR . '/src/Views/template-parts/user-page-header.php';

        if (!empty($posts)) {
            require_once ROOT_DIR . '/src/Views/template-parts/user-posts-list.php';
        } else {
            echo '<p>User does not have any posts yet</p>';
        }

        if ($pages > 1) {
            $pagination = new Pagination('Uset posts pagination', $paginationBaseLink, $pages, $activePage, $previous, $next);

            $pagination->render();
        }
        ?>
    </div>
</div>