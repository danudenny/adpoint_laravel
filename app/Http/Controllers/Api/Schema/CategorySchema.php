<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="Category",
 * )
 */
class CategorySchema
{
    /**
     * @OA\Property(property="id",type="integer",example=0)
     */
    public $id;
    /**
     * @OA\Property(property="name",type="string",example="Videotron")
     */
    public $name;
     /**
     * @OA\Property(property="banner",type="string",example="uploads/icon.jpg")
     */
    public $banner;
    /**
     * @OA\Property(property="icon",type="string",example="uploads/banner.jpg")
     */
    public $icon;
    /**
     * @OA\Property(property="slug",type="string",example="Videotron")
     */
    public $slug;
    /**
     * @OA\Property(property="meta_title",type="string",example="Videotron")
     */
    public $meta_title;
    /**
     * @OA\Property(property="meta_description",type="string",example="Videotron")
     */
    public $meta_description;
}
