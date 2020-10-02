<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;

class JwtMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->get('token');
        
        if(!$token) {
            return response()->json([
                'error' => 'Token não econtrado.'
            ], 401);
        }
        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch(ExpiredException $e) {
            return response()->json([
                'error' => 'Provavelmente o token expirou.'
            ], 401);
        } catch(Exception $e) {
            return response()->json([
                'error' => 'Token invalido.'
            ], 400);
        }
        
        $user = User::find($credentials->sub);

        $request->auth = $user;

        return $next($request);
    }
}
