<?php

namespace App\Http\Controllers\Api;

use App\Seller;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;

use DB;
use JWTAuth;


class SellerCtrl extends Controller
{
    /**
    * @OA\Get(
    *     path="/sellers",
    *     operationId="list seller",
    *     tags={"Sellers"},
    *     summary="Display a listing of the seller",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="name",
    *         in="query",
    *         name="name",
    *         required=false,
    *         @OA\Schema(
    *           type="string"
    *         )
    *     ),
    *     @OA\Response(response="200",description="ok"),
    *     @OA\Response(response="401",description="unauthorized")
    * )
    */
    public function index(Request $request)
    {
        $sellersFilter = Seller::orderBy('id', 'desc');
        if($request->has('name')) {
            $sellersFilter->where('verification_info', 'LIKE', "%$request->name%");
        }

        $sellers = $sellersFilter->get()->toArray();
        if(count($sellers) > 0) {
            return response()->json(["jumlah" => count($sellers), "data" => $sellers], 200);
        } else {
            return response()->json(["message" => "Data tidak ditemukan"], 200);
        }
    }

    /**
    * @OA\Get(
    *     path="/visit_shop/{id}",
    *     operationId="list product by id seller",
    *     tags={"Sellers"},
    *     summary="Display a listing of the seller by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of seller to return",
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
    public function visit_shop($id)
    {
        $shop = DB::table('users as s')
                ->join('products as p', 'p.user_id', '=', 's.id')
                ->join('shops as sh', 'sh.user_id', '=', 'p.user_id')
                ->where('s.id', $id)
                ->select([
                    'p.*',
                    's.name as seller_name',
                    's.avatar_original as seller_avatar',
                    's.email as seller_email',
                    's.phone as seller_phone',
                    's.address as seller_address',
                    's.postal_code as seller_postal_code',
                    'sh.logo as shop_logo'
                ])->get();

        if ($shop != null) {
            return response()->json($shop,200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/seller_byid/{id}",
     *     operationId="list seller by id seller",
     *     tags={"Sellers"},
     *     summary="Display a seller information by id",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="ID of seller to return information",
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function seller_byid($id)
    {
        $seller = User::where('id', $id)->get();

        if ($seller != null) {
            return response()->json($seller,200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }
}
