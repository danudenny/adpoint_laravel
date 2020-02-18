<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="Order",
 * )
 */
class TransactionSchema{
    /**
     * @OA\Property(property="id",type="integer",example=0)
     */
    public $id;
    /**
     * @OA\Property(property="user_id",type="string",example="string")
     */
    public $user_id;
    /**
     * @OA\Property(property="code",type="string",example="string")
     */
    public $code;
    /**
     * @OA\Property(property="payment_status",type="string",example="string")
     */
    public $payment_status;
    /**
     * @OA\Property(property="payment_type",type="string",example="string")
     */
    public $payment_type;
    /**
     * @OA\Property(property="payment_detail",type="string",example="string")
     */
    public $payment_detail;
    /**
     * @OA\Property(property="file_advertising",type="string",example="string")
     */
    public $file_advertising;
    /**
     * @OA\Property(property="description",type="string",example="string")
     */
    public $description;
    /**
     * @OA\Property(property="viewed",type="string",example="string")
     */
    public $viewed;
    /**
     * @OA\Property(property="status",type="string",example="string")
     */
    public $status;
    /**
     * @OA\Property(property="is_rejected",type="string",example="string")
     */
    public $is_rejected;
    /**
     * @OA\Property(property="created_at",type="string",example="string")
     */
    public $created_at;
    /**
     * @OA\Property(property="updated_at",type="string",example="string")
     */
    public $updated_at;

    public $transactions;

}
