<?php

namespace App\Http\Controllers\Api\V1;

use App\Models\UserInfo;
use App\Traits\CustomResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\EncryptDecrypt;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Http\Request;


class AuthController extends Controller
{

    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function login()
    {
        try {

            $credentials = request(['email', 'password']);

            if (!$token = JWTAuth::attempt($credentials)) {

                return response()->failed([], 'Invalid Credentials', 401);
            }

            $user = auth()->user();

            $user = new UserResource($user);

            $token = $this->respondWithToken($token)->original;

            return response()->success(compact('user', 'token'), 'Successfully logged in', 200);
        } catch (JWTException $e) {

            Log::error("Internal Server Error <E1001>.");

            return response()->failed([], 'Internal Server Error <E1001>.', 500);
        }
    }


    public function register(UserRequest $request)
    {

        $registerUser = new UserController();

        return $registerUser->store($request);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {

        $user = new UserResource(auth()->user());

        return response()->success($user, 'Successfully Getting authenticated user.', 200);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        try {

            auth()->logout();

            return response()->success([], 'Successfully logged out.', 200);
            
        } catch (\Exception $e) {

            return response()->failed([], 'Failed to logged out <E1004>.', 500);
        }
    }
    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
