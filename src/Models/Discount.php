<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;

    protected $table = 'discounts';

    protected $fillable = [
        'value',
        'percent',
        'limit_date',
        'billet_id',
    ];

    public function billet(): BelongsTo
    {
        return $this->belongsTo(Billet::class, 'billet_id');
    }
}
