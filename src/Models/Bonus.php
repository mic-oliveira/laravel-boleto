<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Bonus extends Model
{
    use SoftDeletes;

    protected $table = 'bonus';

    protected $fillable = [
        'value',
        'percent',
        'limit_date',
        'billet_id',
    ];

    public function getConnectionName()
    {
        return config('boleto.boleto_connection');
    }
}
