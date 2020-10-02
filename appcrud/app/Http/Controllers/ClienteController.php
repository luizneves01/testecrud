<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\ClienteValidateRequest;

use App\Models\Cliente;
use App\Models\ClienteEndereco;

class ClienteController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/clientes?token='token'",
     *     summary="Listar todos os clientes",
     *     operationId="index",
     *     tags={"Cliente"},
     *     @OA\Response(
     *         response=200,
     *         description="Será listado json com todos os clientes",     
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="nome",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="dataNascimento",
     *                    type="date"
     *                ),
     *                @OA\Property(
     *                    property="email",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.rua",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.numero",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.bairro",
     *                    type="string"
     *                ),
     * 
     *                @OA\Property(
     *                    property="endereco.cidade",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.estado",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.cep",
     *                    type="string"
     *                ),      
     *                example={{"nome": "Carlo Maggio","dataNascimento": "02/10/2020","email": "hgorczany@example.net","cpf": "8483375584","endereco": {"rua": "Elmore Aufderhar","numero": "94","bairro": "bury","cidade": "Russelchester","estado": "HI","cep": "02016375"}},{"nome": "Carlo Maggio","dataNascimento": "02/10/2020","email": "hgorczany@example.net","cpf": "8483375584","endereco": {"rua": "Elmore Aufderhar","numero": "94","bairro": "bury","cidade": "Russelchester","estado": "HI","cep": "02016375"}}}
     *            )
     *        )     
     *     )
     * )
     */
    public function index()
    {
        return response()->json(Cliente::with('endereco')->get());
    }

    /**
     * @OA\Get(
     *     path="/api/clientes/{id}?token='token'",
     *     summary="Listar um cliente com base em seu ID",
     *     operationId="show",
     *     tags={"Cliente Show"},
     *     @OA\Response(
     *         response=200,
     *         description="Será listado json com dados de um cliente",     
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="nome",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="dataNascimento",
     *                    type="date"
     *                ),
     *                @OA\Property(
     *                    property="email",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.rua",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.numero",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.bairro",
     *                    type="string"
     *                ),
     * 
     *                @OA\Property(
     *                    property="endereco.cidade",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.estado",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.cep",
     *                    type="string"
     *                ),      
     *                example={"nome": "Carlo Maggio","dataNascimento": "02/10/2020","email": "hgorczany@example.net","cpf": "8483375584","endereco": {"rua": "Elmore Aufderhar","numero": "94","bairro": "bury","cidade": "Russelchester","estado": "HI","cep": "02016375"}}
     *            )
     *        )     
     *     )
     * )
     * 
     * @param int $id
     */
    public function show($id)
    {
        $retorno = Cliente::with('endereco')->where('id', $id)->first();
        if(empty($retorno))
            $retorno = ['retorno' => 'Cliente não localizado!'];

        return response()->json($retorno);
    }

    /**
     * Criação de um novo cliente e seu endereço
     * 
     * @OA\Post(
     *     path="/api/clientes?token='token'",
     *     summary="Irá incluir um novo cliente",
     *     operationId="store",
     *     tags={"Cliente Store"},
     *     @OA\RequestBody(
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="nome",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="dataNascimento",
     *                    type="date"
     *                ),
     *                @OA\Property(
     *                    property="email",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.rua",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.numero",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.bairro",
     *                    type="string"
     *                ),
     * 
     *                @OA\Property(
     *                    property="endereco.cidade",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.estado",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.cep",
     *                    type="string"
     *                ),      
     *                example={"nome": "Carlo Maggio","dataNascimento": "02/10/2020","email": "hgorczany@example.net","cpf": "8483375584", "rua": "Elmore Aufderhar","numero": "94","bairro": "bury","cidade": "Russelchester","estado": "HI","cep": "02016375"}
     *            )
     *        )     
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Será incluido no sistema um novo cliente e seu respectivo endereço",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="retorno",
     *                    type="string"
     *                ),
     *                example={"retorno": "Cliente :id criado com sucesso!"}
     *            )
     *        )    
     *     )
     * )
     * 
     * @param Request $request
     */
    public function store(Request $request)
    {        
        $validate = (new ClienteValidateRequest())->validateStore($request);

        if(!$validate->getStatus())
            return response()->json(['retorno' => $validate->getRetorno()], 400);

        try{
            DB::beginTransaction();
                $cliente = Cliente::create($request->all());
                $cliente->endereco()->save(new ClienteEndereco($request->all()));
            DB::commit();
            return response()->json(['retorno' => 'Cliente '.$cliente->id.' criado com sucesso!']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['retorno' => $e->getMessage()], 500);
        }
    }

    /**
     * Atualização de cliente com base em seu id
     * 
     * @OA\Put(
     *     path="/api/clientes/{id}?token='token'",
     *     summary="Irá atualizar um cliente com base em seu id",
     *     operationId="update",
     *     tags={"Cliente Update"},
     *     @OA\RequestBody(
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="nome",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="dataNascimento",
     *                    type="date"
     *                ),
     *                @OA\Property(
     *                    property="email",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.rua",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.numero",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.bairro",
     *                    type="string"
     *                ),
     * 
     *                @OA\Property(
     *                    property="endereco.cidade",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.estado",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="endereco.cep",
     *                    type="string"
     *                ),      
     *                example={"nome": "Carlo Maggio","dataNascimento": "02/10/2020","email": "hgorczany@example.net","cpf": "8483375584", "rua": "Elmore Aufderhar","numero": "94","bairro": "bury","cidade": "Russelchester","estado": "HI","cep": "02016375"}
     *            )
     *        )     
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Será atualizado os dados enviados do cliente!",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="retorno",
     *                    type="string"
     *                ),
     *                example={"retorno": "Cliente :id atualizado com sucesso!"}
     *            )
     *        )
     *     )
     * )
     * 
     * @param Request $request
     * @param int $id
     */
    public function update(Request $request, $id)
    {
        $validate = (new ClienteValidateRequest())->validateUpdate($request);

        if(!$validate->getStatus())
            return response()->json(['retorno' => $validate->getRetorno()], 400);

        try{
            DB::beginTransaction();
                $cliente = Cliente::find($id);
                $cliente->fill($request->all())->save();
                //Com uma customização simples poderemos trabalhar com mais de um endereço, mas seguindo a especificação manterei apenas 1 endereço   
                $cliente->endereco[0]->fill($request->all())->save();
            DB::commit();            
            return response()->json(['retorno' => 'Cliente '.$cliente->id.' atualizado com sucesso!']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['retorno' => $e->getMessage()], 500);
        }
    }

    /**
     * Remover um cliente com base em seu id
     *
     * @OA\Delete(
     *     path="/api/clientes/{id}?token='token'",
     *     summary="Irá remover um cliente com base em seu id",
     *     operationId="destroy",
     *     tags={"Cliente Destroy"},     
     *     @OA\Response(
     *         response=200,
     *         description="O cliente será removido do sistema",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="retorno",
     *                    type="string"
     *                ),
     *                example={"retorno": "Cliente :id removido com sucesso!"}
     *            )
     *        )
     *     )
     * )
     * 
     * @param Request $request
     * @param int $id
     */
    public function destroy(Request $request, $id)
    {
        try{
            DB::beginTransaction();
                ClienteEndereco::where('cliente_id', $id)->delete();
                Cliente::where('id', $id)->delete();
            DB::commit();            
            return response()->json(['retorno' => 'Cliente '.$id.' removido com sucesso!']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['retorno' => $e->getMessage()], 500);
        }
    }
}
