<?php

namespace App\Http\Controllers\Api;

use App\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransactionCtrl extends Controller
{
    /**
     * @OA\Get(
     *     path="/transaction",
     *     operationId="list transaction",
     *     tags={"Transactions"},
     *     summary="Display a listing of the transaction",
     *     security={{"bearerAuth":{}}},
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function index()
    {
        $trans = Transaction::orderBy('id', 'desc')->get();
        return response()->json($trans, 200);
    }

    /**
     * @OA\Get(
     *     path="/transaction-details/{id}/{user_id}",
     *     operationId="list transaction details by id and user_id",
     *     tags={"Transactions"},
     *     summary="Display a listing of the transaction details by id and user_id",
     *     security={{"bearerAuth":{}}},
     *     @OA\Parameter(
     *         description="ID of transaction to return",
     *         in="path",
     *         name="id",
     *         required=true,
     *         @OA\Schema(
     *           type="integer",
     *           format="int64"
     *         )
     *     ),
     *     @OA\Parameter(
     *         description="User Id",
     *         in="path",
     *         name="user_id",
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
    public function transactionDetails($id, $user_id)
    {
        $transaction = DB::table('transactions as t')
            -> join('orders as o', 't.id', '=', 'o.transaction_id')
            -> join('order_details as od', 'o.id', '=', 'od.order_id')
            -> orderBy('od.id', 'desc')
            -> where('t.id', $id)
            -> where('o.user_id',$user_id)
            ->get();
        if ($transaction != null) {
            return response()->json($transaction, 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan'
            ], 401);
        }
    }

    /**
     * @OA\Post(
     *     path="/upload-buktitransfer/{id}",
     *     operationId="Upload buktitransfer",
     *     tags={"Transactions"},
     *     summary="Upload bukti transfer",
     *     security={{"bearerAuth":{}}},
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
    public function uploadTrx(Request $request)
    {
        return $this->respone_success($request);
    }

    private function respone_success($request){
        return response()->json([
            'file' => $request->file('file')->store('uploads/bukti_transfer')
        ], 200);
    }

    private function respone_error($type){
        return response()->json([
            'success'   => false,
            'message'   => 'Gagal Upload Bukti Tayang!'
        ], 401);
    }
}
