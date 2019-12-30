<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Category;
use App\Product;
use App\HomeCategory;
use File;

class CategoryCtrl extends Controller
{
    /**
     * @OA\Get(
     *     path="/categories",
     *     operationId="list categories",
     *     tags={"Categories"},
     *     summary="Display a listing of the categories",
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
        $categories = Category::paginate(10);
        return response()->json($categories, 200);
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
     *     path="/category/add",
     *     operationId="Add Category",
     *     tags={"Categories"},
     *     summary="Add Category",
     *     security={{"bearerAuth":{}}},
     *     @OA\RequestBody(
     *         @OA\JsonContent(ref="#/components/schemas/CategorySchema")
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'banner' => 'required',
            'icon' => 'required',
            'meta_title' => 'required|string|max:255',
            'meta_description' => 'required|string|max:255',
        ]);
        $category = new Category;
        $category->name = $request->name;
        $category->meta_title = $request->meta_title;
        $category->meta_description = $request->meta_description;
        if ($request->slug != null) {
            $category->slug = str_replace(' ', '-', $request->slug);
        }
        else {
            $category->slug = preg_replace('/[^A-Za-z0-9\-]/', '', str_replace(' ', '-', $request->name));
        }
        $category->banner = $request->banner;
        $category->icon = $request->icon;
        if ($category->save()) {
            return response()->json([
                'data' => $category,
                'success' => true,
                'message' => 'Data berhasil disimpan'
            ], 200);
        }
    }

    /**
    * @OA\Get(
    *     path="/category/{id}",
    *     operationId="list category by id",
    *     tags={"Categories"},
    *     summary="Display a listing of the category by id",
    *     security={{"bearerAuth":{}}},
    *     @OA\Parameter(
    *         description="ID of category to return",
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
        $category = Category::where('id', $id)->first();
        if ($category != null) {
            return response()->json($category, 200);
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
     *      path="/category/edit/{id}",
     *      operationId="Edit category",
     *      tags={"Categories"},
     *      summary="Edit of the category by id",
     *      security={{"bearerAuth":{}}},
     *      @OA\Parameter(
     *          description="ID of edit category",
     *          in="path",
     *          name="id",
     *          required=true,
     *          @OA\Schema(
     *              type="integer",
     *              format="int64"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/CategorySchema")
     *      ),
     *      @OA\Response(response="200",description="ok"),
     *      @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function update(Request $request, $id)
    {
        
        $category = Category::where('id', $id)->first();
        if ($category != null) {
            $category->name = $request->name;
            $category->meta_title = $request->meta_title;
            $category->meta_description = $request->meta_description;
            $category->slug = $request->slug;
            if($request->banner != null){
                $banner = public_path().'/'.$category->banner;
                if (file_exists($banner)) {
                    unlink($banner);
                    $category->banner = $request->banner;
                }
            }
            if($request->icon != null){
                $icon = public_path().'/'.$category->icon;
                if (file_exists($icon)) {
                    unlink($icon);
                    $category->icon = $request->icon;
                }
            }
            if ($category->save()) {
                return response()->json([
                    'data'    => $category,  
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
     *     path="/category/{id}",
     *     operationId="Delete category by id",
     *     tags={"Categories"},
     *     summary="Delete category by id",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="category id",
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
        $category = Category::where('id',$id)->first();
        if ($category != null) {
            foreach ($category->subcategories as $key => $subcategory) {
                foreach ($subcategory->subsubcategories as $key => $subsubcategory) {
                    $subsubcategory->delete();
                }
                $subcategory->delete();
            }
            Product::where('category_id', $category->id)->delete();
            HomeCategory::where('category_id', $category->id)->delete();
            if(Category::destroy($id)){
                if($category->banner != null){
                    $banner = public_path().'/'.$category->banner;
                    if (file_exists($banner)) {
                        unlink($banner);
                    }
                }
                if($category->icon != null){
                    $icon = public_path().'/'.$category->icon;
                    if (file_exists($icon)) {
                        unlink($icon);
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
