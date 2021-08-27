<?php

namespace App\Models\Mappers;

use App\Core\App;

class CategoryMapper
{
    public function fetchAll(): array
    {
        $pdo = App::$database->connection();
        $statement = $pdo->prepare(
            'SELECT * FROM categories;'
        );
        $statement->execute();
        return $statement->fetchAll();
    }
}
