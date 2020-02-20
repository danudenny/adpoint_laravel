<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use JWTAuth;


class UserCtrl extends Controller
{
    /**
    * @OA\Get(
    *     path="/users",
    *     operationId="list user",
    *     tags={"Users"},
    *     summary="Display a listing of the user",
    *     security={{"bearerAuth":{}}},
    *     @OA\Response(response="200",description="ok"),
    *     @OA\Response(response="401",description="unauthorized")
    * )
    */
    public function index()
    {
        $users = User::paginate(10);
        return response()->json($users,200);

    }
    /**
    * @OA\Get(
    *     path="/user/{id}",
    *     operationId="list user by id",
    *     tags={"Users"},
    *     summary="Display a listing of the user by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of user to return",
    *         in="path",
    *         name="id",
    *         required=true,
    *         @OA\Schema(
    *           type="integer",
    *           format="int64"
    *         )
    *     ),
    *     @OA\Response(response="200",description="ok"),
    *     @OA\Response(response="401",description="unauthorized")
    * )
    */
    public function show($id)
    {
        $user = User::where('id', $id)->first();
        if ($user != null) {
            return response()->json($user,200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }

    }

    /**
     * @OA\Get(
     *     path="/profile",
     *     operationId="Current User Profile",
     *     tags={"Users"},
     *     summary="Display a current logged in user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function profile() {
        $profile = auth('api')->user();
        return response()->json(array($profile));
    }
}
