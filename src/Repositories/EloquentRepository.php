<?php

namespace Boleto\Repositories;

use Illuminate\Database\Eloquent\Model;

class EloquentRepository implements RepositoryInterface
{
    private Model $model;

    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    public function get()
    {
        return $this->model::all();
    }

    public function create(array $data): Model
    {
        $model = $this->model->fill($data);
        $model->saveOrFail();
        return $model;
    }

    public function find(int $id): Model
    {
        return $this->model::findOrFail($id);
    }

    public function update(array $data, int $id): Model
    {
        $model  = $this->find($id);
        $model->fill($data)->saveOrFail();
        return $model;
    }

    public function delete(int $id): Model
    {
        $model = $this->find($id);
        $model->delete();
        return $model;
    }
}
