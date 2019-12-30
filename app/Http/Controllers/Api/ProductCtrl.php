<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;

class ProductCtrl extends Controller
{
    
    /**
     * @OA\Get(
     *     path="/products",
     *     operationId="list products",
     *     tags={"Products"},
     *     summary="Display a listing of the products",
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
        $products = Product::paginate(10);
        return response()->json($products, 200);
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
     *     path="/product/add",
     *     operationId="Add Product",
     *     tags={"Products"},
     *     summary="Add Product",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/ProductSchema")
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'brand_id' => 'required',
            'description' => 'required',
            'photos' => 'required',
            'thumbnail_img' => 'required',
            'featured_img' => 'required',
            'flash_deal_img' => 'required',
            'meta_title' => 'required',
            'meta_description' => 'required',
            'meta_img' => 'required',
            'alamat' => 'required',
            'provinsi' => 'required',
            'kota' => 'required',
            'kecamatan' => 'required',
            'audien_target' => 'required',
            'statistik_masyarakat' => 'required',
            'jumlah_pendengarradio' => 'required',
            'target_pendengarradio' => 'required',
            'pdf' => 'required'
        ]);
        $product = new Product;
        $product->name = $request->name;
        $product->added_by = $request->added_by;
        $product->user_id = $request->user_id;
        $product->category_id = $request->category_id;
        $product->subcategory_id = $request->subcategory_id;
        $product->brand_id = $request->brand_id;
        $product->photos = json_encode($request->photos);
        $product->thumbnail_img = $request->thumbnail_img;
        $product->featured_img = $request->featured_img;
        $product->flash_deal_img = $request->flash_deal_img;
        $colors = [];
        $product->colors = json_encode($colors);
        $product->tags = $request->tags;
        $product->description = $request->description;
        $product->video_provider = $request->video_provider;
        $product->video_link = $request->video_link;
        $product->unit_price = $request->unit_price;
        $product->choice_options = json_encode($request->choice_options);
        $product->variations = json_encode($request->variations);
        $product->tax = $request->tax;
        $product->tax_type = $request->tax_type;
        $product->discount = $request->discount;
        $product->discount_type = $request->discount_type;
        $product->meta_title = $request->meta_title;
        $product->meta_description = $request->meta_description;
        $product->meta_img = $request->meta_img;
        $product->pdf = $request->pdf;
        $product->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name)).'-'.str_random(5);
        $product->latlong = $request->latlong;
        $product->alamat = $request->alamat;
        $product->provinsi = $request->provinsi;
        $product->kota = $request->kota;
        $product->kecamatan = $request->kecamatan;
        $product->audien_target = $request->audien_target;
        $product->statistik_masyarakat = $request->statistik_masyarakat;
        $product->jumlah_pendengarradio = $request->jumlah_pendengarradio;
        $product->target_pendengarradio = $request->target_pendengarradio;
        if ($product->save()) {
            return response()->json([
                'data' => $product,
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ], 200);
        }
        
    }

    /**
    * @OA\Get(
    *     path="/product/{id}",
    *     operationId="list product by id",
    *     tags={"Products"},
    *     summary="Display a listing of the product by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of product to return",
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
        $product = Product::where('id', $id)->first();
        if ($product != null) {
            return response()->json($product, 200);
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
