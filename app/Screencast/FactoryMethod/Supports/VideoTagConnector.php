<?php

namespace App\Screencast\FactoryMethod\Supports;

use App\Screencast\FactoryMethod\Creators\PivotCreator;
use App\Screencast\FactoryMethod\Products\VideoTag;
use App\Screencast\FactoryMethod\Contracts\PivotInterface;

class VideoTagConnector extends PivotCreator
{
    private $model;
    private $id;

    public function __construct($model, $id)
    {
        $this->model = $model;
        $this->id = $id;
    }

    public function getProduct(): PivotInterface
    {
        return new VideoTag($this->model, $this->id);
    }
}
