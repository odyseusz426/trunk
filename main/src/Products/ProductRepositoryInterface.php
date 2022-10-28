<?php
namespace Tbd\Main\Products;

interface ProductRepositoryInterface
{
    /**
     * @return Product[]
     */
    public function listProducts(): array;

    public function findProduct(string $id): ?Product;
}