<?php

namespace App\Http\Controllers;

use App\Models\Forms;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *      name="Formulários",
 *      description="Esta seção oferece acesso a operações relacionadas aos formulários no sistema da Rede Akiba"
 * )
 */

class FormsController extends Controller
{
    //--------------Retorna todos os formulários cadastrados------------
    /**
     * @OA\Get(
     *      path="/api/formularios",
     *      tags={"Formulários"},
     *      summary="Retorna uma lista de todos os formulários cadastrados",
     *      description="Este endpoint retorna uma lista completa de todos os formulários cadastrados no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de todos os formulários cadastrados", 
     *          @OA\JsonContent(ref="#/components/schemas/FormsResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum formulário cadastrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum formulário cadastrado")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação")
     *          )
     *      )
     * )
     */
    public function index()
    {
        try{
            $forms = Forms::all();

            if($forms-> isEmpty()){
                return response()->json(['message' => 'Nenhum formulário cadastrado'], 404);
            }

            return response()->json(['message' => 'Lista de todos os formulários cadastrados', 'data' => $forms], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'data' => [$e->getMessage()]], 500);
        }
    }

    //--------------Cadastra um novo formulário------------
    /**
     * @OA\Post(
     *      path="/api/formularios",
     *      tags={"Formulários"},
     *      summary="Cadastra um novo formulário",
     *      description="Este endpoint cadastra um novo formulário no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/FormsRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Formulário cadastrado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/FormsResponse"),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          )
     *      )
     * )
     */
    public function store(Request $request)
    {
        try{
            $forms = new Forms();
            $forms->type = $request->type;
            $forms->content = $request->content;
            $forms->save();

            return response()->json(['message' => 'Formulário cadastrado com sucesso', 'data' => $forms], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => [$e->getMessage()]], 500);
        }
    }

    //--------------Retorna um formulário especifico------------
    /**
     * @OA\Get(
     *      path="/api/formularios/{id}",
     *      tags={"Formulários"},
     *      summary="Retorna um formulário específico",
     *      description="Este endpoint retorna um formulário especifico cadastrado sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Formulário: Retorna um formulário específico baseado no id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Formulário encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/FormsResponse"),
     *      ),  
     *      @OA\Response(
     *          response=404,
     *          description="Formulário não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Formulário não encontrado")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          )
     *      )
     * )
     */
    public function show($id)
    {
        try{
            $forms = Forms::find($id);

            if($forms == null){
                return response()->json(['message' => 'Formulário não encontrado'], 404);
            }

            return response()->json(['message' => 'Formulário encontrado', 'data' => $forms], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => [$e->getMessage()]], 500);
        }
    }

    //--------------Atualiza um formulário especifico------------
    /**
     * @OA\Patch(
     *      path="/api/formularios/{id}",
     *      tags={"Formulários"},
     *      summary="Atualiza um formulário específico",
     *      description="Este endpoint atualiza um formulário específico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Formulário: Atualiza um formulário específico baseado no id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/FormsRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Formulário atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/FormsResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Formulário não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Formulário não encontrado")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          )
     *      )
     * )
     */
    public function update(Request $request, $id)
    {
        try{
            $forms = Forms::find($id);

            if($forms -> isEmpty()){
                return response()->json(['message' => 'Formulário não encontrado'], 404);
            }

            if($request->has('type')){
                $forms->type = $request->type;
            }

            if($request->has('content')){
                $forms->content = $request->content;
            }

            $forms->save();

            return response()->json(['message' => 'Formulário atualizado com sucesso', 'data' => $forms], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => [$e->getMessage()]], 500);
        }
    }

    //--------------Deleta um formulário especifico------------
    /**
     * @OA\Delete(
     *      path="/api/formularios/{id}",
     *      tags={"Formulários"},
     *      summary="Deleta um formulário específico",
     *      description="Este endpoint deleta um formulário específico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Formulário: Deleta um formulário específico baseado no id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Formulário deletado com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Formulário deletado com sucesso")
     *          )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Formulário não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Formulário não encontrado")
     *          )
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          )
     *      )
     * )
     */
    public function destroy($id)
    {
        try{
            $forms = Forms::find($id);

            if($forms -> isEmpty()){
                return response()->json(['message' => 'Formulário não encontrado'], 404);
            }

            $forms->delete();

            return response()->json(['message' => 'Formulário deletado com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => [$e->getMessage()]], 500);
        }
    }
}
