<?php


namespace Boleto\Repositories\Eloquent;


use Boleto\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Model;

class FeeRepository extends EloquentRepository
{
    public function __construct(Model $model)
    {
        parent::__construct($model);
    }

    public function get()
    {
        return parent::get(); // TODO: Change the autogenerated stub
    }

    public function create(array $data): Model
    {
        return parent::create($data); // TODO: Change the autogenerated stub
    }

    public function find(int $id): Model
    {
        return parent::find($id); // TODO: Change the autogenerated stub
    }

    public function update(array $data, int $id): Model
    {
        return parent::update($data, $id); // TODO: Change the autogenerated stub
    }

    public function delete(int $id): Model
    {
        return parent::delete($id); // TODO: Change the autogenerated stub
    }

}
