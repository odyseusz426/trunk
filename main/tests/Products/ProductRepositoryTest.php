<?php

namespace Tbd\Main\Tests\Products;

use ReflectionClass;
use Tbd\Main\Products\Product;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use React\Http\Message\ServerRequest;
use Tbd\Main\Products\ProductRepository;
use Tbd\Main\Products\ProductRepositoryInterface;
use Tbd\Main\Products\ProductsListController;

class ProductRepositoryTest extends TestCase
{
    public function testFindProduct()
    {
        $repository = new ProductRepository();
        $reflection = new ReflectionClass($repository);
        $reflection_property = $reflection->getProperty('products');
        $reflection_property->setAccessible(true);

        $reflection_property->setValue($repository, [
            1 => [
                "id" => 1,
                "title" => "test1",
                "price" => 111.11,
                "description" => "description1"
            ],
            2 => [
                "id" => 2,
                "title" => "test2",
                "price" => 222.22,
                "description" => "description2"
            ],
            3 => [
                "id" => 3,
                "title" => "test3",
                "price" => 333.33,
                "description" => "description3"
            ]
        ]);

        $product1 = new Product(1, 'test1', 'description1', 111.11);
        $product2 = new Product(2, 'test2', 'description2', 222.22);
        $product3 = new Product(3, 'test3', 'description3', 333.33);

        $r1 = $repository->findProduct(1);
        $this->assertInstanceOf(Product::class, $r1);
        $this->assertEquals($product1, $r1);

        $r2 = $repository->findProduct(2);
        $this->assertInstanceOf(Product::class, $r2);
        $this->assertEquals($product2, $r2);

        $r3 = $repository->findProduct(3);
        $this->assertInstanceOf(Product::class, $r3);
        $this->assertEquals($product3, $r3);

        $r4 = $repository->findProduct(4);
        $this->assertNull($r4);
    }

    public function testListProducts()
    {
        $repository = new ProductRepository();
        $reflection = new ReflectionClass($repository);
        $reflection_property = $reflection->getProperty('products');
        $reflection_property->setAccessible(true);

        $reflection_property->setValue($repository, [
            1 => [
                "id" => 1,
                "title" => "test1",
                "price" => 111.11,
                "description" => "description1"
            ],
            2 => [
                "id" => 2,
                "title" => "test2",
                "price" => 222.22,
                "description" => "description2"
            ],
            3 => [
                "id" => 3,
                "title" => "test3",
                "price" => 333.33,
                "description" => "description3"
            ]
        ]);

        $product1 = new Product(1, 'test1', 'description1', 111.11);
        $product2 = new Product(2, 'test2', 'description2', 222.22);
        $product3 = new Product(3, 'test3', 'description3', 333.33);

        $list = $repository->listProducts();
        $this->assertIsArray($list);
        $this->assertEquals([$product1, $product2, $product3], $list);
    }
}