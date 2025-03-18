<?php

namespace App\Application\DTO;


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

    #[Groups(['default', 'product_list'])]
    public float $price;

    #[Groups(['default', 'product_list'])]
    public int $quantity;

    public function __construct(Product $product)
    {
        $this->id   = $product->getId();
        $this->name = $product->getName();
        $this->price = $product->getPrice();
        $this->quantity = $product->getQuantity();
    }
}