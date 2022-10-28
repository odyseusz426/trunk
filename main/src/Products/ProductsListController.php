<?php

namespace Tbd\Main\Products;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;

class ProductsListController
{
    private $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $products = $this->repository->listProducts();

        $data = [];
        foreach($products as $product) {
            $row = [
                "id" => $product->id,
                "name" => $product->title,
                "description" => $product->description,
                "price" => $product->price
            ];
            $data[] = $row;
        }

        return Response::json($data);
    }
}