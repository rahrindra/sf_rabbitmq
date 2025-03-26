<?php

namespace App\Domain\Manager;

use App\Domain\Repository\ProductSearchRepositoryInterface;

class ProductSearchManager
{
    public function __construct(
        protected ProductSearchRepositoryInterface $productSearchRepository,
    ) {}

    // @todo: à  implementer
    public function fullSearch(?string $name = null, ?float $priceMin = null, ?float $priceMax = null, ?int $quantityMin = null, ?int $quantityMax = null): array
    {
        return [];
    }

    public function searchByName(string $name): array
    {
        $productList = $this->productSearchRepository->searchByName($name);

        return $productList;
    }
}