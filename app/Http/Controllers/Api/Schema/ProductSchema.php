<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="Products",
 * )
 */
class ProductSchema{
    /**
     * @OA\Property(property="id",type="integer",example=0)
     */
    public $id;
    /**
     * @OA\Property(property="name",type="string",example="string")
     */
    public $name;
    /**
     * @OA\Property(property="added_by",type="string",example="string")
     */
    public $added_by;
    /**
     * @OA\Property(property="user_id",type="string",example="string")
     */
    public $user_id;
    /**
     * @OA\Property(property="category_id",type="string",example="string")
     */
    public $category_id;
    /**
     * @OA\Property(property="subcategory_id",type="string",example="string")
     */
    public $subcategory_id;
    /**
     * @OA\Property(property="brand_id",type="string",example="string")
     */
    public $brand_id;
    /**
     * @OA\Property(
     *      property="photos", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"uploads/products/photos/img1.png", "uploads/products/photos/img2.png"}, 
     *      @OA\Items(type="string", example="string")
     * )
     */
    public $photos;
    /**
     * @OA\Property(property="thumbnail_img",type="string",example="string")
     */
    public $thumbnail_img;
    /**
     * @OA\Property(property="featured_img",type="string",example="string")
     */
    public $featured_img;
     /**
     * @OA\Property(property="flash_deal_img",type="string",example="string")
     */
    public $flash_deal_img;
    /**
     * @OA\Property(property="tags",type="string",example="string")
     */
    public $tags;
    /**
     * @OA\Property(property="description",type="text",example="string")
     */
    public $description;
    /**
     * @OA\Property(property="video_provider",type="string",example="string")
     */
    public $video_provider;
    /**
     * @OA\Property(property="video_link",type="string",example="string")
     */
    public $video_link;
    /**
     * @OA\Property(property="unit_price",type="string",example="string")
     */
    public $unit_price;
    /**
     * @OA\Property(
     *     property="choice_options",
     *     type="array",
     *     @OA\Items(
     *          type="object",
     *          @OA\Property(property="title", type="string",example="string"),
     *          @OA\Property(
     *              property="options", 
     *              type="array",
     *              collectionFormat="multi",
     *              enum={"Bulanan", "Tahunan"},
     *              @OA\Items(type="string",example="string")
     *          )
     *     )
     * )
     */
    public $choice_options;
    /**
     * @OA\Property(
     *      property="variations",
     *      type="object",
     *      @OA\Property(
     *          property="periode",
     *          type="object",
     *          @OA\Property(property="price",type="string",example="string"),
     *          @OA\Property(property="sku",type="string",example="string"),
     *          @OA\Property(property="qty",type="string",example="string"),
     *      )
     * )
     */
    public $variations;
    /**
     * @OA\Property(property="tax",type="string",example="string")
     */
    public $tax;
    /**
     * @OA\Property(property="tax_type",type="string",example="string")
     */
    public $tax_type;
    /**
     * @OA\Property(property="discount",type="string",example="string")
     */
    public $discount;
    /**
     * @OA\Property(property="discount_type",type="string",example="string")
     */
    public $discount_type;
    /**
     * @OA\Property(property="meta_title",type="string",example="string")
     */
    public $meta_title;
    /**
     * @OA\Property(property="meta_description",type="string",example="string")
     */
    public $meta_description;
    /**
     * @OA\Property(property="meta_img",type="string",example="string")
     */
    public $meta_img;
    /**
     * @OA\Property(property="pdf",type="string",example="string")
     */
    public $pdf;
    /**
     * @OA\Property(property="slug",type="string",example="string")
     */
    public $slug;
    /**
     * @OA\Property(property="latlong",type="string",example="string")
     */
    public $latlong;
    /**
     * @OA\Property(property="alamat",type="string",example="string")
     */
    public $alamat;
    /**
     * @OA\Property(property="provinsi",type="string",example="string")
     */
    public $provinsi;
    /**
     * @OA\Property(property="kota",type="string",example="string")
     */
    public $kota;
    /**
     * @OA\Property(property="kecamatan",type="string",example="string")
     */
    public $kecamatan;
    /**
     * @OA\Property(property="audien_target",type="text",example="string")
     */
    public $audien_target;
    /**
     * @OA\Property(property="statistik_masyarakat",type="text",example="string")
     */
    public $statistik_masyarakat;
    /**
     * @OA\Property(property="jumlah_pendengarradio",type="string",example="string")
     */
    public $jumlah_pendengarradio;
    /**
     * @OA\Property(property="target_pendengarradio",type="string",example="string")
     */
    public $target_pendengarradio;
}