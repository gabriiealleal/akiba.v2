<?php

namespace App\Http\Controllers;

use App\Models\Youtube;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

/**
 * @OA\Tag(
 *      name="Vídeos do Youtube",
 *      description="Esta seção oferece acesso a operações relacionadas aos vídeos do Youtube no sistema da Rede Akiba."
 * )
 */
class YoutubeController extends Controller
{
    //--------------Retorna todos os vídeos do Youtube Cadastrados--------------
    /**
     * @OA\Get(
     *      path="/api/youtube",
     *      tags={"Vídeos do Youtube"},
     *      summary="Retorna uma lista de vídeos do Youtube",
     *      description="Retorna todos os vídeos do Youtube cadastrados no banco de dados.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de vídeos do Youtube encontrados com sucesso.",
     *          @OA\JsonContent(ref="#/components/schemas/YoutubeResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum vídeo do Youtube cadastrado.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum vídeo do Youtube cadastrado."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento."),
     *          ),
     *      ),
     * )
     *      
     */
    public function index()
    {
        try{
            $youtube = Youtube::all();

            if($youtube->isEmpty()){
                return response()->json(['message' => 'Nenhum vídeo do Youtube cadastrado.'], 404);
            }

            return response()->json(['message' => 'Lista dos vídeos do Youtube encontrados com sucesso.', 'vídeos' => $youtube], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento.', 'error' => $e->getMessage()], 500);
        }
    }


    //--------------Cadastra um novo vídeos do Youtube--------------
    /**
     * @OA\Post(
     *      path="/api/youtube",
     *      tags={"Vídeos do Youtube"},
     *      summary="Cadastra um novo vídeo do Youtube",
     *      description="Cadastra um novo vídeo do Youtube.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/YoutubeRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Vídeo do Youtube cadastrado com sucesso.",
     *          @OA\JsonContent(ref="#/components/schemas/YoutubeResponse"),    
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de validação.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento."),
     *          ),
     *      ),
     * )
     */
    public function store(Request $request)
    {
        try{
            $messages = [
                'video.required' => 'O campo "video" é obrigatório.',
            ];

            $request->validate([
                'video' => 'required'
            ], $messages);

            $youtube = new Youtube();
            $youtube->slug = Str::slug($request->title);
            $youtube->title = $request->title;
            $youtube->video = $request->video;
            $youtube->save();

            return response()->json(['message' => 'Vídeo do Youtube cadastrado com sucesso.', 'vídeo' => $youtube], 200);
        }catch (ValidationException $e) {
            return response()->json(['message' => 'Ocorreu um erro de validação', 'evento' => $e->errors()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento.', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna um novo vídeos do Youtube específico--------------
    /**
     * @OA\Get(
     *      path="/api/youtube/{slug}",
     *      tags={"Vídeos do Youtube"},
     *      summary="Retorna um vídeo do Youtube específico",
     *      description="Retorna um vídeo do Youtube específico de acordo com o slug informado.",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug do vídeo do Youtube: Retorna um vídeo do Youtube específico de acordo com o slug informado.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Vídeo do Youtube encontrado com sucesso.",     
     *          @OA\JsonContent(ref="#/components/schemas/YoutubeResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Vídeo do Youtube não encontrado.",     
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Vídeo do Youtube não encontrado."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento."),
     *          ),
     *      ),
     * )    
     */
    public function show($id)
    {
        try{
            $youtube = Youtube::find($id);

            if($youtube == null){
                return response()->json(['message' => 'Vídeo do Youtube não encontrado.'], 404);
            }

            return response()->json(['message' => 'Vídeo do Youtube encontrado com sucesso.', 'vídeo' => $youtube], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento.', 'error' => $e->getMessage()], 500);
        }
    }


    //--------------Atualiza um vídeo do Youtube específico------------
    /**
     * @OA\Patch(
     *      path="/api/youtube/{id}",
     *      tags={"Vídeos do Youtube"},
     *      summary="Atualiza um vídeo do Youtube específico",
     *      description="Atualiza um vídeo do Youtube específico de acordo com o id informado.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do vídeo do Youtube: Atualiza um vídeo do Youtube específico de acordo com o id informado.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/YoutubeRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Vídeo do Youtube atualizado com sucesso.",
     *          @OA\JsonContent(ref="#/components/schemas/YoutubeResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Vídeo do Youtube não encontrado.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Vídeo do Youtube não encontrado."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de validação.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento."),
     *          ),
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        try{
            $youtube = Youtube::find($id);

            if($youtube == null){
                return response()->json(['message' => 'Vídeo do Youtube não encontrado.'], 404);
            }

            if($request->has('title')){
                $youtube->title = $request->title;
            }

            if($request->has('video')){
                $youtube->video = $request->video;
            }

            $youtube->save();

            return response()->json(['message' => 'Vídeo do Youtube atualizado com sucesso.', 'vídeo' => $youtube], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento.', 'error' => $e->getMessage()], 400);
        }
    }

    //--------------Remove um vídeo do Youtube específico------------
    /**
     * @OA\Delete(
     *      path="/api/youtube/{id}",
     *      tags={"Vídeos do Youtube"},
     *      summary="Remove um vídeo do Youtube específico",
     *      description="Remove um vídeo do Youtube específico de acordo com o id informado.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do vídeo do Youtube: Retorna um vídeo do Youtube específico de acordo com o id informado.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Vídeo do Youtube removido com sucesso.",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Vídeo do Youtube removido com sucesso."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Vídeo do Youtube não encontrado.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Vídeo do Youtube não encontrado."),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento.",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento."),
     *          ),
     *      ),
     * )   
     */
    public function destroy($id)
    {
        try{
            $youtube = Youtube::find($id);

            if($youtube == null){
                return response()->json(['message' => 'Vídeo do Youtube não encontrado.'], 404);
            }

            $youtube->delete();

            return response()->json(['message' => 'Vídeo do Youtube removido com sucesso.'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento.', 'error' => $e->getMessage()], 400);
        }
    }
}
