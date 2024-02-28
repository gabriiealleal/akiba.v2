<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Podcasts;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; 

/**
 * @OA\Tag(
 *      name="Podcasts",
 *      description="Esta seção oferece acesso a operações relacionadas aos podcasts no sistema da Rede Akiba.",
 * )
*/

class PodcastsController extends Controller
{
    //--------------Retorna todos os podcasts--------------
    /**
     * @OA\Get(
     *      path="/podcasts",
     *      tags={"Podcasts"},
     *      summary="Retorna uma lista de todos os podcasts cadastrados",
     *      description="Retorna uma lista de todos os podcasts cadastrados no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de todos os podcasts cadastrados",
     *          @OA\JsonContent(ref="#/components/schemas/PodcastResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum podcast encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum podcast encontrado"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento", 
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          )
     *      )
     * )
     */
    public function index()
    {
        try{
            $podcasts = Podcasts::with('author')->get();
            
            if($podcasts->isEmpty()){
                return response()->json(['message' => 'Nenhum podcast encontrado'], 404);
            }

            return response()->json(['message' => 'Lista de todos os podcasts cadastrados', 'podcasts'=> $podcasts], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    //--------------Cadastra um novo podcast--------------
    /**
     * @OA\Post(
     *      path="/podcasts",
     *      tags={"Podcasts"},
     *      description="Cadastra um novo podcast no sistema da Rede Akiba",
     *      summary="Cadastra um novo podcast",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PodcastRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Podcast cadastrado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/PodcastResponse"),
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Erro de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Erro de validação"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Autor não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Autor não encontrado"),          
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * )    
     */
    public function store(Request $request)
    {
        try{
            $messages = [
                'author.required' => 'O campo author é obrigatório',
                'image.required' => 'O campo image é obrigatório',
            ];

            $validator = $request->validate([
                'author' => 'required',
                'image' => 'required|image'
            ], $messages);

            $author = Users::find($request->author);
            if(!$author){
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('images/'.$filename); // Corrija a barra aqui
                Image::make($image)->save($location);
            }

            $podcasts = new Podcasts();
            $podcasts->slug = Str::slug($request->title);
            $podcasts->season = $request->season;
            $podcasts->episode = $request->episode;
            $podcasts->title = $request->title;
            $podcasts->image = $filename ?? null; // Corrija aqui, pode ser null se não houver imagem
            $podcasts->resume = $request->resume;
            $podcasts->content = $request->content;
            $podcasts->player = $request->player;
            $podcasts->aggregators = $request->aggregators;
            $podcasts->save();

            //Associa o usuário ao podcast
            $author->podcasts()->save($podcasts);

            //Retorna o podcast com os dados do usuário autor associado
            $podcasts->load('author'); // Corrija aqui para $podcasts

            return response()->json(['message' => 'Podcast cadastrado com sucesso', 'podcast' => $podcasts], 200);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['error' => 'Erro de validação', 'message' => $e->getMessage()], 422);  
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna um podcast especifico--------------
    /**
     * @OA\Get(
     *      path="/podcasts/{slug}",
     *      tags={"Podcasts"},
     *      summary="Retorna um podcast específico",
     *      description="Retorna um podcast específico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug do Podcast: Retorna um podcast baseado no slug fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Podcast encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/PodcastResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Podcast não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Podcast não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * )
     */
    public function show($slug)
    {
        try{
            $podcasts = Podcasts::with('slug')->where('slug', $slug)->first(); // Corrija para where('id', $id)

            if(!$podcasts){
                return response()->json(['message' => 'Podcast não encontrado'], 404);
            }

            return response()->json(['message' => 'Podcast encontrado', 'podcast'=> $podcasts], 200);            
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }     
    }

    //--------------Atualiza um podcast especifico--------------
    /**
     * @OA\Patch(
     *      path="/podcasts/{id}",
     *      tags={"Podcasts"},
     *      summary="Atualiza um podcast específico",
     *      description="Atualiza um podcast específico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Podcast: Atualiza um podcast baseado no ID fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"  
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PodcastRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Podcast atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/PodcastResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Podcast ou autor não encontrado",   
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Podcast ou autor não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * )         
     */
    public function update(Request $request, $id)
    {
        try{
            $podcasts = Podcasts::find($id);

            if(!$podcasts){
                return response()->json(['message' => 'Podcast não encontrado'], 404);
            }

            if($request->has('slug')){
                $podcasts->slug = Str::slug($request->slug);
            }

            if($request -> has('author')){
                $author = Users::find($request->author);
                if($author){
                    $author->podcasts()->save($podcasts);
                }else{
                    return response()->json(['message' => 'Autor não encontrado'], 404);
                }
            }

            if($request->has('season')){
                $podcasts->season = $request->season;
            }

            if($request->has('episode')){
                $podcasts->episode = $request->episode;
            }

            if($request->has('title')){
                $podcasts->slug = Str::slug($request->title);
                $podcasts->title = $request->title;
            }
            
            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('/images/'.$filename); // Corrija a barra aqui
                Image::make($image)->save($location);
            }

            if($request->has('resume')){
                $podcasts->resume = $request->resume;
            }

            if($request->has('content')){
                $podcasts->content = $request->content;
            }

            if($request->has('player')){
                $podcasts->player = $request->player;
            }

            if($request->has('aggregators')){
                $podcasts->aggregators = $request->aggregators;
            }

            //Retorna o podcast com os dados do usuário autor associado
            $podcasts->load('author');

            //Salva as alterações 
            $podcasts->save();

            return response()->json(['message' => 'Podcast atualizado com sucesso', 'podcast' => $podcasts], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    //--------------Remove um podcast especifico--------------
    /**
     * @OA\Delete(
     *      path="/podcasts/{id}",
     *      tags={"Podcasts"},
     *      summary="Remove um podcast específico",
     *      description="Remove um podcast específico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Podcast: Remove um podcast baseado no ID fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Podcast removido com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Podcast removido com sucesso"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Podcast não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Podcast não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * )
     */
    public function destroy($id)
    {
        try{
            $podcasts = Podcasts::find($id);

            if(!$podcasts){
                return response()->json(['message' => 'Podcast não encontrado'], 404);
            }

            //Deleta a imagem do podcast
            Storage::delete('public/images/'.$podcasts->image);

            $podcasts->delete();

            return response()->json(['message' => 'Podcast removido com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }
}
