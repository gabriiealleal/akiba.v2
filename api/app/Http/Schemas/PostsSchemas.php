<?php
namespace App\Http\Schemas; 

class PostsSchemas{}


/**
 * @OA\Schema(
 *      schema="PostResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(property="author", type="object", ref="#/components/schemas/UserResponse"),
 *      @OA\Property(property="featured_image", type="string"),
 *      @OA\Property(property="image", type="string"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="categories", type="array",
 *          @OA\Items(type="string"),
 *      ),
 *      @OA\Property(property="search_fonts", type="object", 
 *          @OA\Property(property="site1", type="string", example="https://www.site.com"),
 *          @OA\Property(property="site2", type="string", example="https://www.site.com"),
 *          @OA\Property(property="site3", type="string", example="https://www.site.com")
 *      ),
 *      @OA\Property(property="reactions", type="array",
 *          @OA\Items(type="string")
 *      )
 * )
 */
class PostResponse{}

/**
 * @OA\Schema(
 *      schema="PostRequest",
 *      type="object",
 *      @OA\Property(property="author", type="integer"),
 *      @OA\Property(property="featured_image", type="string"),
 *      @OA\Property(property="image", type="string"),
 *      @OA\Property(property="title", type="string"),
 *      @OA\Property(property="content", type="string"),
 *      @OA\Property(property="categories", type="array",
 *          @OA\Items(type="string")
 *      ),
 *      @OA\Property(property="search_fonts", type="object",
 *          @OA\Property(property="site1", type="string", example="https://www.site.com"),
 *          @OA\Property(property="site2", type="string", example="https://www.site.com"),
 *          @OA\Property(property="site3", type="string", example="https://www.site.com")
 *      ),
 *      @OA\Property(property="reactions", type="array",
 *          @OA\Items(type="string")
 *      )
 * )
 */
class PostRequest{}