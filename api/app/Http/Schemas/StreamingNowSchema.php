<?php 
namespace App\Http\Schemas;


class StreamingNowSchema{}

/**
 * @OA\Schema(
 *      schema="StreamingNowResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(property="show", type="object", ref="#/components/schemas/ShowResponse"),
 *      @OA\Property(property="type", type="string"),
 *      @OA\Property(property="date_streaming", type="string"),
 *      @OA\Property(property="start_streaming", type="string"),
 *      @OA\Property(property="end_streaming", type="string"),
 * ),
 */

 class StreamingNowResponse{}
 

/**
 * @OA\Schema(
 *      schema="StreamingNowRequest",
 *      type="object",
 *      @OA\Property(property="show", type="integer"),
 *      @OA\Property(property="type", type="string"),
 *      @OA\Property(property="date_streaming", type="string"),
 *      @OA\Property(property="start_streaming", type="string"),
 *      @OA\Property(property="end_streaming", type="string"),
 * ),
 */
 class SteamingNowRequest{}