<?php
namespace Tbd\Main\Products;

class ProductRepository implements ProductRepositoryInterface
{
    private $products = [
        1 => [
            "id" => 1,
            "title" => "wallet",
            "price" => 149.99,
            "description" => "the best wallet you can buy for the rest of your money"
        ],
        2 => [
            "id" => 2,
            "title" => "balls of steel",
            "price" => 1337.00,
            "description" => "You are a hero, you can deploy your code multiple times at friday afternoon without blink of an eye. You deserve the statue of balls of steel."
        ]
    ];

    public function findProduct(string $id): ?Product
    {
        if(!array_key_exists($id, $this->products)){
            return null;
        }
        $data = $this->products[$id];
        return new Product($data['id'], $data['title'], $data['description'], $data['price']);
    }

    public function listProducts(): array
    {
        $result = [];
        foreach($this->products as $data){
            $result[] = new Product($data['id'], $data['title'], $data['description'], $data['price']);
        }
        return $result;
    }
}