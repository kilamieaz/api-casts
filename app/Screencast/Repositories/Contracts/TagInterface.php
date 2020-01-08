<?php

namespace App\Screencast\Repositories\Contracts;

interface TagInterface
{
    public function all();

    public function store(array $data);

    public function show($record);

    public function update(array $data, $record);

    public function delete($record);
}
