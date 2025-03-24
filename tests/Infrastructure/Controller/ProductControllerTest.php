<?php

namespace App\Tests\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ProductControllerTest extends WebTestCase
{
    public function testList(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/product');

        $this->assertResponseIsSuccessful();
    }

    public function testDetails(): void
    {
        $client = static::createClient();

        $client->request('GET', '/api/product/1');

        $this->assertResponseIsSuccessful();
    }

    public function testCreateSuccess(): void
    {
        $client = static::createClient();
        $client->request('POST', '/api/product',
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode([
                'name' => 'Test Product',
                'price' => 19.99,
                'quantity' => 10,
                'category' => 1
            ])
        );

        $this->assertResponseStatusCodeSame(Response::HTTP_CREATED);
        $this->assertJson($client->getResponse()->getContent());

        $responseData = json_decode($client->getResponse()->getContent(), true);
        $this->assertArrayHasKey('id', $responseData);
        $this->assertEquals('Test Product', $responseData['name']);
    }

    public function testCreateFail(): void
    {
        $client = static::createClient();

        $client->request('POST', '/api/product', [], [], ['CONTENT_TYPE' => 'application/json'], json_encode([
            'price' => 5
        ]));

        $this->assertResponseStatusCodeSame(Response::HTTP_BAD_REQUEST);
    }
}