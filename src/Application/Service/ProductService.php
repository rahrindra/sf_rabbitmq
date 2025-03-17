<?php

namespace App\Application\Service;

use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Infrastructure\DTO\ProductDTO;

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

    public function createProduct(array $data): ProductDTO
    {
        $product = new Product();
        $product->setName($data['name']);
        $this->productRepository->save($product);
        return new ProductDTO($product);
    }
}