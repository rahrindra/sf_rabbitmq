<?php

namespace App\Application;

use App\Application\DTO\CategoryDTO;
use App\Domain\Manager\CategoryManager;

class CategoryUseCase
{
    const INVALID_ARGUMENT = "Invalid Argument";

    public function __construct(
        private readonly CategoryManager $categoryManager
    ) {}


    public function getCategoryList(): array
    {
        $categoryList = $this->categoryManager->getCategoryList();
        $categoryDtoList = [];
        foreach ($categoryList as $category) {
            $categoryDTO = new CategoryDTO($category);
            $categoryDtoList[] = $categoryDTO;
        }
        return $categoryDtoList;
    }


    public function createCategory(array $data): CategoryDTO
    {
        if(!$this->isCategoryDataInputValid($data)) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT);
        }

        $category = $this->categoryManager->createCategory(name: $data['name'], reference: $data['reference']);
        return new CategoryDTO($category);
    }


    public function getCategoryDetails(int $id): CategoryDTO
    {
        $category = $this->categoryManager->getCategoryDetails(id: $id);
        return new CategoryDTO($category);
    }


    public function updateCategory(int $categoryId, array $data): CategoryDTO
    {
        if(!$this->isCategoryDataInputValid($data)) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT);
        }

        $category = $this->categoryManager->updateCategory(id: $categoryId, name: $data['name'], reference: $data['reference']);

        return new CategoryDTO($category);
    }


    public function replaceCategory(int $categoryId, array $data): CategoryDTO
    {
        if(!$this->isCategoryDataInputValid($data)) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT);
        }

        $category = $this->categoryManager->replaceCategory(id: $categoryId, name: $data['name'], reference: $data['reference']);
        return new CategoryDTO($category);
    }


    public function deleteCategory(int $categoryId): void
    {
        $this->categoryManager->deleteCategory(id: $categoryId);
    }


    /**
     * @description Vérifie les arguments d'entrée envoyés
     */
    public function isCategoryDataInputValid(array $data): bool
    {
        if(!array_key_exists('name', $data) || !array_key_exists('reference', $data)) {
            return false;
        }
        return true;
    }
}