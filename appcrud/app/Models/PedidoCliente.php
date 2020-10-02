<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use App\Models\ClienteCartao;

class PedidoCliente extends Model
{
    protected $fillable = [
        'cliente_id',
        'cliente_cartao_id',
        'valor',
        'cpf'
    ];

    protected $hidden = [
        'id',
        'cliente_id',
        'cliente_cartao_id',
        'created_at',
        'updated_at'
    ];
    
    protected $casts = [
        'valor' => 'float'
    ];

    /**
     * Funcionalidade que traz um pedido completo junto de seu cartão relacionado
     * @param QueryBuilder $query
     * @param int $id
     */
    public function scopePedidoCompleto($query, $id = null)
    {
        if(!empty($id))
            return $query->where('id', $id)->with('cartao')->first();    

        return $query->with('cartao')->orderBy('created_at', 'desc')->get();
    }

    public function cartao()
    {
        return $this->hasOne(ClienteCartao::class, 'id', 'cliente_cartao_id');
    }
}
