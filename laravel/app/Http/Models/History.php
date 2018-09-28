<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    protected $fillable = ['id_currency', 'id_source', 'avg', 'change24h'];
}
