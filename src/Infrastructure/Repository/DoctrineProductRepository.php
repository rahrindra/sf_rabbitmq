<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class DoctrineProductRepository implements ProductRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Product::class)->findAll();
    }
    public function findOneById(int $id): ?Product
    {
        try {
            return $this->entityManager->find(Product::class, $id);
        } catch (\Throwable $e) {
            throw $e;
        }
    }
    public function save(Product $product): void
    {
        try {
            $this->entityManager->persist($product);
            $this->entityManager->flush();
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