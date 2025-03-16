<?php

namespace App\Infrastructure\Controller;


use App\Application\Service\ProductService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public function __construct(private readonly ProductService $productService) {}

    #[Route('/product', name: 'product_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $productList = $this->productService->getProductList();

        return $this->json($productList, Response::HTTP_OK);
    }

    #[Route('/product', name:'product_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {


        return $this->json([], Response::HTTP_CREATED);
    }
}
