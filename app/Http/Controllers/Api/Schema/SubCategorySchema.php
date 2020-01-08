<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="Sub Category",
 * )
 */
class SubCategorySchema
{
    /**
     * @OA\Property(property="id",type="integer",example=0)
     */
    public $id;
    /**
     * @OA\Property(property="name",type="string",example="string")
     */
    public $name;
     /**
     * @OA\Property(property="category_id",type="integer",example="string")
     */
    public $category_id;
    /**
     * @OA\Property(property="slug",type="string",example="string")
     */
    public $slug;
    /**
     * @OA\Property(
     *      property="brands", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"7", "4", "3"}, 
     *      @OA\Items(type="string", example="string")
     * )
     */
    public $brands;
    /**
     * @OA\Property(property="meta_title",type="string",example="string")
     */
    public $meta_title;
    /**
     * @OA\Property(property="meta_description",type="string",example="string")
     */
    public $meta_description;
}
