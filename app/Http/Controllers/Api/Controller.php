<?php 
namespace App\Http\Controllers\API;

/**
 * @OA\Info(
 *     title="Laravel Adpoint API",
 *     version="1.0.0",
 *     @OA\Contact(
 *         email="alkhamilnaz@gmail.com"
 *     ),
 *     @OA\License(
 *         name="Apache 2.0",
 *         url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *     )
 * ),
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer"
 * ),
 * @OA\Server(
 *     description="Laravel Adpoint API",
 *     url="http://192.168.7.94:8283/api"
 * )
 * @OA\Server(
 *     description="Laravel Adpoint API",
 *     url="https://192.168.7.94:8283/api"
 * )
 * @OA\Response(response=200,description="ok")
 * @OA\Response(response=401,description="bad")
 */
class Controller extends \App\Http\Controllers\Controller
{
}