<?php


namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Phone extends Model
{
    use SoftDeletes;

    protected $table = 'phones';

    protected $fillable = [
        'number',
        'ddd',
        'person_id',
    ];

    public function getConnectionName()
    {
        return config('boleto.boleto_connection');
    }
}
