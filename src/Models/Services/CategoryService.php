<?php

namespace App\Models\Services;

use App\Models\Mappers\CategoryMapper;

class CategoryService
{
    private CategoryMapper $categoryMapper;

    public function __construct()
    {
        $this->categoryMapper = new CategoryMapper();
    }

    public function getAllCategories(): array
    {
        return $this->categoryMapper->fetchAll();
    }

    public function getAllCategoriesAssoc(): array
    {
        $categories = $this->getAllCategories();

        $categoriesAssoc = array_reduce($categories, function ($res, $item) {
            $res[$item['category_id']] = $item['category_name'];
            return $res;
        }, []);

        return $categoriesAssoc;
    }

    public function getAllCategoriesAsValues(): array
    {
        $categories = $this->getAllCategories();

        $options = array_map(fn ($cat) => ['label' => $cat['category_name'], 'value' => $cat['category_id']], $categories);

        return [['label' => 'Choose category', 'value' => ''], ...$options];
    }
}
