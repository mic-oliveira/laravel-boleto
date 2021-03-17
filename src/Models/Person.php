<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Person extends Model
{
    use SoftDeletes;

    protected $table = 'people';

    protected $fillable = [

    ];

    public function getCpfcnpjIndAttribute()
    {
        return substr($this->cpf_cnpj,-1,1);
    }

    public function billets()
    {
        return $this->hasMany(Billet::class,'payer_id');
    }

    public function getEmailAttribute()
    {
        return $this->emails->email;
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'person_id');
    }

    public function emails()
    {
        return $this->hasOne(Email::class, 'person_id');
    }
}
