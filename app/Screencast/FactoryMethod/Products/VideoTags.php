<?php

namespace App\Screencast\FactoryMethod\Products;

use App\Screencast\FactoryMethod\Contracts\PivotInterface;

class VideoTags implements PivotInterface
{
    private $model;
    private $id;

    public function __construct($model, $id)
    {
        $this->model = $model;
        $this->id = $id;
    }

    public function attach()
    {
        return $this->model->tags()->attach($this->id);
    }

    public function detach()
    {
        return $this->model->tags()->detach($this->id);
    }
}
