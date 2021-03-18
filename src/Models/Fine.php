<?php


namespace Boleto\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fine extends Model
{
    use SoftDeletes;

    protected $fillable = [];
}
