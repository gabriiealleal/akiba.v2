<?php 

namespace App\Http\Schemas;

class FormsSchemas{}

/**
 * @OA\Schema(
 *      schema="FormsResponse",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="type", type="string"),
 *      @OA\Property(property="content", type="string"),
 * )
 */
class FormsResponse{}

/**
 * @OA\Schema(
 *      schema="FormsRequest",
 *      @OA\Property(property="type", type="string"),
 *      @OA\Property(property="content", type="string"),
 * )
 */
class FormsRequest{}