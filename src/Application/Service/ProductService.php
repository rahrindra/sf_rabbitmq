<?php

namespace App\Application\Service;

use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductService
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {}

    public function getProductList(): array
    {
        $productList = $this->productRepository->findAll();

        return $productList;
    }
}