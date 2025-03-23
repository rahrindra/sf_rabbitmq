<?php

namespace App\Tests\Domain\Infrastructure\Controller;



use App\Application\DTO\CategoryDTO;
use App\Application\DTO\ProductDTO;
use App\Application\ProductUseCase;
use App\Domain\Model\Product;
use App\Domain\Repository\ProductRepositoryInterface;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ProductControllerTest extends WebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();

        /*
        $container = static::getContainer();


        $categoryDTO = new CategoryDTO(id: 1, name: 'category test', reference: 'reference test', products: []);
        $productDTO = new ProductDTO(id: 1, name: 'produit test', price: 9.9, quantity: 1, category: $categoryDTO);

        $productUseCase = $this->createMock(ProductUseCase::class);

        $productUseCase->expects(self::once())
            ->method('getProductList')
            ->willReturn([
                $productDTO
            ]);
        ;
        $container->set(ProductRepositoryInterface::class, $productUseCase);
        */

        $client->request('GET', '/api/product');

        $this->assertResponseIsSuccessful();
        // dd($client->getResponse()->getContent());
    }
}
