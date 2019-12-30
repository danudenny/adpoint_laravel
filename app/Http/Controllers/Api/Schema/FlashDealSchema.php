<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="Flash Deal",
 * )
 */
class FlashDealSchema{
    /**
     * @OA\Property(property="id",type="integer",example=0)
     */
    public $id;
    /**
     * @OA\Property(property="title",type="string",example="flashdeal")
     */
    public $title;
    /**
     * @OA\Property(property="start_date",type="string",example="20 Dec 2019")
     */
    public $start_date;
    /**
     * @OA\Property(property="end_date",type="string",example="26 Dec 2019")
     */
    public $end_date;
    /**
     * @OA\Property(
     *      property="products", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"4","3"}, 
     *      @OA\Items(type="string", example="4")
     * )
     */
    public $products;

    /**
     * @OA\Property(
     *      property="discount", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"10","20"}, 
     *      @OA\Items(type="string", example="10")
     * )
     */
    public $discount;
    /**
     * @OA\Property(
     *      property="discount_type", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"percent","dollar"}, 
     *      @OA\Items(type="string", example="percent")
     * )
     */
    public $discount_type;
    /**
     * @OA\Property(property="status",type="string",example="0")
     */
    public $status;
}