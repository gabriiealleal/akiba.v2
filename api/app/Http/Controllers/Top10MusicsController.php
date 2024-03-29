<?php

namespace App\Http\Controllers;

use App\Models\Top10Musics;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * @OA\Tag(
 *      name="Top 10 de Músicas",
 *      description="Esta seção oferece acesso a operações relacionadas ao top 10 de músicas no sistema da Rede Akiba."
 * ),
 */

class Top10MusicsController extends Controller
{
    //--------------Atualiza uma posição no top 10 de músicas--------------
    /**
     * @OA\Patch(
     *      path="/api/top-musicas/{id}",
     *      operationId="updateTop10Musics",
     *      tags={"Top 10 de Músicas"},
     *      summary="Atualiza uma posição no top 10 de músicas",
     *      description="Este endpoint atualzia uma posição no top 10 de músicas no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Posição no Top 10 de Músicas: Atualiza uma posição no top 10 de músicas baseado no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/Top10MusicsRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Top 10 de músicas atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/Top10MusicsResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Posição do top 10 de músicas não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Posição do top 10 de músicas não encontrado")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          ),
     *      ),
     *      security={{"BearerAuth": {}}},
     * )
     */
    public function update(Request $request, $id)
    {
        try{
            $topMusics = Top10Musics::find($id);

            if(!$topMusics){
                return response()->json(['message' => 'Posição do top 10 de músicas não encontrado'], 404);
            }

            if($request->has('avatar')){
                Storage::delete('images/' . $topMusics->avatar);

                $avatar = $request->file('avatar');
                $avatar_filename = time() . '.' . $avatar->getClientOriginalExtension();
                $location = public_path('images/' . $avatar_filename);
                Image::make($avatar)->save($location);
                $topMusics->avatar = $avatar_filename;
            }

            $topMusics->save();

            return response()->json(['message' => 'Top 10 de músicas com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento' . $e->getMessage()], 500);
        }
    }
}
