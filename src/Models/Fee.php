<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    protected $table = 'fees';

    protected $fillable = [];

    public function getCepAttribute()
    {
        return substr($this->attributes['cep'],0,5);
    }
    public function getCepComplementAttribute()
    {
        return substr($this->cep,-3,3);
    }
}
