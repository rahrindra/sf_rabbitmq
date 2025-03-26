<?php

namespace App\Domain\Repository;

interface ProductSearchRepositoryInterface
{
    public function searchByName(string $name): array;

    public function searchByPrice(?float $min, ?float $max): array;

    public function searchByQuantity(?float $min, ?float $max): array;
}