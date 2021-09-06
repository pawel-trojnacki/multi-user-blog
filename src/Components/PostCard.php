<?php

namespace App\Components;

class PostCard
{
    public function __construct(
        private array $post,
        private array $categories,
        private string $headingTag = 'h3'
    ) {
    }

    public function start(bool $narrow = false): void
    {
        if ($narrow) {
            echo '<div class="col-sm-6 col-xl-4 d-flex align-items-stretch">';
        } else {
            echo '<div class="col-xl-6 d-flex align-items-stretch">';
        }
        echo '<article class="card mb-4">';
    }

    public function end(): void
    {
        echo '</article>';
        echo '</div>';
    }

    public function startRow(): void
    {
        echo '<div class="row h-100">';
    }

    public function endRow(): void
    {
        echo '</div>';
    }


    public function image(bool $col = false): void
    {
        $className = $col ? 'col-12 col-md-4 card-image' : 'card-image';

        echo sprintf('<div class="%s" >', $className);
        echo sprintf('<a href="%s">', '/post?id=' . $this->post['post_id']);
        echo sprintf('<img class="image-cover" src="%s" alt="%s">', $this->post['post_image'], $this->post['post_title']);
        echo '</a>';
        echo '</div>';
    }

    public function startBody(bool $col = false): void
    {
        if ($col) {
            echo '<div class="col-12 col-md-8">';
        }

        echo '<div class="card-body">';
    }

    public function endBody(bool $col = false): void
    {
        echo '</div>';

        if ($col) {
            echo '</div>';
        }
    }

    public function startText(): void
    {
        echo ' <p class="card-text">';
    }

    public function endText(): void
    {
        echo '</p>';
    }

    public function title(): void
    {
        echo sprintf('<%s class="card-title fs-6">', $this->headingTag);
        echo sprintf('<a href="%s">', '/post?id=' . $this->post['post_id']);
        echo $this->post['post_title'];
        echo '</a>';
        echo sprintf('</%s>', $this->headingTag);
    }

    public function description(): void
    {
        $this->startText();
        echo '<small>';
        echo $this->post['post_description'];
        echo '</small>';
        $this->endText();
    }

    public function author(): void
    {
        $this->startText();

        echo '<small class="text-muted">';
        echo sprintf('<a href="%s">', '/user?id=' . $this->post['post_author']);
        echo $this->post['user_name'];
        echo '</a>';
        echo '</small>';

        $this->endText();
    }

    public function info(): void
    {
        $this->startText();

        echo '<small class="text-muted">';
        echo '<span>';
        echo $this->post['post_date'];
        echo '</span> | ';

        echo sprintf('<a href="%s">', '/posts?category=' . $this->post['post_category']);

        echo $this->categories[$this->post['post_category']];

        echo '</a> | ';
        echo '<span>';
        echo $this->post['minutes_read'] . ' min read';
        echo '</span>';
        echo '</small>';

        $this->endText();
    }

    public function actions(): void
    {
        echo  '<div class="d-flex">';
        echo '<a href="#" class="btn">Edit</a>';
        echo '<a href="#" class="btn text-danger">Delete</a>';
        echo '</div>';
    }
}
