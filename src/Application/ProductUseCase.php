<?php

namespace App\Application;

use App\Application\DTO\ProductDTO;
use App\Domain\Manager\ProductManager;

class ProductUseCase
{
    public function __construct(
        private readonly ProductManager $productManager
    ) {}

    public function getProductList(): array
    {
        $productList = $this->productManager->getProductList();
        return $productList;
    }

    public function getProductDetails(int $id): ProductDTO
    {
        $product = $this->productManager->getProduct(id: $id);
        return new ProductDTO($product);
    }

    public function createProduct(array $data): ProductDTO
    {
        $product = $this->productManager->createProduct(name: $data['name']);
        return new ProductDTO($product);
    }

    public function updateProduct(int $productId, array $data): ProductDTO
    {
        $product = $this->productManager->replaceProduct(id: $productId, name: $data['name']);
        return new ProductDTO($product);
    }

    public function replaceProduct(int $productId, array $data): ProductDTO
    {
        $product = $this->productManager->replaceProduct(id: $productId, name: $data['name']);
        return new ProductDTO($product);
    }

    public function deleteProduct(int $productId): void
    {
        $this->productManager->deleteProduct(id: $productId);
    }
}