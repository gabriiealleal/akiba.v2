<?php

namespace App\Http\Controllers;

use App\Models\NotificationTeam;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *      name="Notificações da Equipe",
 *      description="Esta seção oferece acesso a operações relacionadas as notificações da equipe cadastradas no sistema da Rede Akiba."
 * )
 */
class NotificationTeamController extends Controller
{
    //--------------Retorna todas as notificações cadastradas--------------
    /**
     * @OA\Get(
     *      path="/notificacoes",
     *      tags={"Notificações da Equipe"},
     *      summary="Retorna todas as notificações cadastrados",
     *      description="Este endpoint retorna uma lista completa de todas as notificações da equipe cadastradas no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="user",
     *          description="Id do Usuário: Retorna todas as notificações cadastradas para um usuário especifico baseado no id fornecido.",
     *          required=false,
     *          in="query", 
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Lista de notificações cadastradas",
     *          @OA\JsonContent(ref="#/components/schemas/NotificationTeamResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhuma notificação cadastrada",
     *          @OA\JsonContent( 
     *              @OA\Property(property="error", type="string", example="Nenhuma notificação cadastrada")
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
        try{
            if($request->has('user')){
                $notification = NotificationTeam::with(['addressee', 'creator'])
                    ->whereIn('addressee', [$request->user, null, 0]) 
                    ->get();  
                
                if($notification->isEmpty()){
                    return response()->json(['message' => 'Nenhuma notificação cadastrada'], 404);
                }else{
                    return response()->json(['message' => 'Lista de notificações cadastradas', 'notificações' => $notification], 200);
                }
            }else{
                $notification = NotificationTeam::with(['addressee', 'creator'])->get();

                if($notification->isEmpty()){
                    return response()->json(['message' => 'Nenhuma notificação cadastrada'], 404);
                }else{
                    return response()->json(['message' => 'Lista de notificações cadastradas', 'notificações' => $notification], 200);
                }
            }
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Cadastra uma nova notificação--------------
    /**
     * @OA\Post(
     *      path="/notificacoes",
     *      tags={"Notificações da Equipe"},
     *      summary="Cadastra uma nova notificação",
     *      description="Este endpoint realiza o cadastro de uma nova notificação da equipe no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/NotificationTeamRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Notificação cadastrada com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/NotificationTeamResponse"),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um erro de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de validação"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Usuário não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Usuário não encontrado"),
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
                'creator.required' => 'O campo criador é obrigatório',
                'addressee.required' => 'O campo destinatário é obrigatório',
            ];

            $request->validate([
                'creator' => 'required',
                'addressee' => 'required',
            ], $messages);

            $creator = Users::find($request->creator);
            if(!$creator){
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $addressee = Users::find($request->addressee);
            if(!$addressee){
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $notification = new NotificationTeam();
            $notification->creator = $request->creator;
            $notification->addressee = $request->addressee;
            $notification->content = $request->content;
            $notification->save();

            //Associa o programa ao usuário responsável
            $addressee->notification()->save($addressee);

            //Retorna a tarefa com os dados do usuário responsável
            $notification->load('creator');
            $notification->load('addressee');

            return response()->json(['message' => 'Notificação cadastrada com sucesso', 'notificação' => $notification], 200);
        }catch(ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->errors()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna uma notificação específica--------------
    /**
     * @OA\Get(
     *      path="/notificacoes/{id}",
     *      tags={"Notificações da Equipe"},
     *      summary="Retorna uma notificação específica",
     *      description="Este endpoint retorna uma notificação específica da equipe cadastrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Notificação: Retorna uma notificação específica baseada no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Notificação encontrada",
     *          @OA\JsonContent(ref="#/components/schemas/NotificationTeamResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Notificação não encontrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Tarefa não encontrada"),
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
            $notification = NotificationTeam::find($id);

            if(!$notification){
                return response()->json(['message' => 'Notificação não encontrada'], 404);
            }

            return response()->json(['message' => 'Notificação encontrada', 'Notificação' => $notification], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza uma notificação especifica------------
    /**
     * @OA\Patch(
     *      path="/notificacoes/{id}",
     *      tags={"Notificações da Equipe"},
     *      summary="Atualiza uma notificação específica",
     *      description="Este endpoint atualiza uma notificação específica da equipe cadastrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",  
     *          description="Id da notificação: Atualiza uma notificação específica baseada no Id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/NotificationTeamRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Notificação atualizada com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/NotificationTeamResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Notificação ou usuário não encontrado(a)",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Notificação ou usuário não encontrado(a"),
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
            $notification = NotificationTeam::find($id);

            if(!$notification){
                return response()->json(['message' => 'Tarefa não encontrada'], 404);
            }

            if($request->has('creator')){
                $creator = Users::find($request->creator);
                if($creator){
                    $creator->notification()->save($notification);
                }else{
                    return response()->json(['message' => 'Usuário não encontrado'], 404);
                }
            }

            if($request->has('addressee')){
                $addressee = Users::find($request->addressee);
                if($addressee){
                    $addressee->notification()->save($notification);
                }else{
                    return response()->json(['message' => 'Usuário não encontrado'], 404);
                }
            }

            if($request->has('content')){
                $notification->content = $request->content;
            }

            $notification->save();

            //Retorna a notificação com os dados do usuário responsável
            $notification->load('creator');
            $notification->load('addressee');

            return response()->json(['message' => 'Notificação atualizada com sucesso', 'notificação' => $notification], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Remove uma notificação------------
    /**
     * @OA\Delete(
     *      path="/notificacoes/{id}",
     *      tags={"Notificações da Equipe"},
     *      summary="Remove uma notificação específica",
     *      description="Este endpoint remove uma notificação específica da equipe cadastrada no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id da Notificação: Remove uma notificação específica baseada no Id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          ),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Notificação removida com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Notificação removida com sucesso"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Notificação não encontrada",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Notificação não encontrada"),
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
            $notification = NotificationTeam::find($id);

            if(!$notification){
                return response()->json(['message' => 'Notificação não encontrada'], 404);
            }

            $notification->delete();

            return response()->json(['message' => 'Notificação removida com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

}
