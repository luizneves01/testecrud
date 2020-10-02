<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteCartao extends Model
{
    protected $fillable = [
        'cliente_id',
        'titular',
        'numero',
        'data_expiracao',
        'bandeira',
        'cvv'
    ];

    protected $hidden = [
        'id',
        'cliente_id',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'data_expiracao' => 'date:m/Y'
    ];
}
