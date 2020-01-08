<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="Order",
 * )
 */
class OrderSchema{
    /**
     * @OA\Property(property="id",type="integer",example=0)
     */
    public $id;
    /**
     * @OA\Property(property="user_id",type="string",example="string")
     */
    public $user_id;
    /**
     * @OA\Property(
     *      property="shipping_address",
     *      type="object",
     *      @OA\Property(property="name",type="string",example="string"),
     *      @OA\Property(property="email",type="string",example="string"),
     *      @OA\Property(property="address",type="text",example="string"),
     *      @OA\Property(property="country",type="string",example="string"),
     *      @OA\Property(property="city",type="string",example="string"),
     *      @OA\Property(property="postal_code",type="string",example="string"),
     *      @OA\Property(property="phone",type="string",example="string"),
     *      @OA\Property(property="checkout_type",type="string",example="string"),
     * )
     */
    public $shipping_address;
    /**
     * @OA\Property(property="payment_type",type="string",example="string")
     */
    public $payment_type;
    /**
     * @OA\Property(property="file_advertising",type="string",example="string")
     */
    public $file_advertising;
    /**
     * @OA\Property(property="desc_advertising",type="string",example="string")
     */
    public $desc_advertising;
    /**
     * @OA\Property(
     *     property="order_details",
     *     type="array",
     *     @OA\Items(
     *          type="object",
     *          @OA\Property(
     *              property="seller_id", 
     *              type="array",
     *              collectionFormat="multi",
     *              enum={"{}"},
     *              @OA\Items(
     *                  type="object",
     *                  @OA\Property(property="product_id",type="string",example="string"),
     *                  @OA\Property(property="user_id",type="string",example="seller_id"),
     *                  @OA\Property(property="periode",type="string",example="string"),
     *                  @OA\Property(property="quantity",type="integer",example=0),
     *                  @OA\Property(property="price",type="integer",example=0),
     *                  @OA\Property(property="tax",type="string",example="string"),
     *                  @OA\Property(property="shipping_type",type="string",example="string"),
     *                  @OA\Property(property="start_date",type="string",example="string"),
     *                  @OA\Property(property="end_date",type="string",example="string"),
     *                  @OA\Property(property="shipping",type="integer",example=0),
     *              )
     *          )
     *     )
     * )
     */
    public $order_details;
    
}