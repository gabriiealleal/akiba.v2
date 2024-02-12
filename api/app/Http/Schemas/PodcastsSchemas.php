<?php

namespace App\Http\Schemas;

class PodcastsSchemas{}

/**
 * @OA\Schema(
 *      schema="PodcastResponse",      
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(property="author", type="object", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="season", type="integer"),
 *      @OA\Property(property="episode", type="integer"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="image", type="string"),
 *      @OA\Property(property="resume", type="string"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="player", type="string"),
 *      @OA\Property(property="aggregators", type="object",
 *          @OA\Property(property="spotify", type="string"),
 *          @OA\Property(property="apple_podcasts", type="string"),
 *          @OA\Property(property="google_podcasts", type="string"),
 *          @OA\Property(property="anchor", type="string"),
 *      ),
 * )
 */

class PodcastResponse{}

/**
 * @OA\Schema(
 *      schema="PodcastRequest",
 *      @OA\Property(property="author", type="integer"),
 *      @OA\Property(property="season", type="integer"),
 *      @OA\Property(property="episode", type="integer"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="image", type="string"),
 *      @OA\Property(property="resume", type="string"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="player", type="string"),
 *      @OA\Property(property="aggregators", type="object",
 *          @OA\Property(property="spotify", type="string"),
 *          @OA\Property(property="apple_podcasts", type="string"),
 *          @OA\Property(property="google_podcasts", type="string"),        
 *          @OA\Property(property="anchor", type="string")
 *      )
 * )
 */
class PodcastRequest{}
