<?php

namespace App\Http\Controllers;

use App\Models\ListenerOfTheMonth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; 

/**
 * @OA\Tag(
 *      name="Ouvinte do Mês",
 *      description="Esta seção oferece acesso a operações relacionadas aos ouvintes do mês no sistema da Rede Akiba."
 * )
*/

class ListenerOfTheMounthController extends Controller
{
    //--------------Lista todos os ouvintes do mes--------------
    /**
     * @OA\Get(
     *      path="/api/ouvinte-do-mes",
     *      tags={"Ouvinte do Mês"},
     *      summary="Lista todos os ouvintes do mês",
     *      description="Este endpoint retorna uma lista completa de todos os ouvintes do mês cadastrados no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de ouvintes do mês",
     *          @OA\JsonContent(ref="#/components/schemas/ListenerOfTheMonthResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum ouvinte do mês encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum ouvinte do mês encontrado"),
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
    public function index()
    {
        try{
            $listenerOfTheMonth = ListenerOfTheMonth::all();

            if($listenerOfTheMonth -> isEmpty()){
                return response()->json(['message' => 'Nenhum ouvinte do mês encontrado'], 404);
            }
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage() ], 500);
        }
    }

    //--------------Cadastra um novo ouvinte do mês--------------
    /**
     * @OA\Post(
     *      path="/api/ouvinte-do-mes",
     *      tags={"Ouvinte do Mês"},
     *      summary="Cadastra um novo ouvinte do mês",
     *      description="Este endpoint realiza o cadastro de um novo ouvinte do mês no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ListenerOfTheMonthRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Ouvinte do mês cadastrado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/ListenerOfTheMonthResponse"),
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
                'avatar.required' => 'O campo avatar é obrigatório',
                'name.required' => 'O campo nome é obrigatório',
                'address.required' => 'O campo endereço é obrigatório',
                'favorite_show.required' => 'O campo programa favorito é obrigatório',
                'requests.required' => 'O campo pedidos é obrigatório',
            ];

            $request->validate([
                'avatar' => 'required',
                'address' => 'required',
                'name' => 'required',
                'favorite_show' => 'required',
                'requests' => 'required',
            ], $messages);

            if($request->hasFile('avatar')){
                $image = $request->file('avatar');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('images/'.$filename);
                Image::make($image)->save($location);
            }

            $listenerOfTheMonth = new ListenerOfTheMonth();
            $listenerOfTheMonth->avatar = $filename;
            $listenerOfTheMonth->name = $request->name;
            $listenerOfTheMonth->address = $request->address;
            $listenerOfTheMonth->favorite_show = $request->favorite_show;
            $listenerOfTheMonth->requests = $request->requests;
            $listenerOfTheMonth->save();

            return response()->json(['message' => 'Ouvinte do mês cadastrado com sucesso', 'ouvinte' => $listenerOfTheMonth ], 200);
        }catch(\Illuminate\Validation\ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->getMessage() ], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage() ], 500);
        }
    }

    //--------------Retorna um ouvinte do mês especifico--------------
    /**
     * @OA\Get(
     *      path="/api/ouvinte-do-mes/{id}",
     *      tags={"Ouvinte do Mês"},
     *      summary="Retorna um ouvinte do mês especifico",
     *      description="Este endpoint retorna um ouvinte do mês especifico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do ouvinte do Mês: Retorna um ouvinte do mês especifico baseado no id informado",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Ouvinte do mês encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/ListenerOfTheMonthResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Ouvinte do mês não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ouvinte do mês não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
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
    public function show($id)
    {
        try{
            $listenerOfTheMonth = ListenerOfTheMonth::find($id);

            if(!$listenerOfTheMonth){
                return response()->json(['message' => 'Ouvinte do mês não encontrado'], 404);
            }

            return response()->json(['ouvinte' => $listenerOfTheMonth], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage() ], 400);
        }
    }

    //--------------Atualiza um ouvinte do mês especifico--------------
    /**
     * @OA\Patch(
     *      path="/api/ouvinte-do-mes/{id}",
     *      tags={"Ouvinte do Mês"},
     *      summary="Atualiza um ouvinte do mês especifico",
     *      description="Este endpoint atualiza um ouvinte do mês especifico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do ouvinte do Mês: Atualiza um ouvinte do mês especifico baseado no id informado",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ListenerOfTheMonthRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Ouvinte do mês atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/ListenerOfTheMonthResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Ouvinte do mês não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ouvinte do mês não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
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
            $listenerOfTheMonth = ListenerOfTheMonth::find($id);

            if(!$listenerOfTheMonth){
                return response()->json(['message' => 'Ouvinte do mês não encontrado'], 404);
            }

            if($request->hasFile('avatar')){
                $image = $request->file('avatar');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('images/'.$filename);
                Image::make($image)->save($location);
                $listenerOfTheMonth->avatar = $filename;
            }

            if($request->name){
                $listenerOfTheMonth->name = $request->name;
            }

            if($request->address){
                $listenerOfTheMonth->address = $request->address;
            }

            if($request->favorite_show){
                $listenerOfTheMonth->favorite_show = $request->favorite_show;
            }

            if($request->requests){
                $listenerOfTheMonth->requests = $request->requests;
            }

            $listenerOfTheMonth->save();
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage() ], 400);
        }
    }

    //--------------Remove um ouvinte do mês especifico--------------
    /**
     * @OA\Delete(
     *      path="/api/ouvinte-do-mes/{id}",
     *      tags={"Ouvinte do Mês"},
     *      summary="Remove um ouvinte do mês especifico",
     *      description="Este endpoint remove um ouvinte do mês especifico cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Ouvinte do Mês: Remove um ouvinte do mês especifico baseado no id informado",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Ouvinte do mês removido com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Ouvinte do mês removido com sucesso"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Ouvinte do mês não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ouvinte do mês não encontrado"),
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
            $listenerOfTheMonth = ListenerOfTheMonth::find($id);

            if(!$listenerOfTheMonth){
                return response()->json(['message' => 'Ouvinte do mês não encontrado'], 404);
            }

            //Remove a imagem do ouvinte do mês
            Storage::delete('images/'.$listenerOfTheMonth->avatar);
            $listenerOfTheMonth->delete();

            return response()->json(['message' => 'Ouvinte do mês removido com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage() ], 500);
        }
    }
}
