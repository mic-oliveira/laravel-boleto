<?php

namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Billet extends Model
{
    use SoftDeletes;

    protected $table = 'billets';

    protected $fillable = [
        'bank',
        'bank_id',
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
        'cpfcnpj_control',
        'term_limit',
        'term_type',
        'protest_limit',
        'protest_type',
        'cpfcnpj_branch',
        'negotiation_number',
        'rebate_value',
        'iof_value',
        'nominal_value',
        'reference',
        'digitable_line',
        'return_code',
        'return_message',
        'payer_id',
        'drawer_id',
        'layout_version',
    ];

    protected $casts = [
        'emission_date' => 'date:d-m-Y'
    ];

    public function getConnectionName()
    {
        return config('boleto.boleto_connection');
    }

    public function payer(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'payer_id');
    }

    public function drawer(): BelongsTo
    {
        return $this->belongsTo(Person::class, 'drawer_id');
    }

    public function fee(): HasOne
    {
        return $this->hasOne(Fee::class, 'billet_id');
    }

    public function fine(): HasOne
    {
        return $this->hasOne(Fine::class, 'billet_id');
    }

    public function discounts(): HasMany
    {
        return $this->hasMany(Discount::class, 'billet_id');
    }

    public function bonus(): HasOne
    {
        return $this->hasOne(Bonus::class, 'billet_id');
    }
}
