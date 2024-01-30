<?php
namespace App\Http\Schemas;

class MusicsListSchemas{}

/**
 * @OA\Schema(
 *      schema="MusicsListResponse",
 *      type="object",
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(property="count", type="integer"),
 *      @OA\Property(property="music", type="string"),
 *      @OA\Property(property="artist", type="string"),
 *      @OA\Property(property="album", type="string"),    
 * ),   
 */

class MusicsListResponse{}

/**
 * @OA\Schema(
 *      schema="MusicsListRequest",
 *      type="object",
 *      @OA\Property(property="count", type="integer"),
 *      @OA\Property(property="music", type="string"),
 *      @OA\Property(property="artist", type="string"),
 *      @OA\Property(property="album", type="string"),    
 * ),   
 */

class MusicsListRequest{}