<?php 

namespace App\Http\Schemas;

class TeamCalendarSchemas{}

/**
 * @OA\Schema(
 *      schema="TeamCalendarResponse",  
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="day", type="string"),
 *      @OA\Property(property="hour", type="string"),
 *      @OA\Property(property="category", type="string"),
 *      @OA\Property(property="responsible", type="object", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="content", type="string"),
 * )
 */
class TeamCalendarResponse{}

/**
 * @OA\Schema(
 *      schema="TeamCalendarRequest",
 *      type="object",
 *      @OA\Property(property="day", type="string"),
 *      @OA\Property(property="hour", type="string"),
 *      @OA\Property(property="category", type="string"),
 *      @OA\Property(property="responsible", type="integer"),
 *      @OA\Property(property="content", type="string"),
 * )
 */
class TeamCalendarRequest{}