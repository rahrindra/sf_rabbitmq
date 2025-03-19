<?php

namespace App\Application\DTO;


use App\Domain\Model\Category;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class CategoryDTO
{
    #[Groups(['default', 'category_list', 'category_detail'])]
    public string $id;

    #[Groups(['default', 'category_list', 'category_detail'])]
    #[Assert\NotBlank()]
    public string $name;

    #[Groups(['default', 'category_list', 'category_detail'])]
    public string $reference;

    #[Groups(['category_detail'])]
    public array $products;

    public function __construct(Category $category)
    {
        $this->id   = $category->getId();
        $this->name = $category->getName();
        $this->reference = $category->getReference();
        $this->products = $category->getProducts()->toArray();
    }
}