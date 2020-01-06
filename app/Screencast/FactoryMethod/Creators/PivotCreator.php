<?php

namespace App\Screencast\FactoryMethod\Creators;

use App\Screencast\FactoryMethod\Contracts\PivotInterface;

abstract class PivotCreator
{
    abstract public function getProduct(): PivotInterface;

    public function connect()
    {
        $network = $this->getProduct();
        $network->attach();
    }

    public function disconnect()
    {
        $network = $this->getProduct();
        $network->detach();
    }
}
