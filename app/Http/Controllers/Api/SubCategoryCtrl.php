<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\SubCategory;
use App\Product;

class SubCategoryCtrl extends Controller
{
    /**
     * @OA\Get(
     *     path="/subcategories",
     *     operationId="list subcategories",
     *     tags={"Sub Categories"},
     *     summary="Display a listing of the subcategories",
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
        $subcategories = SubCategory::paginate(10);
        return response()->json($subcategories, 200);
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
     *     path="/subcategory/add",
     *     operationId="Add Subcategory",
     *     tags={"Sub Categories"},
     *     summary="Add Subcategory",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/SubCategorySchema")
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function store(Request $request)
    {

        $subcategory = new SubCategory;
        $subcategory->name = $request->name;
        $subcategory->category_id = $request->category_id;
        $subcategory->brands = json_encode($request->brands);

        $subcategory->meta_title = $request->meta_title;
        $subcategory->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $subcategory->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name));
        }

        if($subcategory->save()){
            return response()->json([
                'data' => $subcategory,
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ], 200);
        }
    }

     /**
    * @OA\Get(
    *     path="/subcategory/{id}",
    *     operationId="list subcategory by id",
    *     tags={"Sub Categories"},
    *     summary="Display a listing of the subcategory by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of subcategory to return",
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
        $subcategory = SubCategory::where('id', $id)->first();
        if ($subcategory != null) {
            return response()->json($subcategory, 200);
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
     *      path="/subcategory/edit/{id}",
     *      operationId="Edit subcategory",
     *      tags={"Sub Categories"},
     *      summary="Edit of the subcategory by id",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          description="ID of edit subcategory",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/SubCategorySchema")
     *      ),
     *      @OA\Response(response="200",description="ok"),
     *      @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        $subcategory = SubCategory::where('id', $id)->first();
        if ($subcategory != null) {
            $subcategory->name = $request->name;
            $subcategory->category_id = $request->category_id;
            $subcategory->brands = json_encode($request->brands);
            $subcategory->meta_title = $request->meta_title;
            $subcategory->meta_description = $request->meta_description;
            if ($request->slug != null) {
                $subcategory->slug = str_replace(' ', '-', $request->slug);
            }
            else {
                $subcategory->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name));
            }
            if ($subcategory->save()) {
                return response()->json([
                    'data'    => $subcategory,  
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
     *     path="/subcategory/{id}",
     *     operationId="Delete subcategory by id",
     *     tags={"Sub Categories"},
     *     summary="Delete subcategory by id",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="subcategory id",
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
        $subcategory = SubCategory::where('id',$id)->first();
        if ($subcategory != null) {
            Product::where('subcategory_id', $subcategory->id)->delete();
            if(SubCategory::destroy($id)){
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
