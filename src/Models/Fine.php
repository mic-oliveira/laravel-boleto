<?php


namespace Boleto\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'value',
        'percent',
        'limit_date',
        'days',
        'billet_id'
    ];
}
