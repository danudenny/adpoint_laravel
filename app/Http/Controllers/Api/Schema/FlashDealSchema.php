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
     * @OA\Property(property="title",type="string",example="string")
     */
    public $title;
    /**
     * @OA\Property(property="start_date",type="string",example="string")
     */
    public $start_date;
    /**
     * @OA\Property(property="end_date",type="string",example="string")
     */
    public $end_date;
    /**
     * @OA\Property(
     *      property="products", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"4","3"}, 
     *      @OA\Items(type="string", example="string")
     * )
     */
    public $products;

    /**
     * @OA\Property(
     *      property="discount", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"10","20"}, 
     *      @OA\Items(type="string", example="string")
     * )
     */
    public $discount;
    /**
     * @OA\Property(
     *      property="discount_type", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"percent","dollar"}, 
     *      @OA\Items(type="string", example="string")
     * )
     */
    public $discount_type;
    /**
     * @OA\Property(property="status",type="string",example="string")
     */
    public $status;
}