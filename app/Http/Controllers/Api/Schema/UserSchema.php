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
     * @OA\Property(
     *      property="user_type",
     *      type="array",
     *      enum={"customer", "seller", "admin"},
     *      @OA\Items(type="string", example="string")
     * )
     */
    public $user_type;
     /**
     * @OA\Property(property="name",type="string",example="string")
     */
    public $name;
     /**
     * @OA\Property(property="email",type="string",example="string")
     */
    public $email;
     /**
     * @OA\Property(property="password",type="string",example="string")
     */
    public $password;
    /**
     * @OA\Property(property="avatar_original",type="string",example="string")
     */
    public $avatar_original;
    /**
     * @OA\Property(property="address",type="string",example="string")
     */
    public $address;
    /**
     * @OA\Property(property="country",type="string",example="string")
     */
    public $country;
    /**
     * @OA\Property(property="city",type="string",example="string")
     */
    public $city;
     /**
     * @OA\Property(property="postal_code",type="string",example="string")
     */
    public $postal_code;
     /**
     * @OA\Property(property="phone",type="string",example="string")
     */
    public $phone;

}