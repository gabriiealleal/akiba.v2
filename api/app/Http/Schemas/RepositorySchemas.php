<?php

namespace App\Http\Schemas;

class RepositorySchemas{}

/**
 * @OA\Schema(
 *      schema="RepositoryResponse",      
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="category", type="string"),
 *      @OA\Property(property="icon", type="string"),
 *      @OA\Property(property="url", type="string"),
 * )
 */
class RepositoryResponse{}

/**
 * @OA\Schema(
 *      schema="RepositoryRequest",
 *      @OA\Property(property="category", type="string"),
 *      @OA\Property(property="icon", type="string"),
 *      @OA\Property(property="url", type="string"),
 * )
 */
class RepositoryRequest{}