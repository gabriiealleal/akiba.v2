<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; 

/**
 * @OA\Tag(
 *      name="Repositório de Arquivos",
 *      description="Esta seção oferece acesso a operações relacionadas ao repostório de arquivos no sistema da Rede Akiba"
 * )
 */
class RepositoryController extends Controller
{
    //--------------Retorna todos os arquivos cadastrados------------
    /**
     * @OA\Get(
     *      path="/api/repositorio-de-arquivos",
     *      tags={"Repositório de Arquivos"},
     *      summary="Lista todos os arquivos cadastrados",
     *      description="Este endpoint retorna todos os arquivos cadastrados no sistema",
     *      @OA\Response(
     *          response=200,
     *          description="Arquivos encontrados",
     *          @OA\JsonContent(ref="#/components/schemas/RepositoryResponse")
     *      ),
     *      @OA\Response(
     *          response=404,   
     *          description="Nenhum arquivo encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhuma arquivo encontrado")
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
    public function index()
    {
        try{
            $repository = Repository::all();

            if($repository -> isEmpty()){
                return response()->json([
                    'message' => 'Nenhuma arquivo encontrado'
                ], 404);
            }

            return response()->json(["message" => "Arquivos encontrados", "arquivos" => $repository], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Cadastra um novo arquivo--------------
    /**
     * @OA\Post(    
     *      path="/api/repositorio-de-arquivos",
     *      tags={"Repositório de Arquivos"},
     *      summary="Cadastra um novo arquivo",
     *      description="Este endpoint realiza o cadastro de um novo arquivo no sistema",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RepositoryRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Arquivo cadastrado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/RepositoryResponse")
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
     * )
     */
    public function store(Request $request)
    {
        try{
            $messages = [
                'category.required' => 'A categoria é obrigatória',
                'file.required' => 'O arquivo é obrigatório',
                'icon.required' => 'O ícone é obrigatório',
            ];

            $request->validate([
                'file' => 'required',
                'category' => 'required',
                'icon' => 'required',
            ], $messages);

            if ($request->hasFile('icon')) {
                $icon_image = $request->file('icon');
                $icon_image_filename = time() . '.' . $icon_image->getClientOriginalExtension();
                $location = public_path('images/' . $icon_image_filename);
                Image::make($icon_image)->save($location);
            }

            $repository = new Repository();
            $repository->category = $request->category;
            $repository->file = $request->file;
            $repository->icon = $icon_image_filename;
            $repository->save();

            return response()->json(['message' => 'Arquivo cadastrado com sucesso', "arquivo" => $repository], 200);
        }catch(ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->errors()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', "error" => $e->getMessage()], 500);
        }
    }

    //--------------Retorna um arquivo especifico--------------
    /**
     * @OA\Get(
     *      path="/api/repositorio-de-arquivos/{id}",
     *      tags={"Repositório de Arquivos"},   
     *      summary="Retorna um arquivo específico",
     *      description="Este endpoint retorna um arquivo específico cadastrado no sistema",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id do Arquivo: Retorna um arquivo específico baseado no id fornecido",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Arquivo encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/RepositoryResponse")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Arquivo não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Arquivo não encontrado")
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
    public function show($id)
    {
        try{
            $repository = Repository::find($id);

            if($repository == null){
                return response()->json(['message' => 'Arquivo não encontrado'], 404);
            }

            return response()->json(['message' => 'Arquivo encontrado', 'arquivo' => $repository], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza um arquivo específico------------
    /**
     * @OA\Patch(
     *      path="/api/repositorio-de-arquivos/{id}",
     *      tags={"Repositório de Arquivos"},       
     *      summary="Atualiza um arquivo específico",
     *      description="Este endpoint atualiza um arquivo específico cadastrado no sistema",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id do Arquivo: Atualiza um arquivo específico baseado no id fornecido",
     *          required=true,
     *          @OA\Schema( 	
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/RepositoryRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Arquivo atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/RepositoryResponse")
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Arquivo não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Arquivo não encontrado")
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
    public function update(Request $request, $id)
    {
        try{
            $repository = Repository::find($id);

            if($repository == null){
                return response()->json(['message' => 'Arquivo não encontrado'], 404);
            }

            if($request->hasFile('icon')){
                $icon_image = $request->file('icon');
                $icon_image_filename = time() . '.' . $icon_image->getClientOriginalExtension();
                $location = public_path('images/' . $icon_image_filename);
                Image::make($icon_image)->save($location);
                $repository->icon = $icon_image_filename;
            }

            if($request->hasFile('file')){
                $repository->file = $request->file;
            }

            if($request->category){
                $repository->category = $request->category;
            }

            $repository->save();

            return response()->json(['message' => 'Arquivo atualizado com sucesso', 'arquivo' => $repository], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Remove um arquivo especifico------------
    /**
     * @OA\Delete(
     *      path="/api/repositorio-de-arquivos/{id}",
     *      tags={"Repositório de Arquivos"},
     *      summary="Remove um arquivo específico",
     *      description="Este endpoint remove um arquivo específico cadastrado no sistema",
     *      @OA\Parameter(
     *          name="id",
     *          in="path",
     *          description="Id do Arquivo: Remove um arquivo específico baseado no id fornecido",
     *          required=true,
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Arquivo removido com sucesso",
     *          @OA\JsonContent(    
     *              @OA\Property(property="message", type="string", example="Arquivo removido com sucesso")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Arquivo não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Arquivo não encontrado")
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
    public function destroy($id)
    {
        try{
            $repository = Repository::find($id);

            if($repository == null){
                return response()->json(['message' => 'Arquivo não encontrado'], 404);
            }

            //Deleta o icone do arquivo
            Storage::delete('images/' . $repository->icon);

            //Deleta o arquivo
            $repository->delete();

            return response()->json(['message' => 'Arquivo removido com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }
}
