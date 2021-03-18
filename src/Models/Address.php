<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Address extends Model
{
    use SoftDeletes;

    protected $table = 'addresses';

    protected $fillable = [
        'street',
        'complement',
        'number',
        'neighborhood',
        'cep',
        'city',
        'UF',
        'id_person',
    ];

    public function getCepAttribute()
    {
        return substr($this->attributes['cep'],0,5);
    }
    public function getCepComplementAttribute()
    {
        return substr($this->cep,-3,3);
    }
}
