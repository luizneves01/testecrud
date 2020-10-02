<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteEndereco extends Model
{
    use HasFactory;

    protected $fillable = [
        'cliente_id',
        'rua',
        'numero',
        'bairro',
        'cidade',
        'estado',
        'cep'
    ];

    protected $hidden = [
        'id',
        'cliente_id',
        'created_at',
        'updated_at'
    ];
}
