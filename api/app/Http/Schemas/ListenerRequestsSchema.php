<?php
namespace App\Http\Schemas; 

class ListenerRequestsSchema{}

/**
 * @OA\Schema(
 *      schema="ListenerRequestResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="listener", type="string"),
 *      @OA\Property(property="address", type="string"),
 *      @OA\Property(property="message", type="string"),
 *      @OA\Property(
 *          property="streaming",
 *          type="object",
 *          ref="#/components/schemas/StreamingNowResponse"
 *      ),
 *      @OA\Property(
 *          property="music",
 *          type="object",
 *          ref="#/components/schemas/MusicsListResponse"
 *      ),
 * )
 */

class ListenerRequestResponse{}

/**
 * @OA\Schema(
 *      schema="ListenerRequestRequest",
 *      type="object",
 *      @OA\Property(property="listener", type="string"),
 *      @OA\Property(property="address", type="string"),
 *      @OA\Property(property="message", type="string"),
 *      @OA\Property(property="streaming_now", type="integer"),
 *      @OA\Property(property="music", type="integer"),
 * )
 */
class ListenerRequestRequest{}