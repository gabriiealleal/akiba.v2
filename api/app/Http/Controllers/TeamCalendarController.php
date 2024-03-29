<?php

namespace App\Http\Controllers;

use App\Models\TeamCalendar;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

/**
 * @OA\Tag(
 *      name="Calendário da Equipe",
 *      description="Esta seção oferece acesso a operações relacionadas ao calendário da equipe no sistema da Rede Akiba."
 * )
 */
class TeamCalendarController extends Controller
{
    //--------------Retorna todos os eventos do calendario--------------
    /**
     * @OA\Get(
     *      path="/api/calendario-da-equipe",
     *      tags={"Calendário da Equipe"},
     *      summary="Lista de todos os eventos do calendário da equipe",
     *      description="Este endpoint retorna uma lista completa de todos os eventos no calendário da equipe cadastradas no sistema da Rede Akiba.",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de todos os eventos do calendário",
     *          @OA\JsonContent(ref="#/components/schemas/TeamCalendarResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum evento encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum evento encontrado"),
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
        try {
            $teamCalendar = TeamCalendar::with('responsible')->get();

            if ($teamCalendar->isEmpty()) {
                return response()->json(['message' => 'Nenhum evento encontrado'], 404);
            }

            return response()->json(['message' => 'Lista de todos os eventos do calendário', 'evento' => $teamCalendar], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'evento' => $e->getMessage()], 500);
        }
    }


    //--------------Cadastra um novo evento no calendário--------------
    /**
     * @OA\Post(
     *      path="/api/calendario-da-equipe",
     *      tags={"Calendário da Equipe"},
     *      summary="Cadastra um novo evento no calendário da equipe",
     *      description="Este endpoint realiza o cadastro de um novo evento no calendário da equipe no sistema da Rede Akiba.",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TeamCalendarRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="evento cadastrado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/TeamCalendarResponse"),
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
        try {
            $messages = [
                'responsible.required' => 'O campo responsible é obrigatório',
            ];

            $request->validate([
                'responsible' => 'required',
            ], $messages);

            $responsible = Users::find($request->responsible);
            if (!$responsible) {
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $teamCalendar = new TeamCalendar();
            $teamCalendar->day = $request->day;
            $teamCalendar->hour = $request->hour;
            $teamCalendar->category = $request->category;
            $teamCalendar->responsible = $request->responsible;
            $teamCalendar->content = $request->content;
            $teamCalendar->save();

            //Associa o evento no calendário ao usuário responsável
            $responsible->teamCalendar()->save($teamCalendar);

            //Retorna o evento com os dados do usuário responsável
            $teamCalendar->load('responsible');

            return response()->json(['message' => 'evento cadastrado com sucesso', 'evento' => $teamCalendar], 200);
        } catch (ValidationException $e) {
            return response()->json(['message' => 'Ocorreu um erro de validação', 'evento' => $e->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'data' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna um evento especifico no calendário--------------
    /**
     * @OA\Get(
     *      path="/api/calendario-da-equipe/{slug}",
     *      tags={"Calendário da Equipe"},
     *      summary="Detalhes de um evento específico do calendário da equipe",
     *      description="Este endpoint retorna os detalhes de um evento específico do calendário da equipe cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug do Evento: Retorna um evento específico do calendário da equipe baseado no slug fornecido",
     *          required=true,      
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Evento encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/TeamCalendarResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Evento não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Evento não encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um erro de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um erro de processamento"),
     *          ),
     *      ),
     *)
     */
    public function show($slug)
    {
        try {
            $teamCalendar = TeamCalendar::with('responsible')->where('slug', $slug)->first();

            if (!$teamCalendar) {
                return response()->json(['message' => 'evento não encontrado'], 404);
            }

            return response()->json(['message' => 'evento encontrado', 'data' => $teamCalendar], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'data' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza uma tarefa especifica------------
    /**
     * @OA\Patch(
     *      path="/api/calendario-da-equipe/{id}",
     *      tags={"Calendário da Equipe"},
     *      summary="Atualiza um evento específico do calendário da equipe",
     *      description="Este endpoint atualiza um evento específico do calendário da equipe cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Evento: Atualiza um evento específico do calendário da equipe baseado no id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/TeamCalendarRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Evento atualizado com sucesso",
     *          @OA\JsonContent(ref="#/components/schemas/TeamCalendarResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Evento ou usuário não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Evento ou usuário não encontrado"),
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
        try {
            $teamCalendar = TeamCalendar::find($id);

            if (!$teamCalendar) {
                return response()->json(['message' => 'evento não encontrado'], 404);
            }

            if ($request->has('day')) {
                $teamCalendar->day = $request->day;
            }

            if ($request->has('hour')) {
                $teamCalendar->hour = $request->hour;
            }

            if ($request->has('category')) {
                $teamCalendar->category = $request->category;
            }

            if ($request->has('responsible')) {
                $responsible = Users::find($request->responsible);
                if ($responsible) {
                    $responsible->teamCalendar()->save($teamCalendar);
                } else {
                    return response()->json(['message' => 'Usuário não encontrado'], 404);
                }
            }

            if ($request->has('content')) {
                $teamCalendar->content = $request->content;
            }

            $teamCalendar->save();

            //Retorna o evento com os dados do usuário responsável
            $teamCalendar->load('responsible');

            return response()->json(['message' => 'evento atualizado com sucesso', 'evento' => $teamCalendar], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'data' => $e->getMessage()], 500);
        }
    }

    //--------------Remove uma tarefa------------
    /**
     * @OA\Delete(
     *      path="/api/calendario-da-equipe/{id}",
     *      tags={"Calendário da Equipe"},
     *      summary="Remove um evento específico do calendário da equipe",
     *      description="Este endpoint remove um evento específico do calendário da equipe cadastrado no sistema da Rede Akiba.",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Evento: Remove um evento específico do calendário da equipe baseado no id fornecido",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Evento removido com sucesso",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Evento removido com sucesso"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Evento não encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Evento não encontrado"),
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
        try {
            $teamCalendar = TeamCalendar::find($id);

            if (!$teamCalendar) {
                return response()->json(['message' => 'evento não encontrado'], 404);
            }

            $teamCalendar->delete();

            return response()->json(['message' => 'evento removido com sucesso'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'data' => $e->getMessage()], 500);
        }
    }
}
