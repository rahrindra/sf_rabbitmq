<?php

namespace App\Application\DTO;

use App\Domain\Model\Product;
use Symfony\Component\Serializer\Annotation\Groups;

class ProductDTO
{
    #[Groups(['product', 'product_list'])]
    public string $id;

    #[Groups(['product', 'product_list'])]
    public string $name;

    public function __construct(Product $product)
    {
        $this->id   = $product->getId();
        $this->name = $product->getName();
    }
}