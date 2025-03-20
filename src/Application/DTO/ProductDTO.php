<?php

namespace App\Application\DTO;


use App\Domain\Model\Category;
use App\Domain\Model\Product;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDTO
{
    #[Groups(['product_list', 'product_detail'])]
    public string $id;

    #[Groups(['product_list', 'product_detail'])]
    #[Assert\NotBlank()]
    public string $name;

    #[Groups(['product_list', 'product_detail'])]
    public float $price;

    #[Groups(['product_list', 'product_detail'])]
    public int $quantity;

    #[Groups(['product_detail'])]
    public ?CategoryDTO $category;

    public function __construct(Product $product)
    {
        $this->id   = $product->getId();
        $this->name = $product->getName();
        $this->price = $product->getPrice();
        $this->quantity = $product->getQuantity();

        if ($product->getCategory() instanceof Category) {
            $this->category = new CategoryDTO($product->getCategory());
        } else {
            $this->category = null;
        }
    }
}