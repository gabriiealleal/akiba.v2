<?php

namespace App\Http\Controllers;

use App\Models\ListenerRequests;
use App\Models\StreamingNow;
use App\Models\MusicsList;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *      name="Pedidos musicais",
 *      description="Esta seção oferece acesso a operações relacionadas aos pedidos musicais dos ouvintes no sistema da Rede Akiba."
 * )
*/

class ListenerRequestsController extends Controller
{
    //--------------Lista todos os pedidos musicais--------------
    /**
     * @OA\Get(
     *      path="/api/pedidos-musicais/{streaming_now}",
     *      tags={"Pedidos musicais"},
     *      summary="Lista todos os pedidos musicais",
     *      description="Este endpoint retorna uma lista completa de todos os programas cadastrados no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="streamingnow",
     *          description="(Opcional) Id do Registro no Histórico de Transmissão: Retorna todos os pedidos musicais referentes a um registro no histórico de transmissão específico",
     *          required=false,
     *          in="path",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Lista de pedidos musicais cadastrados",
     *          @OA\JsonContent(ref="#/components/schemas/ListenerRequestResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum pedido musical encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum pedido musical encontrado")
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
    public function index(Request $request)
    {
        try {
            if($request->has('streamingnow')){
                $listenerRequests = ListenerRequests::with('streaming', 'music')
                    ->where('streaming_now', $request->streaming_now)->get();

                if($listenerRequests->isEmpty()){
                    return response()->json(['message' => 'Nenhum pedido musical encontrado'], 404);
                }

                return response()->json(['message' => 'Lista de pedidos musicais cadastrados', 'pedidos' => $listenerRequests], 200);
            }else{
                $listenerRequests = ListenerRequests::with('streaming', 'music')->get();
                if($listenerRequests->isEmpty()){
                    return response()->json(['message' => 'Nenhum pedido musical encontrado'], 404);
                }
                return response()->json(['message' => 'Lista de pedidos musicais cadastrados', 'pedidos' => $listenerRequests], 200);
            }
        } catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Cadastra um novo pedido musical--------------
    /**
     * @OA\Post(
     *      path="/api/pedidos-musicais",
     *      tags={"Pedidos musicais"},
     *      summary="Cadastra um novo pedido musical",
     *      description="Este endpoint realiza o cadastro de um novo pedido musical no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ListenerRequestRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Pedido musical cadastrado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/ListenerRequestResponse"),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação"),
     *              @OA\Property(property="message", type="object", example={
     *                  "streaming_now": "O campo streaming_now é obrigatório",
     *                  "streaming_now_id": "O id do programa informado no campo streaming_now não existe"
     *              }),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Programa ou música não encontrado",
     *          @OA\JsonContent(    
     *              @OA\Property(property="error", type="string", example="Programa ou música não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(    
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * ),
     */
    public function store(Request $request)
    {
        try {
            $messages = [
                'streaming_now.required' => 'O campo streaming_now é obrigatório',
                'streaming_now.exists' => 'O streaming_now informado não existe',
            ];
    
            $request->validate([
                'streaming_now' => 'required|exists:streaming_now,id',
            ], $messages);
    
            $streamingNow = StreamingNow::find($request->streaming_now);
            if (!$streamingNow) {
                return response()->json(['message' => 'Programa não encontrado'], 404);
            }
    
            $musicsList = MusicsList::find($request->music);
            if (!$musicsList) {
                return response()->json(['message' => 'Música não encontrada'], 404);
            }
    
            $listenerRequest = new ListenerRequests();
            $listenerRequest->listener = $request->listener;
            $listenerRequest->address = $request->address;
            $listenerRequest->message = $request->message;
    
            // Associa o programa e a música ao pedido musical do ouvinte
            $listenerRequest->streamingNow()->associate($streamingNow);
            $listenerRequest->music()->associate($musicsList);
            $listenerRequest->save();
    
            // Retorna o pedido musical do ouvinte cadastrado com o programa no histórico associado
            $listenerRequest->load('streamingNow');
            $listenerRequest->load('music');
    
            return response()->json(['message' => 'Pedido musical do ouvinte cadastrado com sucesso', 'pedido' => $listenerRequest], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }
    

    //--------------Retorna um pedido musical especifico--------------
    /**
     * @OA\Get(
     *      path="/api/pedidos-musicais/{id}",
     *      tags={"Pedidos musicais"},
     *      summary="Retorna um pedido musical especifico",
     *      description="Este endpoint retorna um pedido musical especifico do sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Pedido Musical: Retorna um pedido musical específico baseado no id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Pedido musical encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/ListenerRequestResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Pedido musical não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Pedido musical não encontrado")
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
    public function show($id)
    {
        try{
            $listenerRequests = ListenerRequests::with('streaming_now', 'music')->find($id);
            if(!$listenerRequests){
                return response()->json(['message' => 'Pedido não encontrado'], 404);
            }
            return response()->json(['message' => 'Pedido musical encontrado', 'pedido' => $listenerRequests], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Erro ao buscar pedido', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza um pedido musical especifico--------------
    /**
     * @OA\Patch(
     *      path="/api/pedidos-musicais/{id}",
     *      tags={"Pedidos musicais"},
     *      summary="Atualiza um pedido musical especifico",
     *      description="Este endpoint realiza a atualização de um pedido musical especifico no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Pedido Musical: Atualiza um pedido musical específico baseado no id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/ListenerRequestRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Pedido musical atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/ListenerRequestResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Pedido musical ou registro no histórico de transmissão ou música não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Pedido musical não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * ),
     *          
     */
    public function update(Request $request, $id)
    {
        try{
            $listenerRequests = ListenerRequests::find($id);

            if(!$listenerRequests){
                return response()->json(['message' => 'Pedido musical não encontrado'], 404);
            }

            if($request->has('listener')){
                $listenerRequests->listener = $request->listener;
            }
            
            if($request->has('address')){
                $listenerRequests->address = $request->address;
            }

            if($request->has('message')){
                $listenerRequests->message = $request->message;
            }

            if($request->has('streaming_now')){
                $streamingNow = StreamingNow::find($request->streaming_now);
                if(!$streamingNow){
                    return response()->json(['message' => 'Registro não encontrado no histórico de transmissão'], 404);
                }
                $listenerRequests->streaming = $request->streaming;
            }

            if($request->has('music')){
                $musicsList = MusicsList::find($request->music);
                if(!$musicsList){
                    return response()->json(['message' => 'Música não encontrada'], 404);
                }
                $listenerRequests->music = $request->music;
            }

            $listenerRequests->save();

            // Retorna o pedido musical do ouvinte atualizado com o programa no histórico associado
            $listenerRequests->load('streaming_now');

            return response()->json(['message' => 'Pedido musical do ouvinte atualizado com sucesso', 'pedido' => $listenerRequests], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 400);
        }
    }

    //--------------Remove um pedido musical especifico--------------
    /**
     * @OA\Delete(
     *      path="/api/pedidos-musicais/{id}",
     *      tags={"Pedidos musicais"},
     *      summary="Remove um pedido musical especifico",
     *      description="Este endpoint realiza a remoção de um pedido musical especifico no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Pedido Musical: Remove um pedido musical específico baseado no id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Pedido musical removido com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Pedido musical removido"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Pedido musical não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Pedido musical não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     * ),    
     */
    public function destroy($id)
    {
        try{
            $listenerRequests = ListenerRequests::find($id);

            if(!$listenerRequests){
                return response()->json(['message' => 'Pedido não encontrado'], 404);
            }

            $listenerRequests->delete();
            return response()->json(['message' => 'Pedido musical do ouvinte removido com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }
}
