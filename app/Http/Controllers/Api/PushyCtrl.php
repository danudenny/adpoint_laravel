<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\PushyToken;

class PushyCtrl extends Controller {
    
    /**
     * @OA\Get(
     *     path="/pushy_token",
     *     operationId="list pushy token devices",
     *     tags={"Pushy"},
     *     summary="Display a listing of the pushy token devices",
     *     @OA\Parameter(
     *         description="Page number",
     *         in="query",
     *         name="page",
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
    */
    public function index()
    {
        $pushy_token = PushyToken::paginate(10);
        return response()->json($pushy_token, 200);
    }

    /**
     * @OA\Post(
     *     path="/pushy_token/register/device",
     *     operationId="Add Device Token",
     *     tags={"Pushy"},
     *     summary="Add Device Token",
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/PushySchema")
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required',
            'device_token' => 'required',
        ]);

        if (PushyToken::where('user_id', '=', $request->user_id)->exists()) {
            $device_token = PushyToken::firstOrNew(['user_id' => $request->user_id]);
            $device_token->device_token = $request->device_token;
        } else {
            $device_token = new PushyToken;
            $device_token->user_id = $request->user_id;
            $device_token->device_token = $request->device_token;
        }
        if ($device_token->save()) {
            return response()->json([
                'data' => $device_token,
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ], 200);
        }
    }
}