<?php

namespace App\Models\Services;

use App\Models\Entities\PostEntity;
use App\Models\Mappers\PostMapper;

class PostService
{
    private ValidationService $validationService;
    private FileService $fileService;
    private PostMapper $postMapper;

    private const ALLOWED_TAGS = ['<p>', '<strong>', '<em>', '<u>', '<h2>', '<h3>', '<img>', '<pre>', '<li>', '<ol>', '<ul>', '<span>', '<div>', '<br>', '<ins>', '<del>'];
    private const IMAGE_UPLOAD_ERR = 'Something went wrong with the image upload';

    private const WORDS_PER_MINUTE = 250;

    public function __construct()
    {
        $this->validationService = new ValidationService();
        $this->fileService = new FileService();
        $this->postMapper = new PostMapper();
    }

    private function calculateMinutesRead(string $content): int
    {
        $cleanContent = strip_tags($content);
        $wordCount = str_word_count($cleanContent);
        return ceil($wordCount / self::WORDS_PER_MINUTE);
    }

    private function postWithMinutesToRead(array $post): array
    {
        return array_merge($post, ['minutes_read' => $this->calculateMinutesRead(htmlspecialchars_decode($post['post_content']))]);
    }

    private function getOffset(int $page): int
    {
        $offset = ($page - 1) * 4;

        return $offset;
    }

    public function fetchAllByUserId(string $userId, int|string $page): array
    {
        $offset = $this->getOffset($page);
        $posts = $this->postMapper->fetchAllByUserId($userId, $offset);

        return array_map(fn ($post) => $this->postWithMinutesToRead($post), $posts);
    }

    public function fetchTrendingWithAuthor(): array
    {
        $posts = $this->postMapper->fetchTrendingWithAuthor();

        return array_map(fn ($post) => $this->postWithMinutesToRead($post), $posts);
    }

    public function fetchAllWithAuthor(int|string $page): array
    {
        $offset = $this->getOffset($page);
        $posts = $this->postMapper->fetchAllWithAuthor($offset);

        return array_map(fn ($post) => $this->postWithMinutesToRead($post), $posts);
    }

    public function fetchAllWithAuthorByCategoryId(string $categoryId, int|string $page): array
    {
        $offset = $this->getOffset($page);

        $posts = $this->postMapper->fetchAllWithAuthorByCategoryId($categoryId, $offset);

        return array_map(fn ($post) => $this->postWithMinutesToRead($post), $posts);
    }

    public function fetchAllPostsNumber(): int
    {
        return $this->postMapper->fetchAllPostsNumber();
    }

    public function fetchPostsNumberByCategoryId(string $categoryId): int
    {
        return $this->postMapper->fetchPostsNumberByCategoryId($categoryId);
    }

    public function fetchPostsNumberByUserId(string $userId): int
    {
        return $this->postMapper->fetchPostsNumberByUserId($userId);
    }

    public function fetchOneByIdWithAuthor(string $postId): array|false
    {
        $post = $this->postMapper->fetchOneByIdWithAuthor($postId);

        $post['post_content'] = htmlspecialchars_decode($post['post_content']);

        return $this->postWithMinutesToRead($post);
    }

    public function save(array $body, array $image, string $userId): array
    {
        $title = $body['title'] ?? '';
        $category = $body['category'] ?? '';
        $description = $body['description'] ?? '';
        $content = $body['content'] ?? '';

        $errors = $this->validationService->validate([
            'title' => [$title, [
                ValidationService::RULE_REQUIRED,
                [ValidationService::RULE_MIN, 8],
                [ValidationService::RULE_MAX, 50]
            ]],
            'category' => [$category, [
                ValidationService::RULE_REQUIRED,
            ]],
            'description' => [$description, [
                ValidationService::RULE_REQUIRED,
                [ValidationService::RULE_MIN, 10],
                [ValidationService::RULE_MAX, 100]
            ]],
            'content' => [$content, [
                ValidationService::RULE_REQUIRED,
                [ValidationService::RULE_MIN, 1000],
                [ValidationService::RULE_MAX, 65000]
            ]],
            'image' => [$image, [
                ValidationService::RULE_FILE_REQUIRED,
                [ValidationService::RULE_FILE_MAX_SIZE, 500000]
            ]]
        ]);

        $imagePath = $this->fileService->save($image);

        if (!$imagePath) {
            $errors['uploading_file_error'] = self::IMAGE_UPLOAD_ERR;
            return $errors;
        }

        $content = strip_tags($content, self::ALLOWED_TAGS);

        $post = new PostEntity($title, $description, $content, $imagePath, $category, $userId);
        $this->postMapper->save($post);

        return $errors;
    }

    public function updateViewsByPostId(string $postId): void
    {
        $this->postMapper->updateViewsByPostId($postId);
    }
}
