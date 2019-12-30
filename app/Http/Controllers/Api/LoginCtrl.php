<?php

namespace App\Http\Controllers\Api;

use JWTAuth;
use Illuminate\Http\Request;
use App\User;
use App\Http\Controllers\Controller;

class LoginCtrl extends Controller
{
    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="Login user",
     *     tags={"Auth"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "nazmudin@imaniprima.com", "password": "nazmudin"}
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function login(Request $request)
    {
        $input = $request->only('email', 'password');
        $token = null;
        $user = User::where('email', $request->email)->first();
        if ($user != null) {
            if (password_verify($request->password, $user->password) == true) {
                if ($user->verified == 1) {
                    if (!$token = JWTAuth::attempt($input)) {
                        return $this->_responses(false,'Tidak valid',401);
                    }else{
                        return response()->json([
                            'token' => $token
                        ], 200);
                    }
                }else{
                    return $this->_responses(false,'Akun belum diaktifasi',401);
                }
            }else{
                return $this->_responses(false,'Password tidak sessuai',401);
            }
        }else{
            return $this->_responses(false,'Email tidak terdaftar',401);
        }
    }

    private function _responses($success, $message, $code)
    {
        return response()->json([
            'success' => $success,
            'message' => $message,
        ], $code);
    }
}
