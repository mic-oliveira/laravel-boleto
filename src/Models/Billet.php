<?php

namespace Boleto\Models;

use Bradesco\Models\Bonus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Billet extends Model
{
    protected $table = 'billets';

    protected $fillable = [];

    public function payer(): HasOne
    {
        return $this->hasOne(Person::class, 'billet_id');
    }

    public function drawer(): HasOne
    {
        return $this->hasOne(Person::class, 'billet_id');
    }

    public function fee()
    {
        return $this->hasOne(Fee::class, 'billet_id');
    }

    public function fine()
    {
        return $this->hasOne(Fine::class, 'billet_id');
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class, 'billet_id');
    }

    public function bonus(): HasOne
    {
        return $this->hasOne(Bonus::class);
    }
}
