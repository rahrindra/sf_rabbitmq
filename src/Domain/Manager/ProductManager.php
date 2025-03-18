<?php

namespace App\Domain\Manager;

use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use function PHPUnit\Framework\isEmpty;
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

    public function createProduct(string $name, float $price, int $quantity): Product
    {
        $product = new Product();
        $product->setName($name)
            ->setPrice($price)
            ->setQuantity($quantity);
        ;

        $this->productRepository->save($product);
        return $product;
    }

    public function updateProduct(int $id, ?string $name,  ?float $price, ?int $quantity): Product
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
        $this->productRepository->save($product);

        return $product;
    }

    public function replaceProduct(int $id, string $name, float $price, int $quantity): Product
    {
        $product = $this->productRepository->findOneById($id);

        $product->setName($name)
            ->setPrice($price)
            ->setQuantity($quantity)
        ;
        $this->productRepository->save($product);

        return $product;
    }

    public function deleteProduct(int $id): void
    {
        $product = $this->productRepository->findOneById($id);
        $this->productRepository->delete($product);
    }
}