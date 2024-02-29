<?php

namespace App\Http\Controllers;

use App\Models\Posts;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * @OA\Tag(
 *      name="Postagens",
 *      description="Esta seção oferece acesso a operações relacionadas as publicações dos redatores no sistema da Rede Akiba.",
 * )
 */

class PostsController extends Controller
{
    //--------------Retorna todos as publicações------------
    /**
     * @OA\Get(
     *      path="/api/postagens",
     *      tags={"Postagens"},
     *      summary="Lista todas as postagens cadastradas",
     *      description="Este endpoint retorna todas as postagens cadastradas no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de postagens cadastradas",
     *          @OA\JsonContent(ref="#/components/schemas/PostResponse")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhuma postagem encontrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhuma postagem encontrada")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processmento")
     *          )
     *      )
     * )        
     */

    public function index()
    {
        try {
            $posts = Posts::with('author')->get();

            if ($posts->isEmpty()) {
                return response()->json(['message' => 'Nenhuma publicação encontrada'], 404);
            }

            return response()->json(['message' => 'Lista de publicações cadastradas', 'publicações' => $posts], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Cria uma nova publicação------------
    /**
     * @OA\Post(
     *      path="/api/postagens",
     *      tags={"Postagens"},
     *      summary="Cria uma nova postagem",
     *      description="Este endpoint cria uma nova postagem no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PostRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Postagem criada",
     *          @OA\JsonContent(ref="#/components/schemas/PostResponse")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Usuário não encontrado")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          )
     *      ),
     * ) 
     *          
     */
    public function store(Request $request)
    {
        try {
            $messages = [
                'author.required' => 'O campo author é obrigatório',
                'featured_image.required' => 'O campo featured_image é obrigatório',
                'image.required' => 'O campo image é obrigatório',
            ];

            $request->validate([
                'author' => 'required',
                'featured_image' => 'required|image',
                'image' => 'required|image'
            ], $messages);

            $author = Users::find($request->author);
            if (!$author) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            if ($request->hasFile('featured_image')) {
                $featured_image = $request->file('featured_image');
                $featured_image_filename = time() . '.' . $featured_image->getClientOriginalExtension();
                $location = public_path('images/' . $featured_image_filename);
                Image::make($featured_image)->save($location);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $image_filename = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $image_filename);
                Image::make($image)->save($location);
            }

            $posts = new Posts();
            $posts->slug = Str::slug($request->title);
            $posts->featured_image = $featured_image_filename;
            $posts->image = $image_filename;
            $posts->title = $request->title;
            $posts->content = $request->content;
            $posts->categories = $request->categories;
            $posts->search_fonts = $request->search_fonts;
            $posts->reactions = $request->reactions;
            $posts->save();

            //Associa a publicação ao usuário autor
            $author->posts()->save($posts);

            //Retorna a publicação criada com o usuário autor
            $posts->load('author');

            return response()->json(['message' => 'Publicação criada', 'publicação' => $posts], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->getMessage()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna uma publicação específica------------
    /**
     * @OA\Get(
     *      path="/api/postagens/{slug}",
     *      tags={"Postagens"},
     *      summary="Retorna uma postagem específica",
     *      description="Este endpoint retorna uma postagem específica cadastrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug da Postagem: Retorna uma publicação específica baseado no slug fornecido",
     *          required=true,  
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Postagem encontrada",
     *          @OA\JsonContent(ref="#/components/schemas/PostResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Publicação não encontrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Publicação não encontrada")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          )
     *      ),
     * )
     */
    public function show($slug)
    {
        try {
            $posts = Posts::with('slug')->where('slug', $slug)->first();

            if (!$posts) {
                return response()->json(['message' => 'Publicação não encontrada'], 404);
            }

            return response()->json(['message' => 'Publicação encontrada', 'publicação' => $posts], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza uma publicação específica------------
    /**
     * @OA\Patch(
     *      path="/api/postagens/{id}",
     *      tags={"Postagens"},
     *      summary="Atualiza uma postagem específica",
     *      description="Este endpoint atualiza uma postagem específica cadastrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID da Postagem: Atualiza uma publicação específica baseado no ID fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/PostRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Postagem atualizada",
     *          @OA\JsonContent(ref="#/components/schemas/PostResponse")
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Publicação não encontrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Publicação não encontrada"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          )
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        try {
            $posts = Posts::find($id);

            if (!$posts) {
                return response()->json(['error' => 'Publicação não encontrada'], 404);
            }

            if ($request->hasFile('featured_image')) {
                //Deleta a imagem antiga
                Storage::delete('public/images/' . $posts->featured_image);

                //Salva a nova imagem
                $featured_image = $request->file('featured_image');
                $featured_image_filename = time() . '.' . $featured_image->getClientOriginalExtension();
                $location = public_path('images/' . $featured_image_filename);
                Image::make($featured_image)->save($location);
                $posts->featured_image = $featured_image_filename;
            }

            if ($request->hasFile('image')) {
                //Deleta a imagem antiga
                Storage::delete('public/images/' . $posts->image);

                //Salva a nova imagem
                $image = $request->file('image');
                $image_filename = time() . '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $image_filename);
                Image::make($image)->save($location);
                $posts->image = $image_filename;
            }

            if ($request->author) {
                $author = Users::find($request->author);
                if ($author) {
                    $author->posts()->save($posts);
                } else {
                    return response()->json(['message' => 'Usuário não encontrado'], 404);
                }
            }

            if ($request->title) {
                $posts->slug = Str::slug($request->title);
                $posts->title = $request->title;
            }

            if ($request->content) {
                $posts->content = $request->content;
            }

            if ($request->categories) {
                $posts->categories = $request->categories;
            }

            if ($request->search_fonts) {
                $posts->search_fonts = $request->search_fonts;
            }

            if ($request->reactions) {
                $posts->reactions = $request->reactions;
            }

            $posts->save();

            //Retorna a publicação atualizada com o usuário autor
            $posts->load('author');

            return response()->json(['message' => 'Publicação atualizada', 'publicação' => $posts], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Deleta uma publicação específica------------
    /**
     * @OA\Delete(
     *      path="/api/postagens/{id}",
     *      tags={"Postagens"},
     *      summary="Deleta uma postagem específica",
     *      description="Este endpoint deleta uma postagem específica cadastrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="ID da Postagem: Deleta uma publicação específica baseado no ID fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response( 
     *          response=200,
     *          description="Postagem deletada",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Publicação deletada"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Publicação não encontrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Publicação não encontrada"),
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          )
     *      ),
     * )   
     */
    public function destroy($id)
    {
        try {
            $posts = Posts::find($id);

            if (!$posts) {
                return response()->json(['message' => 'Publicação não encontrada'], 404);
            }

            //Deleta a imagem da publicação
            Storage::delete('public/images/' . $posts->featured_image);
            Storage::delete('public/images/' . $posts->image);

            $posts->delete();

            return response()->json(['message' => 'Publicação deletada'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }
}
