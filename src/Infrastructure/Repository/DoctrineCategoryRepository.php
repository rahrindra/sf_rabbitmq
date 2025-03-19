<?php

namespace App\Infrastructure\Repository;

use App\Domain\Model\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityNotFoundException;

class DoctrineCategoryRepository implements CategoryRepositoryInterface
{
    public function __construct(private readonly EntityManagerInterface $entityManager) {}

    public function findAll(): array
    {
        return $this->entityManager->getRepository(Category::class)->findAll();
    }

    public function findOneById(int $id): Category
    {
        $category =  $this->entityManager->find(Category::class, $id);

        if (!$category instanceof Category) {
            throw new EntityNotFoundException("Category not found with id {$id}");
        }

        return $category;
    }
    public function save(Category $category): void
    {
        try {
            $this->entityManager->persist($category);
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            throw $e;
        }

    }
    public function delete(Category $category): void
    {
        try {
            $this->entityManager->remove($category);
            $this->entityManager->flush();
        } catch (\Throwable $e) {
            throw $e;
        }
    }
}