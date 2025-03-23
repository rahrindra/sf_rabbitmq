<?php

namespace App\Application\DTO;


use App\Domain\Model\Category;
use App\Domain\Model\Product;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

class ProductDTO
{
    public function __construct(
        #[Groups(['product_list', 'product_detail'])]
        public string $id,

        #[Groups(['product_list', 'product_detail'])]
        #[Assert\NotBlank()]
        public string $name,

        #[Groups(['product_list', 'product_detail'])]
        public float $price,

        #[Groups(['product_list', 'product_detail'])]
        public int $quantity,

        #[Groups(['product_detail'])]
        public ?CategoryDTO $category
    ) {}

    public  static function fromEntity(Product $product): ProductDTO
    {
        if ($product->getCategory() instanceof Category) {
            $categoryDTO = CategoryDTO::fromEntity($product->getCategory());
        } else {
            $categoryDTO = null;
        }

        return new self($product->getId(), $product->getName(), $product->getPrice(), $product->getQuantity(), $categoryDTO);
    }
}