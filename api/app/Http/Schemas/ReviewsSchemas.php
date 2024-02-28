<?php 

namespace App\Http\Schemas;

class ReviewsSchemas{}

/**
 * @OA\Schema(
 *      schema="ReviewResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(property="author", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="image", type="string"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="reviews", type="array",
 *          @OA\Items(type="object",
 *              @OA\Property(property="usuario1", type="string", example="texto"),
 *              @OA\Property(property="usuario2", type="string", example="texto"),
 *          ),
 *      ),
 * )
 */
class ReviewResponse{}

/**
 * @OA\Schema(
 *      schema="ReviewRequest",
 *      type="object",
 *      @OA\Property(property="author", type="integer"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="image", type="string"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="reviews", type="array",
 *          @OA\Items(type="object",
 *              @OA\Property(property="usuario01", type="string", example="texto"),
 *              @OA\Property(property="usuario02", type="string", example="texto"),
 *          ),
 *      ),
 * )
 */
class ReviewRequest{}