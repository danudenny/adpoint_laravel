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
     * @OA\Property(property="name",type="string",example="Billboard Cilandak")
     */
    public $name;
    /**
     * @OA\Property(property="added_by",type="string",example="seller")
     */
    public $added_by;
    /**
     * @OA\Property(property="user_id",type="string",example="20")
     */
    public $user_id;
    /**
     * @OA\Property(property="category_id",type="string",example="5")
     */
    public $category_id;
    /**
     * @OA\Property(property="subcategory_id",type="string",example="2")
     */
    public $subcategory_id;
    /**
     * @OA\Property(property="brand_id",type="string",example="7")
     */
    public $brand_id;
    /**
     * @OA\Property(
     *      property="photos", 
     *      type="array", 
     *      collectionFormat="multi", 
     *      enum={"uploads\/products\/photos\/img1.png", "uploads\/products\/photos\/img2.png"}, 
     *      @OA\Items(type="string", example="uploads/foto1.jpg")
     * )
     */
    public $photos;
    /**
     * @OA\Property(property="thumbnail_img",type="string",example="uploads/thumbnail_img.png")
     */
    public $thumbnail_img;
    /**
     * @OA\Property(property="featured_img",type="string",example="uploads/featured_img.png")
     */
    public $featured_img;
     /**
     * @OA\Property(property="flash_deal_img",type="string",example="uploads/flash_deal_img.png")
     */
    public $flash_deal_img;
    /**
     * @OA\Property(property="tags",type="string",example="billboard,baleho,cilandak")
     */
    public $tags;
    /**
     * @OA\Property(property="description",type="text",example="<p>description</p>")
     */
    public $description;
    /**
     * @OA\Property(property="video_provider",type="string",example="youtobe")
     */
    public $video_provider;
    /**
     * @OA\Property(property="video_link",type="string",example="https://www.youtube.com/watch?v=qn8HDW68cIk&t=979s")
     */
    public $video_link;
    /**
     * @OA\Property(property="unit_price",type="string",example="30000000")
     */
    public $unit_price;
    /**
     * @OA\Property(
     *     property="choice_options",
     *     type="array",
     *     @OA\Items(
     *          type="object",
     *          @OA\Property(property="title", type="string",example="Periode"),
     *          @OA\Property(
     *              property="options", 
     *              type="array",
     *              collectionFormat="multi",
     *              enum={"Bulanan", "Tahunan"},
     *              @OA\Items(type="string",example="Bulanan")
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
     *          property="Harian",
     *          type="object",
     *          @OA\Property(property="price",type="string",example="1000"),
     *          @OA\Property(property="sku",type="string",example="BH-Harian"),
     *          @OA\Property(property="qty",type="string",example="1000"),
     *      )
     * )
     */
    public $variations;
    /**
     * @OA\Property(property="tax",type="string",example="10")
     */
    public $tax;
    /**
     * @OA\Property(property="tax_type",type="string",example="amount")
     */
    public $tax_type;
    /**
     * @OA\Property(property="discount",type="string",example=null)
     */
    public $discount;
    /**
     * @OA\Property(property="discount_type",type="string",example=null)
     */
    public $discount_type;
    /**
     * @OA\Property(property="meta_title",type="string",example="Billboard Cilandak")
     */
    public $meta_title;
    /**
     * @OA\Property(property="meta_description",type="string",example="Billboard Cilandak")
     */
    public $meta_description;
    /**
     * @OA\Property(property="meta_img",type="string",example="uploads/meta_img.png")
     */
    public $meta_img;
    /**
     * @OA\Property(property="pdf",type="string",example="uploads/document.pdf")
     */
    public $pdf;
    /**
     * @OA\Property(property="slug",type="string",example="Billboard-Cilandak")
     */
    public $slug;
    /**
     * @OA\Property(property="latlong",type="string",example="-6.881291,107.58345299999996")
     */
    public $latlong;
    /**
     * @OA\Property(property="alamat",type="text",example="Komplek Setra Sari Mall Blok C3 No. 35")
     */
    public $alamat;
    /**
     * @OA\Property(property="provinsi",type="string",example="Jawa Barat")
     */
    public $provinsi;
    /**
     * @OA\Property(property="kota",type="string",example="Bogor")
     */
    public $kota;
    /**
     * @OA\Property(property="kecamatan",type="string",example="Leuwiliang")
     */
    public $kecamatan;
    /**
     * @OA\Property(property="audien_target",type="text",example="pengguna jalan")
     */
    public $audien_target;
    /**
     * @OA\Property(property="statistik_masyarakat",type="text",example="Wirausaha:orang|Swasta:orang")
     */
    public $statistik_masyarakat;
    /**
     * @OA\Property(property="jumlah_pendengarradio",type="string",example="20")
     */
    public $jumlah_pendengarradio;
    /**
     * @OA\Property(property="target_pendengarradio",type="string",example="Wirausaha:orang|Swasta:orang")
     */
    public $target_pendengarradio;
}