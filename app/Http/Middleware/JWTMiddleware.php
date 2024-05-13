<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\Exceptions\TokenInvalidException;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Traits\CustomResponse;

class JWTMiddleware
{

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return JsonResponse
     */
    public function handle(Request $request, Closure $next)
    {
        try {

            $user = JWTAuth::parseToken()->authenticate();

        } catch (TokenExpiredException $e) {

            return response()->failed([], 'Token Expired. ERR:<E1009>', 401);

        } catch (TokenInvalidException $e) {

            return response()->failed([], 'Invalid Token. ERR:<E1009>', 401);

        } catch (JWTException $e) {

            return response()->failed([], 'Token not found. ERR:<E1009>', 401);
        }

        return $next($request);
    }
}
