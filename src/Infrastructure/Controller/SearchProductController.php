<?php

declare(strict_types=1);

namespace App\Infrastructure\Controller;

use App\Application\ProductSearchUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class SearchProductController extends AbstractController
{
    public function __construct(
        private ProductSearchUseCase $productSearchUseCase,
    ) {}


    #[Route('/search-product', name:'search-product', methods: ['POST'])]
    public function search(Request $request): Response
    {
        $data           = json_decode($request->getContent(), true);
        $productListDTO = $this->productSearchUseCase->searchProductByName($data);

        return $this->json($productListDTO, Response::HTTP_OK, [], ["groups" => ['product_list']] );
    }
}
