<?php

namespace App\Http\Schemas;

class ListenerOfTheMonthSchemas{}

/**
 * @OA\Schema(
 *      schema="ListenerOfTheMonthResponse",
 *      @OA\Property(property="id", type="integer"),        
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="address", type="string"),
 *      @OA\Property(property="avatar", type="string"),
 *      @OA\Property(property="requests", type="string"),
 *      @OA\Property(property="favorite_show", type="string"),
 * )
 */
class ListenerOfTheMonthResponse{}

/**
 * @OA\Schema(
 *      schema="ListenerOfTheMonthRequest",
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="address", type="string"),
 *      @OA\Property(property="avatar", type="string"),
 *      @OA\Property(property="requests", type="string"),
 *      @OA\Property(property="favorite_show", type="string"),
 * )
 */
class ListenerOfTheMonthRequest{}