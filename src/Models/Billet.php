<?php

namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Billet extends Model
{
    protected $fillable = [];

    public function payer(): HasOne
    {
        return $this->hasOne(Payer::class, 'billet_id');
    }

    public function drawer(): HasOne
    {
        return $this->hasOne(Drawer::class, 'billet_id');
    }

    public function interest(): HasOne
    {
        return $this->hasOne(Interest::class, 'billet_id');
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class, 'billet_id');
    }
}