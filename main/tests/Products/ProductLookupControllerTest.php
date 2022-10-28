<?php

namespace Tbd\Main\Tests\Products;

use Tbd\Main\FeatureFlags\FeatureFlag;
use Tbd\Main\Products\Product;
use Tbd\Main\Products\ProductLookupController;
use PHPUnit\Framework\TestCase;
use Psr\Http\Message\ResponseInterface;
use React\Http\Message\ServerRequest;
use Tbd\Main\Products\ProductLookupDataProviderInterface;
use Tbd\Main\Products\ProductLookupStandardDataProvider;
use Tbd\Main\Products\ProductRepositoryInterface;
use Tbd\Main\Recommendations\RecommendationsServiceInterface;

class ProductLookupControllerTest extends TestCase
{
    private $dataProvider;

    public function setUp(): void
    {
        $this->dataProvider = new ProductLookupStandardDataProvider();
    }

    public function testControllerReturnsValidResponseWithRecommendationsDisabled()
    {
        if(FeatureFlag::isEnabled('show_recommendations_on_product_lookup')){
            $this->markTestSkipped("Flag show_recommendations_on_product_lookup is enabled");
        }

        $request = new ServerRequest('GET', 'http://example.com/products/3');
        $request = $request->withAttribute("id", "3");

        $product = new Product(3, 'test', 'description', 100);

        $stub = $this->createMock(ProductRepositoryInterface::class);
        $stub->method('findProduct')
            ->will($this->returnValueMap([["3", $product]]));

        $controller = new ProductLookupController($stub, $this->dataProvider);

        $response = $controller($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));

        $output='{
    "name": "test",
    "description": "description",
    "price": 100.0
}';

        $this->assertEquals($output, (string) trim($response->getBody()));
    }

    public function testControllerReturnsValidResponseWithRecommendationsEnabled()
    {
        if(!FeatureFlag::isEnabled('show_recommendations_on_product_lookup')){
            $this->markTestSkipped("Flag show_recommendations_on_product_lookup is disabled");
        }

        $request = new ServerRequest('GET', 'http://example.com/products/3');
        $request = $request->withAttribute("id", "3");

        $product = new Product(3, 'test', 'description', 100);

        $stub = $this->createMock(ProductRepositoryInterface::class);
        $stub->method('findProduct')
            ->will($this->returnValueMap([["3", $product]]));

        $controller = new ProductLookupController($stub, $this->dataProvider);

        $recoStub = $this->createMock(RecommendationsServiceInterface::class);
        $recoStub->method('getRecommendations')
            ->will($this->returnValueMap([[3, [1]]]));

        $controller->getDataProvider()->getImplementation()->setService($recoStub);

        $response = $controller($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(200, $response->getStatusCode());
        $this->assertEquals('application/json', $response->getHeaderLine('Content-Type'));

        $output='{
    "name": "test",
    "description": "description",
    "price": 100.0,
    "recommendations": [
        1
    ]
}';
        $this->assertEquals($output, (string) trim($response->getBody()));
    }

    public function testControllerReturns404Response()
    {
        $request = new ServerRequest('GET', 'http://example.com/products/3');
        $request = $request->withAttribute("id", "3");

        $stub = $this->createMock(ProductRepositoryInterface::class);
        $stub->method('findProduct')
            ->will($this->returnValueMap([["3", null]]));



        $controller = new ProductLookupController($stub, $this->dataProvider);

        $response = $controller($request);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertEquals(404, $response->getStatusCode());
        $this->assertEquals('text/plain; charset=utf-8', $response->getHeaderLine('Content-Type'));

        $output='Product not found';
        $this->assertEquals($output, (string) trim($response->getBody()));
    }
}
