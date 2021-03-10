<?php

namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphOne;

class Payer extends Model
{
    protected $fillable = [];

    public function personable(): MorphOne
    {
        return $this->morphOne(Person::class, 'personable');
    }
}