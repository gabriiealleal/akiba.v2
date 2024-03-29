<?php 

namespace App\Http\Schemas;

class Top10MusicsSchemas{}

/**
 * @OA\Schema(
 *      schema="Top10MusicsResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="number_of_requests", type="integer"),
 *      @OA\Property(property="avatar", type="string"),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="anime", type="string"),
 * ),
 */
class Top10MusicsResponse{}

/**
 * @OA\Schema(
 *      schema="Top10MusicsRequest",
 *      type="object",
 *      @OA\Property(property="number_of_requests", type="integer"),
 *      @OA\Property(property="avatar", type="string"),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="anime", type="string"),
 * )
 */
class Top10MusicsRequest{}