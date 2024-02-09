<?php

namespace App\Http\Controllers;

use App\Models\Shows;
use App\Models\StreamingNow;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;                             

/**
 * @OA\Tag(
 *    name="Histórico de Transmissão",
 *    description="Esta seção oferece acesso a operações relacionadas ao histórico de programação da rádio no sistema da Rede Akiba.",
 * )
 */

class StreamingNowController extends Controller
{
    /***********Lista todos os programas do histórico***********/
    /**
     * @OA\Get(
     *      path="/api/historico-de-transmissao/{now}",
     *      tags={"Histórico de Transmissão"},
     *      summary="Retorna todos os programas do histórico de transmissão",
     *      description="Este endpoint retorna uma lista completa de todos os programas cadastrados no histórico de transmissão da programação no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="now",
     *          in="path",
     *          description="Opcional: Retorna apenas o registro no histórico do programa que está em andamento no momento",
     *          required=false,
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Lista de programas do histórico de transmissão",
     *          @OA\JsonContent(ref="#/components/schemas/StreamingNowResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum registro encontrado no histórico",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum registro encontrado no histórico")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,   
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          ),
     *      ),
     * ),    
     */
    public function index(Request $request)
    {
        try{
            if($request->has('now')){
                $now = Carbon::now();
                $streamingNow = StreamingNow::with('show')
                    ->whereDate('date_streaming', $now->format('Y-m-d'))
                    ->where('start_streaming', '<=', $now->format('H:i:s'))
                    ->where('end_streaming', '>=', $now->format('H:i:s'))
                    ->get();
            } else {
                $streamingNow = StreamingNow::with('show')->get();
            }
    
            if($streamingNow->isEmpty()){
                return response()->json(['message' => 'Nenhum registro no histórico'], 404);
            }
    
            return response()->json(['message' => 'Lista de registros do histórico de transmissão', 'registros' => $streamingNow], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento'], 500);
        }
    }


    /***********Cadastra um programa novo no histórico***********/
    /**
     * @OA\Post(
     *      path="/api/historico-de-transmissao",
     *      tags={"Histórico de Transmissão"},
     *      summary="Cadastra um programa no histórico de transmissão",
     *      description="Este endpoint cadastra um programa no histórico de transmissão da programação no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/StreamingNowRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Programa cadastrado no histórico",
     *          @OA\JsonContent(ref="#/components/schemas/StreamingNowResponse"),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação"),
     *              @OA\Property(property="message", type="object", example={"show": {"O campo show é obrigatório"}})
     *         ),
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
     *      ),
     * ),
     */
    public function store(Request $request)
    {
        try{
            $messages = [
                'show.required' => 'O campo show é obrigatório',
            ];
    
            $validator = $request->validate([
                'show' => 'required',
            ], $messages);
    
            // Busca o show antes de tentar usar $show->name
            $show = Shows::find($request->show);
            if(!$show){
                return response()->json(['message' => 'Programa não encontrado'], 404);
            }
    
            $streamingNow = new StreamingNow();
            $streamingNow->slug = Str::slug($show->name);
            $streamingNow->type = $request->type;
            $streamingNow->date_streaming = $request->date_streaming;
            $streamingNow->start_streaming = $request->start_streaming;
            $streamingNow->end_streaming = $request->end_streaming;
    
            // Associa o programa ao registro no histórico
            $show->streamingNow()->save($streamingNow);
    
            // Retorna o registro no histórico com o programa associado
            $streamingNow->load('show');
    
            return response()->json(['message' => 'Registro criado no histórico', 'registro' => $streamingNow], 200);
        }catch(\ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'message' => $e->errors()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /***********Recupera um programa especifico do histórico***********/
    /**
     * @OA\Get(
     *      path="/api/historico-de-transmissao/{slug}",
     *      tags={"Histórico de Transmissão"},
     *      summary="Retorna um programa especifico do histórico de transmissão",
     *      description="Este endpoint retorna um programa específico no histórico de transmissão da programação no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug do Registro no Histórico de Transmissão: Retorna um registro específico do histórico de transmissão baseado no slug fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string",
     *          ),
     *      ),  
     *      @OA\Response(
     *          response=200,       
     *          description="Registro encontrado no histórico",
     *          @OA\JsonContent(ref="#/components/schemas/StreamingNowResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Registro não encontrado no histórico",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Regisro não encontrado no histórico")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          ),
     *      ),
     * ),    
     */
    public function show($slug)
    {
        try{
            $streamingNow = StreamingNow::with('slug')->where('slug', $slug)->first();
            
            if(!$streamingNow){
                return response()->json(['message' => 'Registro não encontrado no histórico'], 404);
            }

            return response()->json(['message' => 'Registro encontrado no histórico', 'registro' => $streamingNow], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /***********Atualiza um programa especifico do histórico***********/
    /**
     * @OA\Patch(
     *      path="/api/historico-de-transmissao/{id}",
     *      tags={"Histórico de Transmissão"},
     *      description="Este endpoint realiza a atualização de um registro específico no histórico de transmissão cadastrado no sistema da Rede Akiba.",
     *      summary="Atualiza um registro especifico do histórico de transmissão",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Registro no Histórico de Transmissão: Atualiza um registro específico do histórico de transmissão baseado no Id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(ref="#/components/schemas/StreamingNowRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Registro atualizado no histórico",
     *          @OA\JsonContent(ref="#/components/schemas/StreamingNowResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Registro não encontrado no histórico", 
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Registro não encontrado no histórico")
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
    public function update(Request $request, $id)
    {
        try{
            $streamingNow = StreamingNow::find($id);

            if(!$streamingNow){
                return response()->json(['message' => 'Registro não encontrado no histórico'], 404);
            }

            if($request->has('show')){
                $show = Shows::find($request->show);
                if(!$show){
                    return response()->json(['message' => 'Programa não encontrado'], 404);
                }
                $streamingNow->show_id = $request->show;
            }

            if($request->has('type')){
                $streamingNow->type = $request->type;
            }

            if($request->has('date_streaming')){
                $streamingNow->date_streaming = $request->date_streaming;
            }

            if($request->has('start_streaming')){
                $streamingNow->start_streaming = $request->start_streaming;
            }

            if($request->has('end_streaming')){
                $streamingNow->end_streaming = $request->end_streaming;
            }

            $streamingNow->save();

            // Retorna o registro no histórico com o programa associado
            $streamingNow->load('show');

            return response()->json(['message' => 'Registro atualizado no histórico', 'registro' => $streamingNow], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /***********Remove um programa especifico do histórico***********/
    /**
     * @OA\Delete(
     *      path="/api/historico-de-transmissao/{id}",
     *      tags={"Histórico de Transmissão"},
     *      description="Este endpoint remove um registro específico do histórico de transmissão no sistema da Rede Akiba.",
     *      summary="Remove um registro especifico do histórico de transmissão",
     *      @OA\Parameter( 
     *          name="id",
     *          description="Id do Registro no Histórico de Transmissão: Remove um registro específico do histórico de transmissão baseado no Id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer",
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Registro removido do histórico",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Registro removido do histórico")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Registro não encontrado no histórico",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Registro não encontrado no histórico")
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento")
     *          ),
     *      ),
     * ),
     * 
     */
    public function destroy($id)
    {
        try{
            $streamingNow = StreamingNow::find($id);

            if(!$streamingNow){
                return response()->json(['message' => 'Registro não encontrado no histórico'], 404);
            }

            $streamingNow->delete();

            return response()->json(['message' => 'Registro removido do histórico'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }
}
