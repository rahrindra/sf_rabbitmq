<?php

namespace App\Domain\Manager;

use App\Domain\Model\Category;
use App\Domain\Repository\CategoryRepositoryInterface;

class CategoryManager
{
    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {}

    public function getCategoryList(): array
    {
        $categoryList = $this->categoryRepository->findAll();

        return $categoryList;
    }

    public function getCategoryDetails(int $id): ?Category
    {
        $category = $this->categoryRepository->findOneById($id);
        return $category;
    }

    public function createCategory(string $name, string $reference): Category
    {
        $category = new Category();
        $category->setName($name)
            ->setReference($reference)
        ;

        $this->categoryRepository->save($category);
        return $category;
    }

    public function updateCategory(int $id, ?string $name,  ?string $reference): Category
    {
        $category = $this->categoryRepository->findOneById($id);

        if (!is_null($name) && strlen($name) > 0) {
            $category->setName($name);
        }
        if (!is_null($reference)) {
            $category->setReference($reference);
        }
        $this->categoryRepository->save($category);

        return $category;
    }

    public function replaceCategory(int $id, ?string $name, ?string $reference): Category
    {
        $category = $this->categoryRepository->findOneById($id);
        $category->setName($name)
            ->setReference($reference)
        ;

        $this->categoryRepository->save($category);

        return $category;
    }

    public function deleteCategory(int $id): void
    {
        $category = $this->categoryRepository->findOneById($id);
        $this->categoryRepository->delete($category);
    }
}