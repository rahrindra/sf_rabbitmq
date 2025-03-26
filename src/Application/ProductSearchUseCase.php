<?php

namespace App\Application;

use App\Application\DTO\ProductDTO;
use App\Domain\Manager\ProductSearchManager;

class ProductSearchUseCase
{
    public function __construct(
        protected ProductSearchManager $productSearchManager,
    ) {}

    public function searchProductByName(array $data): array
    {
        $results = $this->productSearchManager->searchByName($data['name']);
        $productList = $results['hits']['hits'] ?? null;

        $productListDTO = [];
        foreach ($productList as $product) {


            $productDTO = new ProductDTO(
                id: $product['_id'],
                name: $product['_source']['name'],
                price: $product['_source']['price'],
                quantity: $product['_source']['quantity']
            );

            $productListDTO[] = $productDTO;
        }
        return $productListDTO;
    }
}