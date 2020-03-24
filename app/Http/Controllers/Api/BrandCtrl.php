<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Brand;
use App\Product;
use DB;

class BrandCtrl extends Controller
{
    /**
     * @OA\Get(
     *     path="/brands",
     *     operationId="list brands",
     *     tags={"Brands"},
     *     summary="Display a listing of the brands",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
    */
    public function index()
    {
        $brands = Brand::orderBy('id', 'desc')->get();
        return response()->json($brands, 200);
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
     *     path="/brand/add",
     *     operationId="Add Brand",
     *     tags={"Brands"},
     *     summary="Add Brand",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/BrandSchema")
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'logo' => 'required',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
        ]);
        $brand = new Brand;
        $brand->name = $request->name;
        $brand->logo = $request->logo;
        $brand->meta_title = $request->meta_title;
        $brand->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $brand->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $brand->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name));
        }
        if ($brand->save()) {
            return response()->json([
                'data' => $brand,
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ], 200);
        }
    }

    /**
    * @OA\Get(
    *     path="/brand/{id}",
    *     operationId="list brand by id",
    *     tags={"Brands"},
    *     summary="Display a listing of the brand by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of brand to return",
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
        $brand = Brand::where('id', $id)->get();
        if ($brand != null) {
            return response()->json($brand, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    /**
    * @OA\Get(
    *     path="/search_brand",
    *     operationId="Search brand by name",
    *     tags={"Brands"},
    *     summary="Search brand by name",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="name of brand to return",
    *         in="query",
    *         name="query",
    *         required=true,
    *         @OA\Schema(
    *           type="string",
    *         )
    *     ),
    *     @OA\Response(response="200",description="ok"),
    *     @OA\Response(response="401",description="unauthorized")
    * )
    */
    public function search(Request $request)
    {
        $q = $request->query;
        $value = null;
        foreach ($q as $key => $v) {
            $value = $v;
        }
        $brand = Brand::where('name', 'like', '%'.$value.'%')->get();
        if ($brand != null) {
            return response()->json($brand, 200);
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
     *      path="/brand/edit/{id}",
     *      operationId="Edit brand",
     *      tags={"Brands"},
     *      summary="Edit of the brand by id",
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
     *          @OA\JsonContent(ref="#/components/schemas/BrandSchema")
     *      ),
     *      @OA\Response(response="200",description="ok"),
     *      @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $brand = Brand::where('id', $id)->first();
        if ($brand != null) {
            $brand->name = $request->name;
            $brand->meta_title = $request->meta_title;
            $brand->meta_description = $request->meta_description;
            $brand->slug = $request->slug;
            if($request->logo != null){
                $logo = public_path().'/'.$brand->logo;
                if (file_exists($logo)) {
                    unlink($logo);
                    $brand->logo = $request->logo;
                }
            }
            if ($brand->save()) {
                return response()->json([
                    'data'    => $brand,  
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
     *     path="/brand/{id}",
     *     operationId="Delete brand by id",
     *     tags={"Brands"},
     *     summary="Delete brand by id",
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
        $brand = Brand::where('id', $id)->first();
        if ($brand != null) {
            Product::where('brand_id', $brand->id)->delete();
            if(Brand::destroy($id)){
                if($brand->logo != null){
                    $logo = public_path().'/'.$brand->logo;
                    if (file_exists($logo)) {
                        unlink($logo);
                    }
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
}
