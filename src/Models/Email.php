<?php

namespace Boleto\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Email extends Model
{
    protected $table = 'emails';

    protected $fillable = [];

}
