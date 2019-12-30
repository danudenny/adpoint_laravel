<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\FlashDeal;
use App\FlashDealProduct;

class FlashDealCtrl extends Controller
{
    /**
     * @OA\Get(
     *     path="/flashdeals",
     *     operationId="list flashdeal",
     *     tags={"Flash Deals"},
     *     summary="Display a listing of the flashdeal",
     *     security={{"bearerAuth":{}}},
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
        $flash_deals = FlashDeal::paginate(10);
        return response()->json($flash_deals, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

     /**
     * @OA\Post(
     *     path="/flashdeal/add",
     *     operationId="Add Flashdeal",
     *     tags={"Flash Deals"},
     *     summary="Add Flashdeal",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/FlashDealSchema")
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $flash_deal = new FlashDeal;
        $flash_deal->title = $request->title;
        $flash_deal->start_date = strtotime($request->start_date);
        $flash_deal->end_date = strtotime($request->end_date);
        if($flash_deal->save()){
            foreach ($request->products as $key => $product) {
                $flash_deal_product = new FlashDealProduct;
                $flash_deal_product->flash_deal_id = $flash_deal->id;
                $flash_deal_product->product_id = $product;
                $flash_deal_product->discount = $request->discount[$key];
                $flash_deal_product->discount_type = $request->discount_type[$key];
                $flash_deal_product->save();
            }
            return response()->json([
                'data' => $flash_deal,
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ], 200);
        }
    }

    /**
    * @OA\Get(
    *     path="/flashdeal/{id}",
    *     operationId="list flashdeal by id",
    *     tags={"Flash Deals"},
    *     summary="Display a listing of the flashdeal by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of flashdeal to return",
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
        $flash_deal = FlashDeal::where('id', $id)->first();
        if ($flash_deal != null) {
            return response()->json($flash_deal, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }


    /**
     * @OA\Get(
     *     path="/flashdeal_products",
     *     operationId="list flashdeal products",
     *     tags={"Flash Deals"},
     *     summary="Display a listing of the flashdeal products",
     *     security={{"bearerAuth":{}}},
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
    public function get_all_flashdeal_product()
    {
        $flash_deal_product = FlashDealProduct::paginate(10);
        return response()->json($flash_deal_product, 200);
    }

    /**
    * @OA\Get(
    *     path="/flashdeal_product/{id}",
    *     operationId="list flashdeal product by id",
    *     tags={"Flash Deals"},
    *     summary="Display a listing of the flashdeal product by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of flashdeal product to return",
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
    public function get_flashdeal_prouduct_by_id($id)
    {
        $flash_deal_product = FlashDealProduct::where('id', $id)->first();
        if ($flash_deal_product != null) {
            return response()->json($flash_deal_product, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

     /**
     * @OA\Put(
     *      path="/flashdeal/edit/{id}",
     *      operationId="Edit flashdeal",
     *      tags={"Flash Deals"},
     *      summary="Edit of the flashdeal by id",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          description="ID of edit brand",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/FlashDealSchema")
     *      ),
     *      @OA\Response(response="200",description="ok"),
     *      @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $flash_deal = FlashDeal::where('id', $id)->first();
        if ($flash_deal != null) {
            $flash_deal->title = $request->title;
            $flash_deal->start_date = strtotime($request->start_date);
            $flash_deal->end_date = strtotime($request->end_date);
            foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product) {
                $flash_deal_product->delete();
            }
            if($flash_deal->save()){
                foreach ($request->products as $key => $product) {
                    $flash_deal_product = new FlashDealProduct;
                    $flash_deal_product->flash_deal_id = $flash_deal->id;
                    $flash_deal_product->product_id = $product;
                    $flash_deal_product->discount = $request->discount[$key];
                    $flash_deal_product->discount_type = $request->discount_type[$key];
                    $flash_deal_product->save();
                }
                return response()->json([
                    'data'    => $flash_deal,  
                    'success' => true,
                    'message' => 'Data berhasil diedit'
                ], 200);  
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada'
            ], 401);
        }
    }

    /**
     * @OA\Delete(
     *     path="/flashdeal/{id}",
     *     operationId="Delete flashdeal by id",
     *     tags={"Flash Deals"},
     *     summary="Delete flashdeal by id",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="flashdeal id",
     *         in="path",
     *         name="id",
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
    */
    public function destroy($id)
    {
        $flash_deal = FlashDeal::where('id', $id)->first();
        if ($flash_deal != null) {
            foreach ($flash_deal->flash_deal_products as $key => $flash_deal_product) {
                $flash_deal_product->delete();
            }
            if (FlashDeal::destroy($id)) {
                return response()->json([
                    'success' => true,
                    'message' => 'Data berhasil dihapus'
                ], 200);
            }
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ada'
            ], 401);
        }
    }
}
