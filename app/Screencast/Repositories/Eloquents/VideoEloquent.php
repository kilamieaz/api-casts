<?php

namespace App\Screencast\Repositories\Eloquents;

use App\Video;
use App\Screencast\Repositories\Contracts\VideoInterface;

class VideoEloquent implements VideoInterface
{
    protected $model;

    public function __construct()
    {
        $this->model = new Video();
    }

    // Get all instances of model
    public function all()
    {
        return $this->model->all();
    }

    // store a new record in the database
    public function store(array $data)
    {
        return $this->model->create($data);
    }

    // show the record with the given id
    public function show($record)
    {
        // return $this->model->findOrFail($id);
        return $record;
    }

    // update record in the database
    public function update(array $data, $record)
    {
        // $record = $this->find($id);
        return $record->update($data);
    }

    // remove record from the database
    public function delete($record)
    {
        // return $this->model->destroy($id);
        return $record->delete();
    }

    // Get the associated model
    public function getModel()
    {
        return $this->model;
    }

    // Set the associated model
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    // Eager load database relationships
    public function with($relations)
    {
        return $this->model->with($relations);
    }
}
