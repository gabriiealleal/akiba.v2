<?php 
namespace App\Http\Schemas; 

class ShowsSchemas{}

/**
 * @OA\Schema(
 *      schema="ShowResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(
 *          property="presenter",
 *          type="object",
 *          ref="#/components/schemas/UserResponse"
 *      ),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="logo", type="string"),
 * )
 */

class ShowResponse{}

/**
 * @OA\Schema(
 *      schema="ShowRequest",
 *      type="object",
 *      @OA\Property(property="presenter", type="integer"),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="logo", type="string"),
 * )
 */
class ShowRequest{}