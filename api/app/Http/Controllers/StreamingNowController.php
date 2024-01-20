<?php

namespace App\Http\Controllers;

use App\Models\StreamingNow;
use Illuminate\Http\Request;

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
     *      path="/api/historico_de_transmissao",
     *      tags={"Histórico de Transmissão"},
     *      summary="Retorna todos os programas do histórico de transmissão",
     *      description="Este endpoint retorna uma lista completa de todos os programas cadastrados no histórico de transmissão da programação no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de programas do histórico de transmissão",
     *          @OA\JsonContent(ref="#/components/schemas/StreamingNowResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum programa encontrado no histórico",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum programa encontrado no histórico")
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
    public function index()
    {
        try{
            $streamingNow = StreamingNow::with('show')->get();

            if($streamingNow->isEmpty()){
                return response()->json(['message' => 'Nenhum programa encontrado no histórico'], 404);
            }

            return response()->json($streamingNow, 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento'], 500);
        }
    }


    /***********Cadastra um programa novo no histórico***********/
    public function store(Request $request)
    {
        //
    }

    /***********Recupera um programa especifico do histórico***********/
    public function show($id)
    {
        //
    }

    /***********Atualiza um programa especifico do histórico***********/
    public function update(Request $request, $id)
    {
        //
    }

    /***********Remove um programa especifico do histórico***********/
    public function destroy($id)
    {
        //
    }
}
