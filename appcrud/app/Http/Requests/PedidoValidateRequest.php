<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

use App\Helper\ValidadeHelper;

class PedidoValidateRequest
{
    /**
     * Método responsável por validar request de inclusão de pedido
     * 
     * @param Request $request
     */
    public function validateStore(Request $request)
    {
        $rules = [
            'cpf' => 'required|max:11',
            'valor' => 'required',
            'titular' => 'required|max:255',
            'numero' => 'required|max:16',
            'data_expiracao' => 'required|date|date_format:Y-m-d',
            'bandeira' => 'required|max:100',
            'cvv' => 'required|max:5'
        ];        
    
        return new ValidadeHelper($request, $rules);        
    }    

    /**
     * Método responsável por validar request da atualização de pedido
     * 
     * @param Request $request
     */
    public function validateUpdate(Request $request)
    {
        $rules = [
            'cpf' => 'max:11',
            'titular' => 'max:255',
            'numero' => 'max:16',
            'data_expiracao' => 'date|date_format:Y-m-d',
            'bandeira' => 'max:100',
            'cvv' => 'max:5'
        ];        
    
        return new ValidadeHelper($request, $rules);        
    }    
}