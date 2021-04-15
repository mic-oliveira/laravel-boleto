<?php

namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Email extends Model
{
    use SoftDeletes;

    protected $table = 'emails';

    protected $fillable = [
        'email',
        'person_id'
    ];

    public function getConnectionName()
    {
        return config('boleto.boleto_connection');
    }
}
