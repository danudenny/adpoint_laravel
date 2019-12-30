<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class UploadCtrl extends Controller
{
    /**
     * @OA\Post(
     *     path="/upload",
     *     operationId="Upload image and file",
     *     tags={"Upload Media"},
     *     summary="Upload image and file",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="directory parent ( users/brands/categories/products )",
     *         in="query",
     *         name="parent",
     *         required=true,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="directory child ( users:ktp/npwp | brands:logo | categories:banner/icon | products:photos/thumbnail/featured/flashdeal/meta/pdf  )",
     *         in="query",
     *         required=true,
     *         name="child",
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  required={"file"},
     *                  @OA\Property(
     *                      property="file",
     *                      type="file",
     *                      @OA\Items(
     *                          type="string",
     *                          format="binary",
     *                      ),
     *                  )
     *              )
     *         )
     *     ),
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function single_upload(Request $request)
    {
        switch ($request->parent) {
            case 'users':
                if ($request->child == "ktp") {
                    return $this->respone_success($request);
                }else if($request->child == 'npwp'){
                    return $this->respone_success($request);
                }else{
                    return $this->respone_error('c');
                }
                break;
            case 'brands':
                if ($request->child == "logo") {
                    return $this->respone_success($request);
                }else{
                    return $this->respone_error('c');
                }
                break;
            case 'categories':
                if ($request->child == "banner") {
                    return $this->respone_success($request);
                }else if($request->child == "icon"){
                    return $this->respone_success($request);
                }else{
                    return $this->respone_error('c');
                }
                break;
            case 'products':
                if ($request->child == "photos") {
                    return $this->respone_success($request);
                }else if($request->child == "thumbnail"){
                    return $this->respone_success($request);
                }else if($request->child == "featured"){
                    return $this->respone_success($request);
                }else if($request->child == "flashdeal"){
                    return $this->respone_success($request);
                }else if($request->child == "meta"){
                    return $this->respone_success($request);
                }else if($request->child == "pdf"){
                    return $this->respone_success($request);
                }else{
                    return $this->respone_error('c');
                }
                break;
            default:
                return $this->respone_error('p');
                break;
        }
    }

    private function respone_success($request){
        return response()->json([
            'file' => $request->file('file')->store('uploads/api/'.$request->parent.'/'.$request->child)
        ], 200);
    }

    private function respone_error($type){
        if ($type == 'p') {
            return response()->json([
                'success'   => false,
                'message'   => 'Parent dir tidak sesuai!, silahkan sesuaikan parent dan child dengan contoh descripsi'
            ], 401);
        }else if($type == 'c'){
            return response()->json([
                'success'   => false,
                'message'   => 'Child dir tidak sesuai!, silahkan sesuaikan parent dan child dengan contoh descripsi'
            ], 401);
        }   
    }
}
