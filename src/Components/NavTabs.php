<?php

namespace App\Components;

class NavTabs
{
    public function start(): void
    {
        echo '<ul class="nav nav-tabs nav-fill my-4">';
    }

    public function end(): void
    {
        echo '</ul>';
    }

    public function tab(string $link, string $value, bool $active = false): void
    {
        echo '<li class="nav-item">';
        if ($active) {
            echo sprintf('<a class="nav-link active" aria-current="page" href="%s">%s</a>', $link, $value);
        } else {
            echo sprintf('<a class="nav-link" href="%s">%s</a>', $link, $value);
        }
        echo '</li>';
    }
}
