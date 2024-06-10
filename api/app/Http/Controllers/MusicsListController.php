<?php

namespace App\Http\Controllers;

use App\Models\MusicsList;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *      name="Músicas",
 *      description="Esta seção oferece acesso a operações relacionadas a musicas registradas no sistema da Rede Akiba."
 * )
*/

class MusicsListController extends Controller
{
    //---------Lista todos as músicas------------
    /**
     * @OA\Get(
     *      path="/api/musicas",
     *      tags={"Músicas"},
     *      summary="Lista todas as músicas",      
     *      description="Este endpoint retorna todas as músicas registradas no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de músicas",
     *          @OA\JsonContent(
     *              type="array",
     *              @OA\Items(ref="#/components/schemas/MusicsListResponse"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhuma música encontrada",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="error", type="string", example="Nenhuma música encontrada"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string"),
     *              @OA\Property(property="error", type="object"),
     *          ),
     *      ),
     * )    
     */
    public function index()
    {
        try{
            $musics = MusicsList::all();

            if($musics->isEmpty()){
                return response()->json(['error' => 'Nenhuma música encontrada'], 404);
            }

            return response()->json($musics, 200);

        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e], 500);
        }
    }

    //---------Cadastra uma nova música------------
    /**
     * @OA\Post(
     *      path="/api/musicas",
     *      tags={"Músicas"},
     *      summary="Cadastra uma nova música",
     *      description="Este endpoint cadastra uma nova música no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/MusicsListRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Música cadastrada com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/MusicsListResponse"),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * ),
     */
    public function store(Request $request)
    {
        try{
            $music = new MusicsList();
            $music->slug = Str::slug($request->music);
            $music->count = $request->count;
            $music->music = $request->music;
            $music->artist = $request->artist;
            $music->album = $request->album;
            $music->save();
            return response()->json(['message' => 'Música cadastrada com sucesso', 'música'=>$music], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e], 500);
        }
    }

    //---------Retorna uma música especifica------------
    /**
     * @OA\Get(
     *      path="/api/musicas/{slug}",
     *      tags={"Músicas"},
     *      summary="Retorna uma música especifica",
     *      description="Este endpoint retorna uma música especifica registrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug da Música: Retorna uma música especifica baseada no slug fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Música encontrada",
     *          @OA\JsonContent(ref="#/components/schemas/MusicsListResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Música não encontrada",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Música não encontrada"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              type="object",      
     *              @OA\Property(property="message", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * ),
     */
    public function show($slug)
    {
        try{
            $music = MusicsList::with('slug')->where('slug', $slug)->first();

            if($music) {
                return response()->json(['message' => 'Música não encontrada'], 404);
            }

            return response()->json($music, 200);
        } catch(\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e], 400);
        }
    }

    //---------Atualiza uma música especifica------------
    /**
     * @OA\Patch(
     *      path="/api/musicas/{id}",
     *      tags={"Músicas"},
     *      summary="Atualiza uma música especifica",
     *      description="Este endpoint atualiza uma música especifica registrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Música: Retorna uma música especifica baseada no Id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/MusicsListRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Música atualizada com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/MusicsListResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Música não encontrada",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Música não encontrada"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Ocorreu um erro de processamento"),
     *          ),      
     *      ),
     *      security={{"BearerAuth": {}}},
     * ),
     */
    public function update(Request $request, $id)
    {
        try{
            $music = MusicsList::find($id);

            if($music) {
                return response()->json(['message' => 'Música não encontrada'], 404);
            }

            if($request->has('count')) {
                $music->count = $request->count;
            }

            if($request->has('music')) {
                $music->music = $request->music;
            }

            if($request->has('artist')) {
                $music->artist = $request->artist;
            }

            if($request->has('album')) {
                $music->album = $request->album;
            }

            $music->save();
            return response()->json(['message' => 'Música atualizada', 'música' => $music], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e], 400);
        }
    }

    //---------Remove uma música especifica------------
    /**
     * @OA\Delete(
     *      path="/api/musicas/{id}",
     *      tags={"Músicas"},
     *      summary="Remove uma música especifica",
     *      description="Este endpoint remove uma música especifica registrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Música: Remove uma música especifica baseada no Id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Música removida com sucesso",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Música removida com sucesso"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Música não encontrada",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Música não encontrada"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="message", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     *      security={{"BearerAuth": {}}},
     * ),
     */
    public function destroy($id)
    {
        try{
            $music = MusicsList::find($id);

            if($music) {
                return response()->json(['message' => 'Música não encontrada'], 404);
            }

            $music->delete();
            return response()->json(['message' => 'Música removida com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e], 400);
        }
    }
}
