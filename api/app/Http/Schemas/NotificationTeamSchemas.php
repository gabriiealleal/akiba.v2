<?php 

namespace App\Http\Schemas;

class NotificationTeamSchemas{}

/**
 * @OA\Schema(
 *      schema="NotificationTeamResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="creator", type="object", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="addressee", type="object", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="content", type="string"),
 * )
 */
class NotificationTeamResponse{}

/**
 * @OA\Schema(
 *      schema="NotificationTeamRequest",
 *      type="object",
 *      @OA\Property(property="creator", type="integer"),
 *      @OA\Property(property="addressee", type="integer"),
 *      @OA\Property(property="content", type="string"),
 * )
 */
class NotificationTeamRequest{}
