<?php

namespace App\Infrastructure\Controller;

use App\Application\CategoryUseCase;
use Doctrine\ORM\EntityNotFoundException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Throwable;

final class CategoryController extends AbstractController
{
    public function __construct(private readonly CategoryUseCase $categoryUseCase){}

    #[Route('/category', name: 'category_list', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $categoriesDTO = $this->categoryUseCase->getCategoryList();

        return $this->json($categoriesDTO, Response::HTTP_OK, [], ['groups' => ['default']]);
    }


    #[Route('/category', name: 'category_create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $categoryDTO = $this->categoryUseCase->createCategory($data);
            return $this->json($categoryDTO, Response::HTTP_CREATED, [], ['groups' => ['default']]);
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (\Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/category/{id}', name: 'category_details', methods: ['GET'])]
    public function details($id): JsonResponse
    {
        try {
            $categoryDTO = $this->categoryUseCase->getCategoryDetails($id);
            return $this->json($categoryDTO, Response::HTTP_OK, [], ['groups' => ['category_detail']]);
        } catch (EntityNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/category/{id}', name: 'category_update', methods: ['PATCH'])]
    public function update(Request $request, int $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $categoryDTO = $this->categoryUseCase->updateCategory($id, $data);
            return $this->json($categoryDTO, Response::HTTP_OK, [], ['groups' => ['category_detail']]);
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (EntityNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/category/{id}', name: 'category_replace', methods: ['PUT'])]
    public function replace(Request $request, $id): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        try {
            $categoryDTO = $this->categoryUseCase->replaceCategory($id, $data);
            return $this->json($categoryDTO, Response::HTTP_OK, [], ['groups' => ['category_detail']]);
        } catch (\InvalidArgumentException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        } catch (EntityNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/category/{id}', name: 'category_delete', methods: ['DELETE'])]
    public function delete($id): JsonResponse
    {
        try {
            $this->categoryUseCase->deleteCategory($id);
            return $this->json(null, Response::HTTP_NO_CONTENT);
        } catch (EntityNotFoundException $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_NOT_FOUND);
        } catch (\Throwable $exception) {
            return $this->json($exception->getMessage(), Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}
