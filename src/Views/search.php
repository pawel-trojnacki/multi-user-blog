<?php

use App\Components\Pagination;

$posts = $args['posts'];
$categories = $args['categories'];
$pages = $args['pages'];
$activePage = $args['activePage'];
$query = $args['query'];

$baseLink = '/search?query=' . $query;

$paginationBaseLink = $baseLink . '&page=';

$previous = $activePage > 1 ? $activePage - 1 : null;
$next = $activePage < $pages ? $activePage + 1  : null;

?>

<header class="container-sm">
    <h1><?php echo 'Searching for: ' . $query ?></h1>
</header>

<div class="container-sm my-5">

    <?php
    if (sizeof($posts) > 0) {
        require_once ROOT_DIR . '/src/Views/template-parts/posts-grid.php';
    } else {
        echo '<p>No results found</p>';
    }

    if ($pages > 1) {
        $pagination = new Pagination('Articles pagination', $paginationBaseLink, $pages, $activePage, $previous, $next);

        $pagination->render();
    }
    ?>

</div>