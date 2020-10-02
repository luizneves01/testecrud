<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\ClienteEndereco;

class Cliente extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome',
        'dataNascimento',
        'email',
        'cpf'
    ];

    protected $hidden = [
        'id',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'dataNascimento' => 'date:d/m/Y'
    ];

    public function endereco()
    {
        return $this->hasMany(ClienteEndereco::class, 'cliente_id', 'id');
    }
}
