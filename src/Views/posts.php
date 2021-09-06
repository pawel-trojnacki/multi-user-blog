<?php

use App\Components\Pagination;

$title = $args['title'];
$posts = $args['posts'];
$categories = $args['categories'];
$category = $args['category'];
$pages = $args['pages'];
$activePage = $args['activePage'];

$baseLink = $category ? '/posts?category=' . $category : '/posts';

$paginationBaseLink = $category ? $baseLink . '&page=' : $baseLink . '?page=';

$previous = $activePage > 1 ? $activePage - 1 : null;
$next = $activePage < $pages ? $activePage + 1  : null;

?>

<header class="container-sm">
    <h1><?php echo $title ?></h1>
</header>

<div class="container-sm my-5">

    <?php require ROOT_DIR . '/src/Views/template-parts/posts-grid.php';

    if ($pages > 1) {
        $pagination = new Pagination('Articles pagination', $paginationBaseLink, $pages, $activePage, $previous, $next);

        $pagination->render();
    }
    ?>

</div>