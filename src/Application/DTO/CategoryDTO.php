<?php

namespace App\Application\DTO;


use App\Domain\Model\Category;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryDTO
{
    public function __construct(
        #[Groups(['category_list', 'category_detail'])]
        public string $id,

        #[Groups(['category_list', 'category_detail'])]
        #[Assert\NotBlank()]
        public string $name,

        #[Groups(['category_list', 'category_detail'])]
        public string $reference,

        #[Groups(['category_detail'])]
        public array $products,
    ) {}

    public static function fromEntity(Category $category): CategoryDTO
    {
        $productList = $category->getProducts()->toArray();
        return new self($category->getId(), $category->getName(), $category->getReference(), $productList);
    }
}