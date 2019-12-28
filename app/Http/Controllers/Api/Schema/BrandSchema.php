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
     * @OA\Property(property="name",type="string",example="MCM Media")
     */
    public $name;
     /**
     * @OA\Property(property="logo",type="string",example="uploads/logo.jpg")
     */
    public $logo;
     /**
     * @OA\Property(property="slug",type="string",example="MCM Media")
     */
    public $slug;
    /**
     * @OA\Property(property="meta_title",type="string",example="MCM Media")
     */
    public $meta_title;
    /**
     * @OA\Property(property="meta_description",type="string",example="MCM Media")
     */
    public $meta_description;
}
