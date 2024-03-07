<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TeamCalendarController extends Controller
{
    //--------------Retorna todos os registros do calendario--------------
    public function index()
    {
        try{
            $teamCalendar = TeamCalendar::with('responsible')->get();

            if($teamCalendar->isEmpty()){
                return response()->json(['message' => 'Nenhum registro encontrado'], 404);
            }

            return response()->json(['message' => 'Lista de todos os registros do calendário', 'registro' => $teamCalendar], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'registro' => $e->getMessage()], 500);
        }
    }


    //--------------Cadastra um novo registro no calendário--------------
    public function store(Request $request)
    {
        try{
            $messages = [
                'responsible.required' => 'O campo responsible é obrigatório',
            ];

            $request->validate([
                'responsible' => 'required',
            ]);

            $responsible = Users::find($request->responsible);
            if(!$responsible){
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            $teamCalendar = new TeamCalendar();
            $teamCalendar->day = $request->day;
            $teamCalendar->hour = $request->hour;
            $teamCalendar->category = $request->category;
            $teamCalendar->responsible = $request->responsible;
            $teamCalendar->content = $request->content;
            $teamCalendar->save();

            //Associa o registro no calendário ao usuário responsável
            $responsible->teamCalendar()->save($teamCalendar);

            //Retorna o registro com os dados do usuário responsável
            $teamCalendar->load('responsible');

            return response()->json(['message' => 'Registro cadastrado com sucesso', 'registro' => $teamCalendar], 200);
        }catch(ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'registro' => $e->errors()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'data' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna um registro especifico no calendário--------------
    public function show($slug)
    {
        try{
            $teamCalendar = TeamCalendar::with('responsible')->where('slug', $slug)->first();

            if(!$teamCalendar){
                return response()->json(['message' => 'Registro não encontrado'], 404);
            }

            return response()->json(['message' => 'Registro encontrado', 'data' => $teamCalendar], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'data' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza uma tarefa especifica------------
    public function update(Request $request, $id)
    {
        try{
            $teamCalendar = TeamCalendar::find($id);

            if(!$teamCalendar){
                return response()->json(['message' => 'Registro não encontrado'], 404);
            }

            if($request->has('day')){
                $teamCalendar->day = $request->day;
            }

            if($request->has('hour')){
                $teamCalendar->hour = $request->hour;
            }

            if($request->has('category')){
                $teamCalendar->category = $request->category;
            }

            if($request->has('responsible')){
                $responsible = Users::find($request->responsible);
                if($responsible){
                    $responsible->teamCalendar()->save($teamCalendar);
                }else{
                    return response()->json(['message' => 'Usuário não encontrado'], 404);
                }
            }

            if($request->has('content')){
                $teamCalendar->content = $request->content;
            }

            $teamCalendar->save();

            //Retorna o registro com os dados do usuário responsável
            $teamCalendar->load('responsible');

            return response()->json(['message' => 'Registro atualizado com sucesso', 'registro' => $teamCalendar], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'data' => $e->getMessage()], 500);
        }
    }

    //--------------Remove uma tarefa------------
    public function destroy($id)
    {
        try{
            $teamCalendar = TeamCalendar::find($id);

            if(!$teamCalendar){
                return response()->json(['message' => 'Registro não encontrado'], 404);
            }

            $teamCalendar->delete();

            return response()->json(['message' => 'Registro removido com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'data' => $e->getMessage()], 500);
        }
    }
}
