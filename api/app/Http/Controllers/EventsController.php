<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class EventsController extends Controller
{
    //--------------Lista todos os eventos--------------
    public function index()
    {
        try{
            $events = Events::with('author')->get();

            if($events->isEmpty()){
                return response()->json(['message' => 'Nenhum evento encontrado'], 404);
            }

            return response()->json(['message', 'Lista todos os eventos cadastrados', 'eventos' => $events], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Erro ao listar eventos', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Cadastra um novo evento--------------
    public function store(Request $request)
    {
        try{
            $messages = [
                'author.required' => 'O campo autor é obrigatório',
                'image.required' => 'O campo imagem é obrigatório',
            ];

            $validator = $request->validate([
                'author' => 'required',
                'image' => 'required',
                'dates' => 'required',
                'location' => 'required',
                'content' => 'required'
            ], $messages);

            $author = Users::find($request->author);
            if(!$author){
                return response()->json(['message' => 'Usuário não encontrado'], 404);
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $name = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('/images' . $name);
                Image::make($image)->save($location);
            }

            $events = new Events();
            $events->slug = Str::slug($request->title);
            $events->author = $request->author;
            $events->title = $request->title;
            $events->image = $name;
            $events->dates = $request->dates;
            $events->location = $request->location;
            $events->content = $request->content;
            $events->save();

            //Associando o evento com o usuário autor
            $author->events()->save($events);

            //Retorna o evento criado com o usuario autor
            $events->load('author');

            return response()->json(['message' => 'Evento cadastrado com sucesso', 'evento' => $events], 200);
        }catch(ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->getMessage()], 500);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Retorna uma evento específico------------
    public function show($slug)
    {
        try{
            $events = Events::with('slug')->where('slug', $slug)->first();

            if(!$events){
                return response()->json(['message' => 'Evento não encontrado'], 404);
            }

            return response()->json(['message' => 'Evento encontrado', 'evento' => $events], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza um evento especifico------------
    public function update(Request $request, $id)
    {
        try{
            $events = Events::find($id);

            if(!$events){
                return response()->json(['message' => 'Evento não encontrado'], 404);
            }

            if($request->hasFile('image')){
                //Deleta a imagem antiga
                Storage::delete('public/images/' . $events->image);

                //Salva a nova imagem
                $image = $request->file('image');
                $filename = time(). '.' . $image->getClientOriginalExtension();
                $location = public_path('images/' . $filename);
                Image::make($image)->save($location);
                $events->image = $filename;
            }

            if($request->author){
                $author = Users::find($request->author);
                if($author){
                    $author->events()->save($events);
                }else{
                    return response()->json(['message' => 'Usuário não encontrado'], 404);
                }
            }

            if($request->title){
                $events->slug = Str::slug($request->title);
                $events->title = $request->title;
            }

            if($request->dates){
                $events->dates = $request->dates;
            }

            if($request->location){
                $events->location = $request->location;
            }

            if($request->content){
                $events->content = $request->content;
            }

            $events->save();

            //Retorna o evento atualizado com o usuário autor
            $events->load('author');

            return response()->json(['message' => 'Evento atualizado com sucesso', 'evento' => $events], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Deleta uma evento especifico------------
    public function destroy($id)
    {
        try{
            $events = Events::find($id);

            if(!$events){
                return response()->json(['message' => 'Evento não encontrado'], 404);
            }

            //Deleta a imagem
            Storage::delete('public/images/' . $events->image);

            $events->delete();

            return response()->json(['message' => 'Evento deletado com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }
}
