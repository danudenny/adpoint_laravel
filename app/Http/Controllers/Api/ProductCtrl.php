<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class ProductCtrl extends Controller
{

    /**
     * @OA\Get(
     *     path="/products",
     *     operationId="list products",
     *     tags={"Products"},
     *     summary="Display a listing of the products",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
    */
    public function index()
    {
        $products = DB::table('products as p')
                    -> join('users as u', 'p.user_id', '=', 'u.id')
                    -> select('p.*', 'u.name as sellerName', 'u.id as userID', 'u.avatar_original', 'u.city', 'u.address')
                    -> where('u.user_type', 'seller')
                    -> orderBy('p.id', 'desc')->get();
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
        $product = DB::table('products as p')
            -> join('users as u', 'p.user_id', '=', 'u.id')
            -> select('p.*', 'u.name as sellerName', 'u.id as userID', 'u.avatar_original', 'u.city', 'u.address')
            -> where('u.user_type', 'seller')
            -> where('p.id', '=',$id)
            -> get();
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
    * @OA\Get(
    *     path="/product_review/{id}",
    *     operationId="list product review by id",
    *     tags={"Products"},
    *     summary="Display a listing of the product review by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of product review to return",
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

    public function product_review($id)
    {
        $review = DB::table('reviews as r')
                    ->join('users as b', 'b.id', '=', 'r.user_id')
                    ->where('r.product_id', $id)
                    ->select([
                        'r.*',
                        'b.name as buyer_name',
                        'b.email as buyer_email',
                        'b.avatar_original as buyer_avatar'
                    ])
                    ->get();
        if (count($review) > 0) {
            return response()->json($review, 200);
        }else {
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
     *      path="/product/edit/{id}",
     *      operationId="Edit product",
     *      tags={"Products"},
     *      summary="Edit of the product by id",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          description="ID of edit product",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/ProductSchema")
     *      ),
     *      @OA\Response(response="200",description="ok"),
     *      @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $product = Product::where('id', $id)->first();
        if ($product != null) {
            $product->name = $request->name;
            $product->added_by = $request->added_by;
            $product->user_id = $request->user_id;
            $product->category_id = $request->category_id;
            $product->subcategory_id = $request->subcategory_id;
            $product->brand_id = $request->brand_id;

            // edit photos
            $photos = json_decode($product->photos);
            if ($photos != null) {
                foreach ($photos as $key => $p) {
                    $this->delete_file($p);
                }
            }
            $product->photos = json_encode($request->photos);
            // end edit photos

            if ($product->thumbnail_img != null) {
                $this->delete_file($product->thumbnail_img);
                $product->thumbnail_img = $request->thumbnail_img;
            }

            if ($product->featured_img != null) {
                $this->delete_file($product->featured_img);
                $product->featured_img = $request->featured_img;
            }

            if ($product->flash_deal_img != null) {
                $this->delete_file($product->flash_deal_img);
                $product->flash_deal_img = $request->flash_deal_img;
            }

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

            if ($product->meta_img != null) {
                $this->delete_file($product->meta_img);
                $product->meta_img = $request->meta_img;
            }

            if ($product->pdf != null) {
                $this->delete_file($product->pdf);
                $product->pdf = $request->pdf;
            }

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

    private function delete_file($filename)
    {
        $path = public_path().'/'.$filename;
        if (file_exists($path)) {
            unlink($path);
        }
    }

     /**
     * @OA\Delete(
     *     path="/product/{id}",
     *     operationId="Delete product by id",
     *     tags={"Products"},
     *     summary="Delete product by id",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="brand id",
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
        $product = Product::where('id',$id)->first();
        if ($product != null) {
            if (Product::destroy($id)) {
                $photos = json_decode($product->photos);
                if ($photos != null) {
                    foreach ($photos as $key => $p) {
                        $this->delete_file($p);
                    }
                }
                if ($product->thumbnail_img != null) {
                    $this->delete_file($product->thumbnail_img);
                }
                if ($product->featured_img != null) {
                    $this->delete_file($product->featured_img);
                }
                if ($product->flash_deal_img != null) {
                    $this->delete_file($product->flash_deal_img);
                }
                if ($product->meta_img != null) {
                    $this->delete_file($product->meta_img);
                }
                if ($product->pdf != null) {
                    $this->delete_file($product->pdf);
                }
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

    /**
     * @OA\Get(
     *     path="/product_bycategory/{category_id}",
     *     operationId="list product by category id",
     *     tags={"Products"},
     *     summary="Display a listing of the product by category id",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="category id",
     *         in="path",
     *         name="category_id",
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function product_bycategory($category_id)
    {
        $product = DB::table('products as p')
            -> join('users as u', 'p.user_id', '=', 'u.id')
            -> select('p.*', 'u.name as sellerName', 'u.id as userID', 'u.avatar_original', 'u.city', 'u.address')
            -> where('u.user_type', 'seller')
            -> where('p.category_id', $category_id)
            -> orderBy('p.id', 'desc')
            -> get();
        if (count($product) > 0) {
            return response()->json($product, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    /**
     * @OA\Get(
     *     path="/product_bycategoryseller/{category_id}",
     *     operationId="list product by category id and current user",
     *     tags={"Products"},
     *     summary="Display a listing of the product by category id and current user",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="category id",
     *         in="path",
     *         name="category_id",
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function product_bycategoryseller($category_id)
    {
        $product = Product::where('category_id', $category_id)->where('user_id', Auth::user()->id)->get();
        if (count($product) > 0) {
            return response()->json($product, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    
}
