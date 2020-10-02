<?php

namespace App\Service;

use Illuminate\Http\Request;

use App\Models\Cliente;
use App\Models\ClienteCartao;
use App\Models\PedidoCliente;

class PedidoService
{
    /**
     * Método responsável pela adição de cartão de crédito e cadastro de pedido
     * 
     * @param Request $request
     */
    public static function novoPedido(Request $request)
    {
        try{
            $cliente = Cliente::where('cpf', $request->get('cpf'))->first();

            if(empty($cliente))
                throw new \Exception('Cliente não foi localizado!');

            $clienteCartao = $request->only([
                'titular',
                'numero',
                'data_expiracao',
                'bandeira',
                'cvv'
            ]);
    
            // Fazendo merge dos dados do request + id de cliente
            $clienteCartao = array_merge($clienteCartao, ['cliente_id' => $cliente->id]);
            
            $cartao = ClienteCartao::firstOrCreate($clienteCartao);
            $pedido = PedidoCliente::create([
                'cliente_id' => $cliente->id,
                'cliente_cartao_id' => $cartao->id,
                'valor' => $request->get('valor'),
                'cpf' => $cliente->cpf
            ]);

            return $pedido;
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }

    /**
     * Método responsável pela atualização de pedido
     * 
     * @param Request $request
     * @param int $id
     */
    public static function atualizarPedido(Request $request, $id)
    {
        try{
            $pedido = PedidoCliente::find($id);

            if(empty($pedido))
                throw new \Exception('Pedido não foi localizado!');            

            $pedido->fill($request->all())->save();
            $pedido->cartao->fill($request->all())->save();

            return $pedido;
        }catch(\Exception $e){
            throw new \Exception($e->getMessage());
        }
    }
}