<?php 

namespace App\Http\Schemas;

class PlaylistBattleSchemas{}

/**
 * @OA\Schema(
 *      schema="PlaylistBattleRequest",
 *      @OA\Property(property="image", type="string"),
 * )
 */
class PlaylistBattleRequest{}

/**
 * @OA\Schema(
 *      schema="PlaylistBattleResponse",
 *      @OA\Property(property="id", type="integer"),
 *      @OA\Property(property="image", type="string"),
 * )
 */
class PlaylistBattleResponse{}