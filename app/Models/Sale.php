<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model {

    use HasFactory;

    protected $table = 'sale';

    protected $fillable = [
        'id_seller',
        'id_product',
        'id_client',
        
        'method',
        'installments',

        'status',
        'delivery',

        'token',
        'url',
        'key_unique',
    ];
}
