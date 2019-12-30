<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\User;

class RegisterCtrl extends Controller
{
    /**
     * @OA\Post(
     *     path="/register",
     *     operationId="Registration user",
     *     tags={"Registrasi"},
     *     summary="Register user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(property="name",type="string"),
     *                  @OA\Property(property="email",type="string"),
     *                  @OA\Property(property="password",type="string"),
     *                  @OA\Property(property="password_confirmation",type="string"),
     *                  @OA\Property(property="ktp",type="string"),
     *                  @OA\Property(property="npwp",type="string")
     *              )
     *         )
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:6|confirmed',
            'ktp' => 'required',
            'npwp' => 'required',
        ]);
        $user = new User;
        if ($request->all() != null) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = Hash::make($request->password);
            $user->ktp = $request->ktp;
            $user->npwp = $request->npwp;
            $user->save();
            return response()->json([
                'data'    => $user,
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ], 200);
        }
    }
}
