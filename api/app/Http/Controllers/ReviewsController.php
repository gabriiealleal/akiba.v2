<?php

namespace App\Http\Controllers;

use App\Models\Reviews;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * @OA\Tag(
 *      name="Reviews",
 *      description="Esta seção oferece acesso a operações relacionadas aos reviews no sistema da Rede Akiba"
 * )
 */

class ReviewsController extends Controller
{
    //--------------Lista todos os reviews--------------
    /**
     * @OA\Get(
     *      path="/reviews",
     *      tags={"Reviews"},
     *      summary="Lista todos os reviews cadastrados",
     *      description="Este endpoint retorna uma lista completa de todos os reviews cadastrados no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de todos os reviews cadastrados",
     *          @OA\JsonContent(ref="#/components/schemas/ReviewResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum review encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum review encontrado"),
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
     * 
     */
    public function index()
    {
        try{
            $reviews = Reviews::with('author')->get();

            if($reviews->isEmpty()){
                return response()->json(['message' => 'Nenhum review encontrado'], 404);
            }

            return response()->json(['message' => 'Lista todos os reviews cadastrados', 'reviews' => $reviews], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Erro ao listar reviews', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Cria uma novo review------------
    /**
     * @OA\Post(
     *      path="/reviews",
     *      tags={"Reviews"},
     *      summary="Cria um novo review",
     *      description="Este endpoint realiza a criação de um novo review no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ReviewRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Review criado",
     *          @OA\JsonContent(ref="#/components/schemas/ReviewResponse"),
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
     *     
     */
    public function store(Request $request)
    {
        try {
            $messages = [
                'author.required' => 'O campo author é obrigatório',
                'image.required' => 'O campo image é obrigatório',
            ];

            $request->validate([
                'author' => 'required',
                'image' => 'required|image'
            ], $messages);

            $author = Users::find($request->author);
            if (!$author) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('image/' . $name);
                Image::make($image)->save($location);
            }

            $reviews = new Reviews();
            $reviews->slug = Str::slug($request->title);
            $reviews->title = $request->title;
            $reviews->image = $name;
            $reviews->content = $request->content;
            $reviews->reviews = $request->reviews;
            $reviews->save();

            //Associa o review ao usuário autor
            $author->reviews()->save($reviews);

            //Retorna o review criado com o usuário autor
            $reviews->load('author');

            return response()->json(['message' => 'Review criado', 'review' => $reviews], 200);
        }catch(ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna um review especifico------------
    /**
     * @OA\Get(
     *      path="/reviews/{slug}",
     *      tags={"Reviews"},
     *      summary="Retorna um review especifico",
     *      description="Este endpoint retorna um review especifico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug do Review: Retorna um review especifico baseado no slug fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Review encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/ReviewResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Review não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Review não encontrado"),
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
            $reviews = Reviews::with('slug')->where('slug', $slug)->first();

            if(!$reviews){
                return response()->json(['message' => 'Review não encontrado'], 404);
            }

            return response()->json(['message' => 'Review encontrado', 'review' => $reviews], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza um review especifico------------
    /**
     * @OA\Patch(
     *      path="/reviews/{id}",
     *      tags={"Reviews"},
     *      summary="Atualiza um review especifico",
     *      description="Este endpoint realiza a atualização de um review especifico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID do Review: Atualiza um review especifico baseado no ID fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ReviewRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Review atualizado",
     *          @OA\JsonContent(ref="#/components/schemas/ReviewResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Review não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Review não encontrado"),
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
            $reviews = Reviews::find($id);

            if(!$reviews){
                return response()->json(['message' => 'Review não encontrado'], 404);
            }

            if($request->hasFile('image')){
                //Deleta a imagem antiga
                Storage::delete('public/image/' . $reviews->image);

                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('image/' . $name);
                Image::make($image)->save($location);
                $reviews->image = $name;
            }

            if($request->has('title')){
                $reviews->title = $request->title;
                $reviews->slug = Str::slug($request->title);
            }

            if($request->has('author')){
                $author = Users::find($request->author);
                if(!$author){
                    return response()->json(['message' => 'Usuário não encontrado'], 404);
                }
                $reviews->author = $request->author;
            }

            if($request->has('content')){
                $reviews->content = $request->content;
            }

            if($request->has('content')){
                $reviews->reviews = $request->reviews;
            }

            $reviews->save();

            //Retorna o review com os dados do usuario autor
            $reviews->load('author');

            return response()->json(['message' => 'Review atualizado', 'review' => $reviews], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Remove um review------------
    /**
     * @OA\Delete(
     *      path="/reviews/{id}",
     *      tags={"Reviews"},
     *      summary="Remove um review",
     *      description="Este endpoint realiza a remoção de um review especifico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID do Review: Remove um review especifico baseado no ID fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Review removido",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Review removido"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Review não encontrado",        
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Review não encontrado"),
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
            $reviews = Reviews::find($id);

            if(!$reviews){
                return response()->json(['message' => 'Review não encontrado'], 404);
            }

            //Deleta a imagem do review
            Storage::delete('public/image/' . $reviews->image);

            $reviews->delete();

            return response()->json(['message' => 'Review removido'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }
}
