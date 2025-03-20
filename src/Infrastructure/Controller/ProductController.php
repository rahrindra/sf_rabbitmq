<?php

namespace App\Infrastructure\Controller;


use App\Application\ProductUseCase;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

final class ProductController extends AbstractController
{
    public function __construct(private readonly ProductUseCase $productUseCase) {}

    #[Route('/product', name: 'product_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $productList = $this->productUseCase->getProductList();

        return $this->json($productList, Response::HTTP_OK, [], ['groups' => ['product_list', 'category_list']]);
    }

    #[Route('/product/{id}', name: 'product_detail', methods: ['GET'])]
    public function detail(int $id): JsonResponse
    {
        try {
            $productDTO =  $this->productUseCase->getProductDetails($id);
            return $this->json($productDTO, Response::HTTP_OK, [], ['groups' => ['product_detail', 'category_list']]);
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch(Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/product', name:'product_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $productDTO = $this->productUseCase->createProduct($data);

            return $this->json($productDTO, Response::HTTP_CREATED, [], ["groups" => ['product_detail', 'category_list']] );
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch(Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/product/{id}', name:'product_update', methods: ['PATCH'])]
    public function update(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $productDTO = $this->productUseCase->updateProduct($id, $data);
            return $this->json($productDTO, Response::HTTP_OK, [], ["groups" => ['product_detail', 'category_list']] );
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (EntityNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch(Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/product/{id}', name:'product_replace', methods: ['PUT'])]
    public function replace(int $id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $productDTO = $this->productUseCase->replaceProduct($id, $data);
            return $this->json($productDTO, Response::HTTP_OK, [], ["groups" => ['product_detail', 'category_list']] );
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (EntityNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch(Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/product/{id}', name:'product_delete', methods: ['DELETE'])]
    public function delete(int $id): JsonResponse
    {
        try {
            $this->productUseCase->deleteProduct($id);
            return $this->json(null, Response::HTTP_NO_CONTENT);
        }  catch (EntityNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch(Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
