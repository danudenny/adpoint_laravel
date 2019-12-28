<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="User",
 * )
 */
class UserSchema{
    /**
     * @OA\Property(property="id",type="integer",example=0)
     */
    public $id;
    /**
     * @OA\Property(property="user_type",type="collection",enum={"customer", "seller", "admin"})
     */
    public $user_type;
     /**
     * @OA\Property(property="name",type="string",example="adpoint")
     */
    public $name;
     /**
     * @OA\Property(property="email",type="string",example="adpoint@gmail.com")
     */
    public $email;
     /**
     * @OA\Property(property="password",type="string",example="password")
     */
    public $password;
    /**
     * @OA\Property(property="avatar_original",type="string",example="uploads/avatar.png")
     */
    public $avatar_original;
    /**
     * @OA\Property(property="address",type="string",example="Jalan Gotong Royong I No 10")
     */
    public $address;
    /**
     * @OA\Property(property="country",type="string",example="ID")
     */
    public $country;
    /**
     * @OA\Property(property="city",type="string",example="Jakarta Selatan")
     */
    public $city;
     /**
     * @OA\Property(property="postal_code",type="string",example="12560")
     */
    public $postal_code;
     /**
     * @OA\Property(property="phone",type="string",example="628128999009")
     */
    public $phone;

}