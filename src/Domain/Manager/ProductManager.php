<?php

namespace App\Domain\Manager;

use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use function PHPUnit\Framework\isNull;

class ProductManager
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository
    ) {}

    public function getProductList(): array
    {
        $productList = $this->productRepository->findAll();

        return $productList;
    }

    public function getProduct(int $id): ?Product
    {
        $product = $this->productRepository->findOneById($id);
        return $product;
    }

    public function createProduct(string $name): Product
    {
        $product = new Product();
        $product->setName($name);
        $this->productRepository->save($product);
        return $product;
    }

    public function updateProduct(int $id, string $name): Product
    {
        $product = $this->productRepository->findOneById($id);

        if (isset($name)) {
            $product->setName($name);
        }

        $this->productRepository->save($product);

        return $product;
    }

    public function replaceProduct(int $id, string $name): Product
    {
        $product = $this->productRepository->findOneById($id);

        $product->setName($name);
        $this->productRepository->save($product);

        return $product;
    }

    public function deleteProduct(int $id): void
    {
        $product = $this->productRepository->findOneById($id);

        if (!$product) {
            throw new \DomainException('Product not found');
        }

        $this->productRepository->delete($product);
    }
}