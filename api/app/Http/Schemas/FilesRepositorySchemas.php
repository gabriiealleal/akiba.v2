<?php

namespace App\Http\Schemas;

class FilesRepositorySchemas{}

/**
 * @OA\Schema(
 *      schema="FilesRepositoryResponse",      
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="category", type="string"),
 *      @OA\Property(property="icon", type="string"),
 *      @OA\Property(property="url", type="string"),
 * )
 */
class FilesRepositoryResponse{}

/**
 * @OA\Schema(
 *      schema="FilesRepositoryRequest",
 *      @OA\Property(property="category", type="string"),
 *      @OA\Property(property="icon", type="string"),
 *      @OA\Property(property="url", type="string"),
 * )
 */
class FilesRepositoryRequest{}