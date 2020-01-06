<?php

namespace App\Screencast\FactoryMethod\Supports;

use App\Screencast\FactoryMethod\Creators\PivotCreator;
use App\Screencast\FactoryMethod\Contracts\PivotInterface;

class PivotSupport extends PivotCreator
{
    private $product;

    public function __construct($product)
    {
        $this->product = $product;
    }

    public function getProduct(): PivotInterface
    {
        return $this->product;
    }
}
