<?php 

namespace App\Http\Schemas;

class TasksSchemas{}

/**
 * @OA\Schema(
 *      schema="TasksResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="creator", type="object", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="responsible", type="object", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="finished", type="boolean"),
 * )
 */
class TasksResponse{}

/**
 * @OA\Schema(
 *      schema="TasksRequest",
 *      type="object",
 *      @OA\Property(property="creator", type="integer"),
 *      @OA\Property(property="responsible", type="integer"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="finished", type="boolean"),
 * )
 */
class TasksRequest{}
