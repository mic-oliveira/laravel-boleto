<?php


namespace Boleto\Repositories\Eloquent;


use Boleto\Models\Email;
use Boleto\Repositories\EloquentRepository;
use Illuminate\Database\Eloquent\Model;

class EmailRepository extends EloquentRepository
{

    public function __construct()
    {
        parent::__construct(new Email());
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

    public function createOrUpdate($data)
    {
        $query = $this->get()->toQuery()->where('person_id', '=', $data['person_id']);
        return $query->exists() ? $query->update(['email' => $data['email']]) : $this->create($data);
    }


}
