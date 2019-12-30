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
     * @OA\Property(property="name",type="string",example="Horizontal")
     */
    public $name;
     /**
     * @OA\Property(property="category_id",type="integer",example="1")
     */
    public $category_id;
    /**
     * @OA\Property(property="slug",type="string",example="Videotron")
     */
    public $slug;
    /**
     * @OA\Property(property="brands", type="array", collectionFormat="multi", enum={"7", "4", "3"}, @OA\Items(type="string"))
     */
    public $brands;
    /**
     * @OA\Property(property="meta_title",type="string",example="Videotron")
     */
    public $meta_title;
    /**
     * @OA\Property(property="meta_description",type="string",example="Videotron")
     */
    public $meta_description;
}
