<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Person extends Model
{
    protected $fillable = [

    ];

    public function address(): HasOne
    {
        return $this->hasOne(Address::class, 'person_id');
    }

    public function document(): HasOne
    {
        return $this->hasOne(Document::class, 'person_id');
    }
}