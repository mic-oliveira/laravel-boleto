<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    protected $fillable = [

    ];

    public function getCpfcnpjIndAttribute()
    {
        return substr($this->cpf_cnpj,-1,1);
    }

    public function getEmailAttribute()
    {
        return $this->emails->email;
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'person_id');
    }

    public function document(): HasOne
    {
        return $this->hasOne(Document::class, 'person_id');
    }

    public function emails()
    {
        return $this->hasOne(Email::class, 'person_id');
    }
}
