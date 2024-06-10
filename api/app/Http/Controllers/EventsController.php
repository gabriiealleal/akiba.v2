<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * @OA\Tag(
 *      name="Eventos",
 *      description="Esta seção oferece acesso a operações relacionadas aos eventos no sistema da Rede Akiba.",
 * )
 */

class EventsController extends Controller
{
    //--------------Lista todos os eventos--------------
    /**
     * @OA\Get(
     *      path="/api/eventos",
     *      tags={"Eventos"},
     *      summary="Lista todos os eventos cadastrados",
     *      description="Este endpoint retorna todas os cadastrados no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de todos os eventos cadastrados",
     *          @OA\JsonContent(ref="#/components/schemas/EventsResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum evento encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum evento encontrado"),
     *          )
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
    public function index()
    {
        try{
            $events = Events::with('author')->get();

            if($events->isEmpty()){
                return response()->json(['message' => 'Nenhum evento encontrado'], 404);
            }

            return response()->json(['message', 'Lista de todos os eventos cadastrados', 'eventos' => $events], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Cadastra um novo evento--------------
    /**
     * @OA\Post(
     *      path="/api/eventos",
     *      tags={"Eventos"},
     *      summary="Cadastra um novo evento",
     *      description="Este endpoint realiza o cadastro de um novo evento no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EventsRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Evento cadastrado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/EventsResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Usuário não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação"),  
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     *      security={{"BearerAuth": {}}},
     * )
     */
    public function store(Request $request)
    {
        try{
            $messages = [
                'author.required' => 'O campo autor é obrigatório',
                'image.required' => 'O campo imagem é obrigatório',
            ];

            $request->validate([
                'author' => 'required',
                'image' => 'required',
                'dates' => 'required',
                'location' => 'required',
                'content' => 'required'
            ], $messages);

            $author = Users::find($request->author);
            if(!$author){
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('/images' . $name);
                Image::make($image)->save($location);
            }

            $events = new Events();
            $events->slug = Str::slug($request->title);
            $events->author = $request->author;
            $events->title = $request->title;
            $events->image = $name;
            $events->dates = $request->dates;
            $events->location = $request->location;
            $events->content = $request->content;
            $events->save();

            //Associando o evento com o usuário autor
            $author->events()->save($events);

            //Retorna o evento criado com o usuario autor
            $events->load('author');

            return response()->json(['message' => 'Evento cadastrado com sucesso', 'evento' => $events], 200);
        }catch(ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->getMessage()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna uma evento específico------------
    /**
     * @OA\Get(
     *      path="/api/eventos/{slug}",
     *      tags={"Eventos"},
     *      summary="Retorna um evento específico",
     *      description="Este endpoint retorna um evento específico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug do Evento: Retorna um evento específico baseado no slug fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),  
     *      @OA\Response(
     *          response=200,
     *          description="Evento encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/EventsResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Evento não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Evento não encontrado"),
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
            $events = Events::with('slug')->where('slug', $slug)->first();

            if(!$events){
                return response()->json(['message' => 'Evento não encontrado'], 404);
            }

            return response()->json(['message' => 'Evento encontrado', 'evento' => $events], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza um evento especifico------------
    /**
     * @OA\Patch(
     *      path="/api/eventos/{id}",
     *      tags={"Eventos"},
     *      summary="Atualiza um evento específico",
     *      description="Este endpoint atualiza um evento específico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Evento: Atualiza um evento específico baseado no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/EventsRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Evento atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/EventsResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Evento não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Evento não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     *      security={{"BearerAuth": {}}},
     * )    
     */
    public function update(Request $request, $id)
    {
        try{
            $events = Events::find($id);

            if(!$events){
                return response()->json(['message' => 'Evento não encontrado'], 404);
            }

            if($request->hasFile('image')){
                //Deleta a imagem antiga
                Storage::delete('public/images/' . $events->image);

                //Salva a nova imagem
                $image = $request->file('image');
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($image)->save($location);
                $events->image = $filename;
            }

            if($request->author){
                $author = Users::find($request->author);
                if($author){
                    $author->events()->save($events);
                }else{
                    return response()->json(['message' => 'Usuário não encontrado'], 404);
                }
            }

            if($request->title){
                $events->slug = Str::slug($request->title);
                $events->title = $request->title;
            }

            if($request->dates){
                $events->dates = $request->dates;
            }

            if($request->location){
                $events->location = $request->location;
            }

            if($request->content){
                $events->content = $request->content;
            }

            $events->save();

            //Retorna o evento atualizado com o usuário autor
            $events->load('author');

            return response()->json(['message' => 'Evento atualizado com sucesso', 'evento' => $events], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Deleta uma evento especifico------------
    /**
     * @OA\Delete(
     *      path="/api/eventos/{id}",
     *      tags={"Eventos"},
     *      summary="Remove um evento específico",
     *      description="Este endpoint remove um evento específico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Evento: Remove um evento específico baseado no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Evento deletado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Evento deletado com sucesso"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Evento não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Evento não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     *      security={{"BearerAuth": {}}},
     * )
     */
    public function destroy($id)
    {
        try{
            $events = Events::find($id);

            if(!$events){
                return response()->json(['message' => 'Evento não encontrado'], 404);
            }

            //Deleta a imagem
            Storage::delete('public/images/' . $events->image);

            $events->delete();

            return response()->json(['message' => 'Evento deletado com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }
}
