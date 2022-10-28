<?php

namespace Tbd\Main\Products;

class Product
{

    public function __construct(public readonly int $id,
                                public readonly string $title,
                                readonly string $description,
                                public readonly float $price)
    {
    }

}