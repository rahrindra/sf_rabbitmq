<?php

namespace App\Domain\Manager;

use App\Domain\Model\Product;
use App\Domain\Repository\CategoryRepositoryInterface;
use App\Domain\Repository\ProductRepositoryInterface;

class ProductManager
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
        private readonly CategoryRepositoryInterface $categoryRepository
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

    public function createProduct(string $name, float $price, int $quantity, ?int $categoryId): Product
    {
        $product = new Product();
        $product->setName($name)
            ->setPrice($price)
            ->setQuantity($quantity);
        ;

        if (!is_null($categoryId)) {
            $category = $this->categoryRepository->findOneById($categoryId);
            $product->setCategory($category);
        }

        $this->productRepository->save($product);
        return $product;
    }

    public function updateProduct(int $id, ?string $name,  ?float $price, ?int $quantity, ?int $categoryId): Product
    {
        $product = $this->productRepository->findOneById($id);

        if (!is_null($name) && strlen($name) > 0) {
            $product->setName($name);
        }
        if (!is_null($price)) {
            $product->setPrice($price);
        }
        if (!is_null($quantity)) {
            $product->setQuantity($quantity);
        }
        if (!is_null($categoryId)) {
            $category = $this->categoryRepository->findOneById($categoryId);
            $product->setCategory($category);
        }
        $this->productRepository->save($product);

        return $product;
    }

    public function replaceProduct(int $id, string $name, float $price, int $quantity, ?int $categoryId): Product
    {
        $product = $this->productRepository->findOneById($id);

        $product->setName($name)
            ->setPrice($price)
            ->setQuantity($quantity)
        ;

        if (!is_null($categoryId)) {
            $category = $this->categoryRepository->findOneById($categoryId);
            $product->setCategory($category);
        } else {
            $product->setCategory(null);
        }
        $this->productRepository->save($product);

        return $product;
    }

    public function deleteProduct(int $id): void
    {
        $product = $this->productRepository->findOneById($id);
        $this->productRepository->delete($product);
    }
}