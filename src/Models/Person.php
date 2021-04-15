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
        'name',
        'cpf_cnpj'
    ];

    public function getConnectionName()
    {
        return config('boleto.boleto_connection');
    }

    public function getCpfcnpjAttribute(): int
    {
        return intval(substr($this->attributes['cpf_cnpj'],0,-1));
    }

    public function getCpfcnpjIndAttribute(): int
    {
        return intval(substr($this->attributes['cpf_cnpj'],-1,1));
    }

    public function billets()
    {
        return $this->hasMany(Billet::class,'payer_id');
    }

    public function getMailAttribute()
    {
        return $this->email->email ?? null;
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'person_id');
    }

    public function email(): HasOne
    {
        return $this->hasOne(Email::class, 'person_id');
    }

    public function phone(): HasOne
    {
        return $this->hasOne(Phone::class, 'person_id');
    }
}
