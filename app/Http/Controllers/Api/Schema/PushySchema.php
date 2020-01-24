<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="PushyToken",
 * )
 */
class PushySchema
{
    /**
     * @OA\Property(property="user_id",type="integer",example="123456")
     */
    public $user_id;
     /**
     * @OA\Property(property="device_token",type="string",example="string")
     */
    public $device_token;
}
