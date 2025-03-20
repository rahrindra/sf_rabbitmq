<?php

namespace App\Application;

use App\Application\DTO\CategoryDTO;
use App\Application\DTO\ProductDTO;
use App\Domain\Manager\CategoryManager;
use App\Domain\Model\Category;

class CategoryUseCase
{
    const INVALID_ARGUMENT = "Invalid Argument";

    public function __construct(
        private readonly CategoryManager $categoryManager
    ) {}


    public function getCategoryList(): array
    {
        $categoryList    = $this->categoryManager->getCategoryList();
        $categoryDtoList = [];
        foreach ($categoryList as $category) {
            $categoryDTO       = new CategoryDTO($category);
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
        $category              = $this->categoryManager->getCategoryDetails(id: $id);
        $categoryDTO           = new CategoryDTO($category);
        $categoryDTO->products = $this->getProductsDTO($category);

        return $categoryDTO;
    }


    public function updateCategory(int $categoryId, array $data): CategoryDTO
    {
        if(!$this->isCategoryDataInputValid($data)) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT);
        }

        $category               = $this->categoryManager->updateCategory(id: $categoryId, name: $data['name'], reference: $data['reference']);

        $categoryDTO            = new CategoryDTO($category);
        $categoryDTO->products  = $this->getProductsDTO($category);

        return $categoryDTO;
    }


    public function replaceCategory(int $categoryId, array $data): CategoryDTO
    {
        if(!$this->isCategoryDataInputValid($data)) {
            throw new \InvalidArgumentException(self::INVALID_ARGUMENT);
        }

        $category = $this->categoryManager->replaceCategory(id: $categoryId, name: $data['name'], reference: $data['reference']);

        $categoryDTO            = new CategoryDTO($category);
        $categoryDTO->products  = $this->getProductsDTO($category);

        return $categoryDTO;
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

    /**
     * @description retourne la liste des produits (ProductDTO) du categorie
     */
    public function getProductsDTO(Category $category): array
    {
        $productsDTO = [];
        foreach ($category->getProducts() as $product) {
            $productsDTO[] = new ProductDTO($product);
        }

        return $productsDTO;
    }
}