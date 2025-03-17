<?php

namespace App\Infrastructure\DTO;


use App\Domain\Model\Product;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDTO
{
    #[Groups(['default', 'product_list'])]
    public string $id;

    #[Groups(['default', 'product_list'])]
    #[Assert\NotBlank()]
    public string $name;

    public function __construct(Product $product)
    {
        $this->id   = $product->getId();
        $this->name = $product->getName();
    }
}