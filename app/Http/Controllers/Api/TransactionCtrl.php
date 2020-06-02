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
     *      @OA\Parameter(
     *         description="code",
     *         in="query",
     *         name="code",
     *         required=false,
     *         @OA\Schema(
     *           type="string"
     *         )
     *     ),
     *      @OA\Parameter(
     *         description="status",
     *         in="query",
     *         name="status",
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
        $transFilter = Transaction::orderBy('id', 'desc')->with('orders');
        if($request->has('code')) {
            $transFilter->where('code', 'like', "%$request->code%");
        }
        if($request->has('status')) {
            $transFilter->where('status', "$request->status");
        }
        $trans = $transFilter->get()->toArray();
        if ($trans != null) {
            return response()->json(['jumlah' => count($trans), 'data' => $trans], 200);
        }else{
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/transaction-details/{id}",
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
     *     @OA\Response(response="200",description="ok"),
     *     @OA\Response(response="401",description="unauthorized")
     * )
     */
    public function transactionDetails(Request $request, $id)
    {
        $transaction = Transaction::where('id', $request->id)->with(['user', 'orders'])->get();
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
    

    /**
     * @OA\Get(
     *     path="/transaction-unpaid/{user_id}",
     *     operationId="list transaction unpaid by user_id",
     *     tags={"Transactions"},
     *     summary="Display a listing of the transaction unpaid by user_id",
     *     security={{"bearerAuth":{}}},
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
     *     @OA\Response(response="204",description="no data available")
     * )
     */
    public function transactionUnpaid($user_id)
    {
        $transaction = Transaction::where('user_id', $user_id)->where('status', 'approved')->with('user')->get();
        if (count($transaction) > 0) {
            return response()->json($transaction, 200);
        }else{
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 200);
        }
    }

    /**
     * @OA\Get(
     *     path="/transaction-paid/{user_id}",
     *     operationId="list transaction paid by user_id",
     *     tags={"Transactions"},
     *     summary="Display a listing of the transaction paid by user_id",
     *     security={{"bearerAuth":{}}},
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
     *     @OA\Response(response="204",description="no data available")
     * )
     */
    public function transactionPaid($user_id)
    {
        $transaction = Transaction::where('user_id', $user_id)->where('status', 'paid')->with('user')->get();
        if (count($transaction) > 0) {
            return response()->json($transaction, 200);
        }else{
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 200);
        }
    }
}
