<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Http\Requests\PedidoValidateRequest;
use App\Service\PedidoService;

use App\Models\PedidoCliente;

class PedidoController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/pedidos?token='token'",
     *     summary="Listar todos os pedidos",
     *     operationId="index",
     *     tags={"Pedido"},
     *     @OA\Response(
     *         response=200,
     *         description="Será listado json com todos os pedidos",     
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="valor",
     *                    type="float"
     *                ),
     *                @OA\Property(
     *                    property="cpf",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.titular",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.numero",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.data_expiracao",
     *                    type="date"
     *                ),
     *                @OA\Property(
     *                    property="cartao.bandeira",
     *                    type="string"
     *                ),
     * 
     *                @OA\Property(
     *                    property="cartao.cvv",
     *                    type="string"
     *                ),
     *                example={{"valor": 100.01, "cpf": "11111111111", "cartao": {"titular": "LUIZ F T NEVES", "numero": "1111111111111111", "data_expiracao": "01/2020", "banderia": "VISA", "cvv": 123}}, {"valor": 100.01, "cpf": "11111111111", "cartao": {"titular": "LUIZ F T NEVES", "numero": "1111111111111111", "data_expiracao": "01/2020", "banderia": "VISA", "cvv": 123}}}
     *            )
     *        )     
     *     )
     * )
     * 
     */
    public function index()
    {
        return response()->json(PedidoCliente::pedidoCompleto());
    }

    /**
     * @OA\Get(
     *     path="/api/pedidos/{id}?token='token'",
     *     summary="Listar pedido com base em seu id",
     *     operationId="show",
     *     tags={"Pedido Show"},
     *     @OA\Response(
     *         response=200,
     *         description="Será listado json com um pedido",     
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="valor",
     *                    type="float"
     *                ),
     *                @OA\Property(
     *                    property="cpf",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.titular",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.numero",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.data_expiracao",
     *                    type="date"
     *                ),
     *                @OA\Property(
     *                    property="cartao.bandeira",
     *                    type="string"
     *                ),
     * 
     *                @OA\Property(
     *                    property="cartao.cvv",
     *                    type="string"
     *                ),
     *                example={"valor": 100.01, "cpf": "11111111111", "cartao": {"titular": "LUIZ F T NEVES", "numero": "1111111111111111", "data_expiracao": "01/2020", "banderia": "VISA", "cvv": 123}}
     *            )
     *        )     
     *     )
     * )
     * 
     * @param int $id
     */
    public function show($id)
    {
        $retorno = PedidoCliente::pedidoCompleto($id);
        if($retorno->count() < 1)
            $retorno = ['retorno' => 'Pedido não localizado!'];

        return response()->json($retorno);
    }

    /**
     * @OA\Post(
     *     path="/api/pedidos?token='token'",
     *     summary="Irá incluir um novo pedido",
     *     operationId="store",
     *     tags={"Pedido Store"},
     *     @OA\RequestBody(
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="valor",
     *                    type="float"
     *                ),
     *                @OA\Property(
     *                    property="cpf",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.titular",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.numero",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.data_expiracao",
     *                    type="date"
     *                ),
     *                @OA\Property(
     *                    property="cartao.bandeira",
     *                    type="string"
     *                ),
     * 
     *                @OA\Property(
     *                    property="cartao.cvv",
     *                    type="string"
     *                ),
     *                example={"valor": 100.01, "cpf": "11111111111", "cartao": {"titular": "LUIZ F T NEVES", "numero": "1111111111111111", "data_expiracao": "01/2020", "banderia": "VISA", "cvv": 123}}
     *            )
     *        )     
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Será incluido no sistema um novo cartão e um pedido para o cliente relacionado ao CPF",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="retorno",
     *                    type="string"
     *                ),
     *                example={"retorno": "Pedido :id criado com sucesso!"}
     *            )
     *        )     
     *     )
     * )
     * 
     * @param Request $request
     */
    public function store(Request $request)
    {
        $validate = (new PedidoValidateRequest())->validateStore($request);

        if(!$validate->getStatus())
            return response()->json(['retorno' => $validate->getRetorno()], 400);

        try{
            DB::beginTransaction();
                $pedido = PedidoService::novoPedido($request);
            DB::commit();
            return response()->json(['retorno' => 'Pedido '.$pedido->id.' criado com sucesso!']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['retorno' => $e->getMessage()], 500);
        }
    }

    /**
      * @OA\Put(
     *     path="/api/pedidos/{id}?token='token'",
     *     summary="Irá atualizar um pedido",
     *     operationId="update",
     *     tags={"Pedido update"},
     *     @OA\RequestBody(
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="valor",
     *                    type="float"
     *                ),
     *                @OA\Property(
     *                    property="cpf",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.titular",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.numero",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="cartao.data_expiracao",
     *                    type="date"
     *                ),
     *                @OA\Property(
     *                    property="cartao.bandeira",
     *                    type="string"
     *                ),
     * 
     *                @OA\Property(
     *                    property="cartao.cvv",
     *                    type="string"
     *                ),
     *                example={"valor": 100.01, "cpf": "11111111111", "cartao": {"titular": "LUIZ F T NEVES", "numero": "1111111111111111", "data_expiracao": "01/2020", "banderia": "VISA", "cvv": 123}}
     *            )
     *        )     
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Será atualizado no sistema o pedido e o cartao vinculado ao pedido",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="retorno",
     *                    type="string"
     *                ),
     *                example={"retorno": "Pedido :id atualizado com sucesso!"}
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
        $validate = (new PedidoValidateRequest())->validateUpdate($request);

        if(!$validate->getStatus())
            return response()->json(['retorno' => $validate->getRetorno()], 400);

        try{
            DB::beginTransaction();
                $pedido = PedidoService::atualizarPedido($request, $id);
            DB::commit();
            return response()->json(['retorno' => 'Pedido '.$pedido->id.' atualizado com sucesso!']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['retorno' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/pedidos/{id}?token='token'",
     *     summary="Irá remover um pedido com base em seu id",
     *     operationId="destroy",
     *     tags={"Pedido Destroy"},     
     *     @OA\Response(
     *         response=200,
     *         description="O pedido será removido do sistema",
     *         @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="retorno",
     *                    type="string"
     *                ),
     *                example={"retorno": "Pedido :id removido com sucesso!"}
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
                PedidoCliente::where('id', $id)->delete();
            DB::commit();            
            return response()->json(['retorno' => 'Pedido '.$id.' removido com sucesso!']);
        }catch(\Exception $e){
            DB::rollBack();
            return response()->json(['retorno' => $e->getMessage()], 500);
        }
    }
}