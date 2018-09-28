<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Histories extends Model
{
    protected $fillable = ['id_currency', 'id_source', 'price', 'change24h'];
}
