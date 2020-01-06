<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="Brand",
 * )
 */
class BrandSchema
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
     * @OA\Property(property="logo",type="string",example="string")
     */
    public $logo;
     /**
     * @OA\Property(property="slug",type="string",example="string")
     */
    public $slug;
    /**
     * @OA\Property(property="meta_title",type="string",example="string")
     */
    public $meta_title;
    /**
     * @OA\Property(property="meta_description",type="string",example="string")
     */
    public $meta_description;
}
