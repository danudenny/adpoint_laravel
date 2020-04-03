<?php
namespace App\Http\Controllers\API;

/**
 * @OA\Info(
 *     title="Laravel InnovAPS API",
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
 *     description="Laravel InnovAPS API",
 *     url="https://aps.jaladara.com/mobile/api"
 * )
 * @OA\Server(
 *     description="Laravel InnovAPS API",
 *     url="https://aps.jaladara.com/mobile/api"
 * )
 * @OA\Response(response=200,description="ok")
 * @OA\Response(response=401,description="bad")
 */

//  local
//  http://localhost:8000/api
//  https://localhost:8000/api
//  public
//  http://192.168.7.94:8188/api
//  https://192.168.7.94:8188/api


class Controller extends \App\Http\Controllers\Controller
{
}
