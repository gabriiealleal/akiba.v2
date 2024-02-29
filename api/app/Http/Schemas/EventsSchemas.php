<?php 
namespace App\Http\Schemas; 

class EventsSchemas{}

/**
 * @OA\Schema(
 *      schema="EventsResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(property="author", type="string"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="image", type="string"),
 *      @OA\Property(property="dates", type="string"),
 *      @OA\Property(property="location", type="string"),
 *      @OA\Property(property="content", type="string"),
 * )
 */
class EventsResponse{}

/**
 * @OA\Schema(
 *      schema="EventsRequest",
 *      type="object",
 *      @OA\Property(property="author", type="integer"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="image", type="string"),
 *      @OA\Property(property="dates", type="string"),
 *      @OA\Property(property="location", type="string"),
 *      @OA\Property(property="content", type="string"),
 * )
 */
class EventsRequest{}