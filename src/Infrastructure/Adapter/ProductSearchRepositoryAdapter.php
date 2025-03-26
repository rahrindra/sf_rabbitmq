<?php

namespace App\Infrastructure\Adapter;

use App\Domain\Repository\ProductSearchRepositoryInterface;
use App\Infrastructure\ApiClient\ElasticsearchClient;

class ProductSearchRepositoryAdapter implements ProductSearchRepositoryInterface
{
    public function __construct(
       private ElasticSearchClient $elasticSearchClient,
    ) {}

    public function searchByName(string $name): array
    {
        $query = [
            'query' => [
                'match' => [
                    'name' => $name
                ]
            ]
        ];

        $results = $this->elasticSearchClient->searchDocuments($query);

        return $results;
    }

    public function searchByPrice(?float $min, ?float $max): array
    {
        // TODO: Implement searchByPrice() method.
    }

    public function searchByQuantity(?float $min, ?float $max): array
    {
        // TODO: Implement searchByQuantity() method.
    }
}