<?php

namespace App\Domain\Repository;

use App\Domain\Model\Category;

interface CategoryRepositoryInterface
{
    public function findAll(): array;
    public function findOneById(int $id): ?Category;
    public function save(Category $category): void;
    public function delete(Category $category): void;
}