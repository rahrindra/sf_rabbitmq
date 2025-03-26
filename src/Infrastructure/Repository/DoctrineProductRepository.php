<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use App\Infrastructure\ApiClient\ElasticsearchClient;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;
use Doctrine\ORM\Exception\ORMException;

class DoctrineProductRepository implements ProductRepositoryInterface
{
    public function __construct(
        private readonly EntityManagerInterface $entityManager,
        private readonly ElasticsearchClient $elasticsearchClient
    ) {}

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Product::class)->findAll();
    }

    /**
     * @param int $id
     * @return Product
     *
     * @throws ORMException
     */
    public function findOneById(int $id): Product
    {
        $product =  $this->entityManager->find(Product::class, $id);

        if (!$product instanceof Product) {
            throw new EntityNotFoundException("Product not found with id {$id}");
        }

        return $product;
    }
    public function save(Product $product): void
    {
        try {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
            $this->elasticsearchClient->indexProduct($product);

        } catch (\Throwable $e) {
            throw $e;
        }
    }
    public function delete(Product $product): void
    {
        try {
            $this->entityManager->remove($product);
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            throw $e;
        }
    }

}