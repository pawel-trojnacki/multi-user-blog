<?php

use App\Components\Pagination;

$posts = $args['posts'];
$categories = $args['categories'];
$title = $args['title'] ?? 'Your Posts';
$isAuthor = $args['isAuthor'] ?? false;
$pages = $args['pages'];
$activePage = $args['activePage'];

$paginationBaseLink = '/user-posts?page=';

$previous = $activePage > 1 ? $activePage - 1 : null;
$next = $activePage < $pages ? $activePage + 1  : null;

?>

<header class="container-sm mb-5">
    <h1><?php echo $title ?></h1>
</header>

<div class="container-sm">
    <?php
    require ROOT_DIR . '/src/Views/template-parts/user-posts-grid.php';
    if ($pages > 1) {
        $pagination = new Pagination('Uset posts pagination', $paginationBaseLink, $pages, $activePage, $previous, $next);

        $pagination->render();
    }
    ?>
</div>