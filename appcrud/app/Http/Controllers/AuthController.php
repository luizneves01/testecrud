<?php

namespace App\Http\Controllers;

use Validator;
use App\Models\User;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Firebase\JWT\ExpiredException;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Routing\Controller as BaseController;

class AuthController extends BaseController
{
    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    /**
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct(Request $request) {
        $this->request = $request;
    }

    /**
     * Criando um novo token
     * 
     * @param  \App\User   $user
     * @return string
     */
    protected function jwt(User $user) {
        $payload = [
            'iss' => "lumen-jwt",
            'sub' => $user->id,
            'iat' => time(),
            'exp' => time() + (60 * 30)
        ];
        
        return JWT::encode($payload, env('JWT_SECRET'));
    } 

    /**
     * 
     * @OA\Post(
     *     path="/api/login",
     *     summary="Irá autenticar um usuário com base em seu usuario e senha",
     *     operationId="authenticate",
     *     tags={"Login"},
     *     @OA\RequestBody(
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="email",
     *                    type="string"
     *                ),
     *                @OA\Property(
     *                    property="password",
     *                    type="string"
     *                ),   
     *                example={"email": "admin@admin.com","password": "admin"}
     *            )
     *        )     
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Será listado json com token de acesso",     
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="token",
     *                    type="string"
     *                ),      
     *                example={"token": "hash do token"}
     *            )
     *        )   
     *     )
     * )
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function authenticate(User $user) {
        $this->validate($this->request, [
            'email'     => 'required|email',
            'password'  => 'required'
        ]);
        
        $user = User::where('email', $this->request->input('email'))->first();
        if (!$user) {
            return response()->json([
                'error' => 'Email não cadastrado.'
            ], 400);
        }
        
        if (Hash::check($this->request->input('password'), $user->password)) {
            return response()->json([
                'token' => $this->jwt($user)
            ], 200);
        }
        
        return response()->json([
            'error' => 'E-mail ou senha incorretas.'
        ], 400);
    }
    
    /**
     * 
     * @OA\Get(
     *     path="/api/refresh-token?token='token'",
     *     summary="Fornece um token renovado",
     *     operationId="refresh",
     *     tags={"Refresh Token"},
     *     @OA\Response(
     *         response=200,
     *         description="Será listado json com token de atualizado",     
     *        @OA\MediaType(
     *            mediaType="application/json",
     *            @OA\Schema(
     *                @OA\Property(
     *                    property="token",
     *                    type="string"
     *                ),      
     *                example={"token": "hash do token"}
     *            )
     *        )   
     *     )
     * )     
     * 
     * @param  \App\User   $user 
     * @return mixed
     */
    public function refresh()
    {
        $token = JWT::decode($this->request->token, env('JWT_SECRET'), ['HS256']);
        $user = User::find($token->sub);
        return response()->json([
            'token' => $this->jwt($user)
        ], 200);
    }
}