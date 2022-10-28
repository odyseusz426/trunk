<?php

namespace Tbd\Main\Products;

use Psr\Http\Message\ServerRequestInterface;
use React\Http\Message\Response;
class ProductLookupController
{
    private $repository;
    private $dataProvider;

    public function __construct(
        ProductRepositoryInterface $repository,
        ProductLookupDataProviderInterface $dataProvider
    )
    {
        $this->repository = $repository;
        $this->dataProvider = $dataProvider;
    }

    public function __invoke(ServerRequestInterface $request)
    {
        $id = $request->getAttribute('id');
        $product = $this->repository->findProduct($id);

        if ($product === null) {
            return Response::plaintext(
                "Product not found\n"
            )->withStatus(Response::STATUS_NOT_FOUND);
        }
        /*$data = [
            "name" => $product->title,
            "description" => $product->description,
            "price" => $product->price,
        ];*/

        $data = $this->dataProvider->getData($product);


        return Response::json($data);
    }
}