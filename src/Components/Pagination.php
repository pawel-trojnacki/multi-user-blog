<?php

namespace App\Components;

class Pagination
{
    public function __construct(
        private string $ariaLabel,
        private string $baseLink,
        private int $pages,
        private int $activePage,
        private int|null $previous,
        private int|null $next,
    ) {
    }

    private function start(): void
    {
        echo '<nav class="my-4" aria-label="Posts pagination">';
        echo '<ul class="pagination">';
    }

    private function end(): void
    {
        echo '</ul>';
        echo '</nav>';
    }

    private function previous(): void
    {
        $className = $this->previous ? 'page-item' : 'page-item disabled';
        $link = $this->previous ? $this->baseLink . $this->previous : '#';

        echo sprintf('<li class="%s">', $className);
        echo sprintf('<a class="page-link" href="%s" aria-label="Previous page">', $link);

        echo '<span aria-hidden="true">&laquo;</span>';

        echo '</a>';
        echo '</li>';
    }

    private function next(): void
    {
        $className = $this->next ? 'page-item' : 'page-item disabled';
        $link = $this->next ? $this->baseLink . $this->next : '#';

        echo sprintf('<li class="%s">', $className);
        echo sprintf('<a class="page-link" href="%s" aria-label="Next page">', $link);

        echo '<span aria-hidden="true">&raquo;</span>';

        echo '</a>';
        echo '</li>';
    }

    private function pageItem(int $page): void
    {
        $className = $page == $this->activePage ? 'page-item active' : 'page-item';
        $link = $this->baseLink . $page;

        echo sprintf('<li class="%s" >', $className);
        echo sprintf('<a class="page-link" href="%s">', $link);

        echo $page;

        echo '</a>';
        echo '</li>';
    }

    public function render(): void
    {
        $this->start();
        $this->previous();
        for ($page = 1; $page <= $this->pages; $page++) {
            $this->pageItem($page);
        }
        $this->next();
        $this->end();
    }
}
