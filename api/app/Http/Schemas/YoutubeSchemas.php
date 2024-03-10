<?php

namespace App\Http\Schemas;

class YoutubeSchemas{}

/**
 * @OA\Schema(
 *      schema="YoutubeResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="video", type="string"),
 * )
 */
class YoutubeResponse{}

/**
 * @OA\Schema(
 *      schema="YoutubeRequest",
 *      type="object",
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="video", type="string"),
 * )
 */
class YoutubeRequest{}