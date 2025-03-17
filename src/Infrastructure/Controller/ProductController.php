<?php

namespace App\Infrastructure\Controller;


use App\Application\ProductUseCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    public function __construct(private readonly ProductUseCase $productUseCase) {}

    #[Route('/product', name: 'product_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $productList = $this->productUseCase->getProductList();

        return $this->json($productList, Response::HTTP_OK);
    }

    #[Route('/product/{id}', name: 'product_detail', methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        $productDTO =  $this->productUseCase->getProductDetails($id);

        return $this->json($productDTO, Response::HTTP_OK);
    }

    #[Route('/product', name:'product_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $productDTO = $this->productUseCase->createProduct($data);

        return $this->json($productDTO, Response::HTTP_CREATED, [], ["groups" => 'default'] );
    }

    #[Route('/product/{id}', name:'product_update', methods: ['PATCH'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $productDTO = $this->productUseCase->replaceProduct($id, $data);

        return $this->json($productDTO, Response::HTTP_OK, [], ["groups" => 'default'] );
    }

    #[Route('/product/{id}', name:'product_replace', methods: ['PUT'])]
    public function replace(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $productDTO = $this->productUseCase->replaceProduct($id, $data);

        return $this->json($productDTO, Response::HTTP_OK, [], ["groups" => 'default'] );
    }

    #[Route('/product/{id}', name:'product_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        $this->productUseCase->deleteProduct($id);

        return $this->json([], Response::HTTP_OK);
    }
}
