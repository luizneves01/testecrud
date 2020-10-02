<?php

namespace App\Http\Controllers;

use Laravel\Lumen\Routing\Controller as BaseController;

/**
 * Class Controller
 * @package App\Http\Controllers
 * @OA\OpenApi(
 *     @OA\Info(
 *         version="1.0.0",
 *         title="Teste Backend Luiz Felipe Tavares das Neves",
 *         description="Todos os endpoins devem ser acompanhados do token de identificação",
 *         @OA\License(name="MIT")
 *     ),
 *     @OA\Server(
 *         description="API parar cadastro de clientes e pedidos",
 *         url="http://localhost:8000/",
 *     ),
 * )
 */
class Controller extends BaseController
{
    //
}
