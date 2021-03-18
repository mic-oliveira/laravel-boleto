<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fee extends Model
{
    use SoftDeletes;

    protected $table = 'fees';

    protected $fillable = [
        'value',
        'percent',
        'limit_date',
        'days',
        'billet_id',
    ];

}
