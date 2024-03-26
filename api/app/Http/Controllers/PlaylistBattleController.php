<?php

namespace App\Http\Controllers;

use App\Models\PlaylistBattle;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *      name="Batalhas de Playlist",
 *      description="Esta seção oferece acesso a operações relacionadas aos banners das batalhas de playlists registradas no sistema da Rede Akiba."
 * )
 */

class PlaylistBattleController extends Controller
{

    //--------------Retorna uma batalha de playlist especifica------------
    /**
     * @OA\Get(
     *      path="/api/batalhas-de-playlist/{id}",
     *      tags={"Batalhas de Playlist"},
     *      summary="Retorna um banner da batalha de playlist especifica",
     *      description="Endpoint para retornar um banner da batalha de playlist especifica baseado no id fornecido.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID da Batalha de Playlist: Retorna um banner da batalha de playlist baseado no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Banner da batalha de playlist encontrada",
     *          @OA\JsonContent(ref="#/components/schemas/PlaylistBattleResponse")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Batalha de playlist não encontrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Batalha de playlist não encontrada.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento.")
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        try{
            $playlistBattle = PlaylistBattle::find($id);

            if(!$playlistBattle){
                return response()->json(['message' => 'Batalha de playlist não encontrada'], 404);
            }
    
            return response()->json(['message' => 'Batalha de playlist encontrada', 'data' => $playlistBattle], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento' . $e->getMessage()], 500);
        }
    }

    //--------------Atualiza uma batalha de playlist------------
    /**
     * @OA\Patch(
     *      path="/api/batalhas-de-playlist/{id}",
     *      tags={"Batalhas de Playlist"},
     *      summary="Atualiza um banner de batalha de playlist",
     *      description="Endpoint para atualizar um banner da batalha de playlist no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da batalha de Playlist: Atualiza um banner da batalha de playlist baseado no Id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PlaylistBattleRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="banner da batalha de playlist atualizada com sucesso.",
     *          @OA\JsonContent(ref="#/components/schemas/PlaylistBattleResponse")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Batalha de playlist não encontrada.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Banner da batalha de playlist não encontrada.")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento.")
     *          )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        try{
            $playlistBattle = PlaylistBattle::find($id);

            if(!$playlistBattle){
                return response()->json(['message' => 'Banner da batalha de playlist não encontrada'], 404);
            }

            if($request->has('image')){
                Storage::delete('images/' . $playlistBattle->image);

                $banner = $request->file('image');
                $banner_filename = time() . '.' . $banner->getClientOriginalExtension();
                $location = public_path('images/' . $banner_filename);
                Image::make($banner)->save($location);
                $playlistBattle->image = $banner_filename;
            }

            $playlistBattle->save();

            return response()->json(['message' => 'Banner da batalha de playlist atualizada com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento' . $e->getMessage()], 500);
        }
    }
}
