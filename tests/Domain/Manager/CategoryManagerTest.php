<?php

namespace App\Tests\Domain\Manager;

use App\Domain\Manager\CategoryManager;
use App\Domain\Model\Category;
use App\Domain\Repository\CategoryRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class CategoryManagerTest extends KernelTestCase
{
    public function testGetCategoryDetails(): void
    {
        self::bootKernel();
        $container = static::getContainer();

        $categoryId        = 1;
        $categoryName      = "Category Test";
        $categoryReference = "CAT001";

        $categoryFixture = new Category();
        $categoryFixture
            ->setName($categoryName)
            ->setReference($categoryReference)
        ;

        $categoryRepository = $this->createMock(CategoryRepositoryInterface::class);

        $categoryRepository->expects(self::once())
            ->method('findOneById')
            ->with(self::equalTo($categoryId))
            ->willReturn($categoryFixture)
        ;
        $container->set(CategoryRepositoryInterface::class, $categoryRepository);

        $categoryManager = $container->get(CategoryManager::class);
        $category = $categoryManager->getCategoryDetails(id: $categoryId);

        $this->assertInstanceOf(Category::class, $category);
        $this->assertEquals( $category->getName(), $categoryName);
        $this->assertEquals( $category->getReference(), $categoryReference);
    }
}