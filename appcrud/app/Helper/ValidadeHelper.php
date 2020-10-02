<?php
namespace App\Helper;

use Illuminate\Http\Request;

use Validator;

class ValidadeHelper{

    protected $message;
    protected $request;
    protected $rules;
    protected $retorno;
    protected $status;


    /**
     * Construtor responsável por setar mensagens em português
     * 
     * @param Request $request
     * @param array $rules
     */
    public function __construct(Request $request, $rules)
    {
        $this->message = [
            'required' => 'O campo :attribute obrigatório',
            'max' => 'O campo :attribute não pode ser maior que :max caracteres.',
            'date' => 'O campo :attribute deve ser um campo do tipo data.',
            'date_format' => 'O campo :attribute deve utilizar o formato :date_format.',
            'unique' => 'O campo :attribute já existe no sistema.'
        ];
        $this->request = $request->all();        
        $this->rules = $rules;

        $this->validate();
    }    

    /**
     * Retornar status
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Aplicar valor de status
     * 
     * @param boolean $value
     */
    public function setStatus($value)
    {
        $this->status = $value;
        return $this;
    }

    /**
     * Retorna mensagem de retorno
     *
     */
    public function getRetorno()
    {
        return $this->retorno;
    }

    /**
     * Aplica valor de retorno
     * 
     * @param array $value
     */
    public function setRetorno($value)
    {
        $this->retorno = $value;
        return $this;
    }

    /**
     * Cria validação com base nas regras impostas no controller
     * 
     */
    public function validate()
    {
        $validate = Validator::make($this->request, $this->rules, $this->message);
        
        if($validate->fails()){
            $this->setRetorno($validate->errors()->all())->setStatus(false);
        }else{            
            $this->setStatus(true);
        }

        return $this;
    }
}
