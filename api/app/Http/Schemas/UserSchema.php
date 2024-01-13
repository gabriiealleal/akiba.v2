<?php

namespace App\Http\Schemas;

class UserSchema{}

/**
 * @OA\Schema(
 *      schema="UserResponse",
 *      type="object",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="slug", type="string"),
 *      @OA\Property(property="is_active", type="boolean", example="true"),
 *      @OA\Property(property="login", type="string"),
 *      @OA\Property(property="password", type="string"),
 *      @OA\Property(property="access_levels", type="json", example="['string', 'string']"),
 *      @OA\Property(property="avatar", type="string"),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="nickname", type="string"),
 *      @OA\Property(property="email", type="string"),
 *      @OA\Property(property="age", type="string"),
 *      @OA\Property(property="city", type="string"),
 *      @OA\Property(property="state", type="string"),
 *      @OA\Property(property="country", type="string"),
 *      @OA\Property(property="biography", type="string"),
 *      @OA\Property(
 *          property="social_networks",
 *          type="array",
 *          @OA\Items(
 *              type="object",
 *              @OA\Property(property="facebook", type="string", example="http://facebook.com/username"),
 *              @OA\Property(property="instagram", type="string", example="http://instagram.com/username"),
 *              @OA\Property(property="x", type="string", example="http://x.com/username"),
 *          ),
 *      ),
 *      @OA\Property(
 *          property="likes",
 *          type="object",
 *          @OA\Property(property="likes", type="array", @OA\Items(type="string"), example="['string', 'string']"),
 *          @OA\Property(property="dislikes", type="array", @OA\Items(type="string"), example="['string', 'string']"),
 *      ),
 * )
 */
class UserResponse{}

/**
 * @OA\Schema(
 *      schema="UserRequest",
 *      type="object",
 *      @OA\Property(property="login", type="string"),
 *      @OA\Property(property="password", type="string"),
 *      @OA\Property(property="access_levels", type="json", example="['string', 'string']"),
 *      @OA\Property(property="avatar", type="string"),
 *      @OA\Property(property="name", type="string"),
 *      @OA\Property(property="nickname", type="string"),
 *      @OA\Property(property="email", type="string"),
 *      @OA\Property(property="age", type="string"),
 *      @OA\Property(property="city", type="string"),
 *      @OA\Property(property="state", type="string"),
 *      @OA\Property(property="country", type="string"),
 *      @OA\Property(property="biography", type="string"),
 *      @OA\Property(
 *          property="social_networks",
 *          type="array",
 *          @OA\Items(
 *              type="object",
 *              @OA\Property(property="facebook", type="string", example="http://facebook.com/username"),
 *              @OA\Property(property="instagram", type="string", example="http://instagram.com/username"),
 *              @OA\Property(property="x", type="string", example="http://x.com/username"),
 *          ),
 *      ),
 *      @OA\Property(
 *          property="likes",
 *          type="object",
 *          @OA\Property(property="likes", type="array", @OA\Items(type="string"), example="['string', 'string']"),
 *          @OA\Property(property="dislikes", type="array", @OA\Items(type="string"), example="['string', 'string']"),
 *      ),
 * )
 */
class UserRequest{}
