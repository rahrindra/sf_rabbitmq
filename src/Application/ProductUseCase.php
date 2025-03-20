<?php

namespace App\Application;

use App\Application\DTO\ProductDTO;
use App\Domain\Manager\ProductManager;
use Symfony\Component\HttpFoundation\JsonResponse;

class ProductUseCase
{
    const INVALID_ARGUMENT = "Invalid Argument";

    public function __construct(
        private readonly ProductManager $productManager
    ) {}

    public function getProductList(): array
    {
        $productList = $this->productManager->getProductList();
        $productListDTO = [];
        foreach ($productList as $product) {
            $productDTO = new ProductDTO($product);
            $productListDTO[] = $productDTO;
        }
        return $productListDTO;
    }

    public function getProductDetails(int $id): ProductDTO
    {
        $product = $this->productManager->getProduct(id: $id);
        return new ProductDTO($product);
    }

    public function createProduct(array $data): ProductDTO
    {
        if(!$this->isProductDataInputValid($data)) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT);
        }

        $product = $this->productManager->createProduct(name: $data['name'], price: $data['price'], quantity: $data['quantity'], categoryId: $data['category']);
        return new ProductDTO($product);
    }

    public function updateProduct(int $productId, array $data): ProductDTO
    {
        if(!$this->isProductDataInputValid($data)) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT);
        }

        $product = $this->productManager->updateProduct(
            id: $productId,
            name: $data['name'],
            price: $data['price'],
            quantity: $data['quantity'],
            categoryId: $data['categoryId']
        );
        return new ProductDTO($product);
    }

    public function replaceProduct(int $productId, array $data): ProductDTO
    {
        if(!$this->isProductDataInputValid($data)) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT);
        }

        $product = $this->productManager->replaceProduct(
            id: $productId,
            name: $data['name'],
            price: $data['price'],
            quantity: $data['quantity'],
            categoryId: $data['categoryId']
        );
        return new ProductDTO($product);
    }

    public function deleteProduct(int $productId): void
    {
        $this->productManager->deleteProduct(id: $productId);
    }

    /**
     * @description Vérifie les arguments d'entrée envoyés
     *
     * @param array $data
     *
     * @return bool
     */
    public function isProductDataInputValid(array $data): bool
    {
        if(!array_key_exists('name', $data) ||
            !array_key_exists('price', $data) ||
            !array_key_exists('quantity', $data)
        ) {
            return false;
        }
        return true;
    }
}