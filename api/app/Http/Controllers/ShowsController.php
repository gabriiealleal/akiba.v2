<?php

namespace App\Http\Controllers;

use App\Models\Shows;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

/**
 * @OA\Tag(
 *      name="Programas",
 *      description="Esta seção oferece acesso a operações relacionadas aos programas dos locutores no sistema da Rede Akiba."
 * )
 */

class ShowsController extends Controller
{
    //--------------Retorna todos os programas------------

    /**
     * @OA\Get(
     *      path="/api/programas",
     *      tags={"Programas"},
     *      description="Este endpoint retorna uma lista completa de todos os programas cadastrados no sistema da Rede Akiba.",
     *      summary="Retorna todos os programas cadastrados",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de programas cadastrados",
     *          @OA\JsonContent(ref="#/components/schemas/ShowResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum programa encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum programa encontrado")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          ),
     *      ),
     * )        
     */

    public function index()
    {
        try{
            $shows = Shows::with('presenter')->get();
            if($shows->isEmpty()){
                return response()->json(['error' => 'Nenhum programa encontrado'], 404);
            }
            return response()->json(['message' => 'Lista de programas cadastrados', 'programas' => $shows], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    //--------------Cadastra um programa------------

    /**
     * @OA\Post(
     *      path="/api/programas",
     *      tags={"Programas"},
     *      description="Este endpoint realiza o cadastro de um novo programa no sistema da Rede Akiba.",
     *      summary="Cadastra um novo programa",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ShowRequest"),
     *      ),
     *      @OA\Response(   
     *          response=200,
     *          description="Programa cadastrado",
     *          @OA\JsonContent(ref="#/components/schemas/ShowResponse"),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um problema de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de validação"),
     *             @OA\Property(property="message", type="object", example={"presenter": {"O campo apresentador é obrigatório.", "Este apresentador não existe."}, "name": {"O campo name é obrigatório."}, "logo": {"O campo logo é obrigatório."}}),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um problema de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de processamento")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum apresentador encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum apresentador encontrado")
     *          ),
     *      ),
     * )
     */
    public function store(Request $request)
    {
        try{
            $messages = [
                'presenter.required' => 'O campo apresentador é obrigatório.',
                'presenter.exists' => 'O apresentador não existe.',
                'name.required' => 'O campo name é obrigatório.',
                'name.unique' => 'O nome do programa já está em uso.',
                'logo.required' => 'O campo logo é obrigatório.',
                'logo.image' => 'O campo logo deve ser uma imagem.',
                'logo.file' => 'O logo deve ser um arquivo.',
            ];

            $request->validate([
                'presenter' => 'required|exists:users,id',
                'name' => 'required|unique:shows',
                'logo' => 'required|file|image',
            ], $messages);

            $presenter = Users::find($request->presenter);
            if(!$presenter){
                return response()->json(['error' => 'Nenhum apresentador encontrado'], 404);
            }
            
            if($request->hasFile('logo')){
                $logo = $request->file('logo');
                $filename = time().'.'.$logo -> getClientOriginalExtension();
                $location = public_path('images/'.$filename);
                Image::make($logo)->save($location);
            }

            $show = new Shows();
            $show->slug = Str::slug($request->name);
            $show->name = $request->name;
            $show->logo = $filename;
            $show->save();

            //Associa o programa ao usuário apresentador
            $presenter->show()->save($show);

            //Retorna o programa com os dados do usuário apresentador
            $show->load('presenter');

            return response()->json(['message' => 'Programa criado', 'programa' => $show], 200);
        }catch(ValidationException $e){
            return response()->json(['error' => 'Ocorreu um problema de validacao', 'message' => $e->errors()], 400);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna um programa específico------------
    /**
     * @OA\Get(
     *      path="/api/programas/{slug}",
     *      tags={"Programas"},
     *      description="Este endpoint retorna um programa específico cadastrado no sistema da Rede Akiba.",
     *      summary="Retorna um programa específico",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug do Programa: Retorna um programa baseado no slug fornecido.",    
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Programa encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/ShowResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Programa não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Programa não encontrado")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          ),
     *     ),
     * )
     */

    public function show($slug)
    {
        try{
            $show = Shows::with('slug')->where('slug', $slug)->first();

            if(!$show){
                return response()->json(['error' => 'Programa não encontrado'], 404);
            }

            return response()->json(['message' => 'Programa encontrado', 'programa' => $show], 200);
        }catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }


    //--------------Atualiza um programa especifico------------

    /**
     * @OA\Patch(
     *      path="/api/programas/{id}",
     *      tags={"Programas"},
     *      description="Este endpoint realiza a atualização de um programa específico cadastrado no sistema da Rede Akiba.",
     *      summary="Atualiza um programa específico",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Programa: Atualiza um programa baseado no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/ShowRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Programa atualizado",
     *          @OA\JsonContent(ref="#/components/schemas/ShowResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum programa encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum programa encontrado")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um problema de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de processamento")
     *          ),
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        try{
            $show = Shows::find($id);

            if(!$show){
                return response()->json(['error' => 'Nenhum programa encontrado'], 404);
            }
    
            if($request->hasFile('logo')){
                //Deleta o logo antigo
                Storage::delete('public/images/'.$show->logo);

                $logo = $request->file('logo');
                $filename = time().'.'.$logo -> getClientOriginalExtension();
                $location = public_path('images/'.$filename);
                Image::make($logo)->save($location);
                $show->logo = $filename;
            }

            if($request->has('name')){
                $show->slug = Str::slug($request->name);
                $show->name = $request->name;
            }
    
            if($request->has('presenter')){
                $presenter = Users::find($request->presenter);
                if($presenter){
                    $presenter->show()->save($show);
                }else{
                    return response()->json(['error' => 'Nenhum apresentador encontrado'], 404);
                }
            }
    
            $show->save();
    
            //Retorna o programa com os dados do usuário apresentador
            $show->load('presenter');

            return response()->json(['message' => 'Programa atualizado', 'programa' => $show], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    //--------------Remove um programa------------
    /**
     * @OA\Delete(
     *      path="/api/programas/{id}",
     *      tags={"Programas"},
     *      description="Este endpoint remove um programa específico cadastrado no sistema da Rede Akiba.",
     *      summary="Remove um programa específico",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Programa: Retorna um programa baseado no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Programa removido",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Programa removido")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum programa encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum programa encontrado")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um problema de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de processamento")
     *          ),
     *      ),     
     * ),
     */

    public function destroy($id)
    {
        try{
            $show = Shows::find($id);

            if(!$show){
                return response()->json(['error' => 'Nenhum programa encontrado'], 404);
            }

            //Deleta o logo do programa
            Storage::delete('public/images/'.$show->logo);

            $show->delete();

            return response()->json(['message' => 'Programa removido'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }
}
