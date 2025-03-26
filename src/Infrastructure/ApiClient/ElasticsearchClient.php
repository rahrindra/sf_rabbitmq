<?php

namespace App\Infrastructure\ApiClient;

use App\Domain\Model\Product;
use Elastic\Elasticsearch\Client;
use Elastic\Elasticsearch\ClientBuilder;

class ElasticsearchClient
{
    private Client $client;
    private string $index;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setHosts([$_ENV['ELASTICSEARCH_HOST']])
            ->build();
        $this->index = $_ENV['ELASTICSEARCH_INDEX'];
    }

    public function createIndex(): void
    {
        $params = [
            'index' => $this->index,
        ];

        $this->client->indices()->create($params);
    }

    public function searchDocuments(array $query): mixed
    {
        $params = [
            'index' => $this->index,
            'body' => $query,
        ];

        $results = $this->client->search($params)->asArray();

        return $results;
    }

    public function indexDocument(array $data): array
    {
        $params = [
            'index' => $this->index,
            'id' => $data['id'],
            'type' => $data['type'],
            'body' => $data,
        ];
        $response = $this->client->index($params)->asArray();

        return $response;
    }

    public function indexProduct(Product $product): array
    {
        $data = [
            'id' => $product->getId(),
            'type' => 'product',
            'name' => $product->getName(),
            'price' => $product->getPrice(),
            'quantity' => $product->getQuantity(),
        ];

        return $this->indexDocument($data);
    }

}