<?php
/**
 * @OA\Schema(
 *     type="object",
 *     title="Review",
 * )
 */

class ReviewSchema {
    /**
     * @OA\Property(property="id",type="integer",example=0)
     */
    public $id;
    /**
     * @OA\Property(property="name",type="string",example="string")
     */
    public $name;
}