<?php


namespace Boleto\Repositories\Eloquent;


use Boleto\Models\Phone;
use Boleto\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Model;

class PhoneRepository extends EloquentRepository
{
    public function __construct()
    {
        parent::__construct(new Phone());
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

    public function createOrUpdate($data): Model
    {
        $query = Phone::where('ddd','=',$data['ddd'])
            ->where('person_id','=',$data['person_id']);
        return $query->exists() ? $this->update($data, $query->get()->first()->id) : $this->create($data);
    }

}
