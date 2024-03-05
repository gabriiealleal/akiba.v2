<?php 

namespace App\Http\Schemas;

class TasksSchema{}

/**
 * @OA\Schema(
 *      schema="TasksResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="responsible", type="object", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="status", type="string"),
 * )
 */
class TasksResponse{}

/**
 * @OA\Schema(
 *      schema="TasksRequest",
 *      type="object",
 *      @OA\Property(property="responsible", type="integer"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="status", type="string"),
 * )
 */
class TasksRequest{}
