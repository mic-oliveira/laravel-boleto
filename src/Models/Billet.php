<?php

namespace Boleto\Models;

use Bradesco\Models\Bonus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billet extends Model
{
    use SoftDeletes;

    protected $table = 'billets';

    protected $fillable = [
        'agency',
        'title_number',
        'title_type',
        'currency_code',
        'product_id',
        'client_number',
        'partial_payment_id',
        'amount_partial_payment',
        'emission_form',
        'currency_amount',
        'register_title',
        'emission_date',
        'due_date',
        'cpfcnpj_number',
        'term_limit',
        'term_type',
        'protest_limit',
        'protest_type',
        'cpfcnpj_branch',
        'negotiation_number',
        'iof_value',
        'nominal_value',
        'payer_id',
        'drawer_id',
        'layout_version',
    ];

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
