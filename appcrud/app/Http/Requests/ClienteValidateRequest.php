<?php

namespace App\Http\Requests;

use Illuminate\Http\Request;

use App\Helper\ValidadeHelper;

class ClienteValidateRequest
{
    /**
     * Método responsável por validar request antes da inclusão do cliente
     * 
     * @param Request $request
     */
    public function validateStore(Request $request)
    {
        $rules = [
            'nome' => 'required|max:255',
            'dataNascimento' => 'required|date|date_format:Y-m-d',
            'email' => 'required|max:255|unique:clientes',
            'cpf' => 'required|max:11|unique:clientes',
            'rua' => 'required|max:255',
            'numero' => 'required|max:100',
            'bairro' => 'required|max:255',
            'cidade' => 'required|max:255',
            'estado' => 'required|max:2',
            'cep' => 'required|max:8',
        ];        
    
        return new ValidadeHelper($request, $rules);        
    }

    /**
     * Método responsável por validar request antes da atualização do cliente
     * 
     * @param Request $request
     */
    public function validateUpdate(Request $request)
    {
        $rules = [
            'nome' => 'max:255',
            'dataNascimento' => 'date|date_format:Y-m-d',
            'email' => 'max:255|unique:clientes',
            'cpf' => 'max:11|unique:clientes',
            'rua' => 'max:255',
            'numero' => 'max:100',
            'bairro' => 'max:255',
            'cidade' => 'max:255',
            'estado' => 'max:2',
            'cep' => 'max:8',
        ];        
    
        return new ValidadeHelper($request, $rules);        
    }
}