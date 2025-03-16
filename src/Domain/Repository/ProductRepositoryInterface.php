<?php

namespace App\Domain\Repository;

use App\Domain\Model\Product;

interface ProductRepositoryInterface
{
    public function findAll(): array;
    public function findOneById(int $id): ?Product;
    public function save(Product $product): void;
    public function update(Product $product): void;
}