<?php

namespace App\Http\Controllers;

use App\Models\Users;
use App\Models\Podcasts;
use Illuminate\Http\Request;

/**
 * @OA\Tag(
 *      name="Podcasts",
 *      description="Está seção oferece aceso a operações relacionadas aos podcasts cadastrados no sistema da Rede Akiba.",
 * )
 */

class PodcastsController extends Controller
{
    /*******Retorna todos os podcasts*******/
    public function index()
    {
        try{
            $podcasts = Podcasts::with('author')->get();
            
            if($podcasts->isEmpty()){
                return response()->json(['message' => 'Nenhum podcast encontrado'], 404);
            }

            return response()->json(['message' => 'Lista de todos os podcasts cadastrados', 'podcasts'=> $podcasts], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /*******Cadastra um novo podcast*******/
    public function store(Request $request)
    {
        try{
            $messages = [
                'author.required' => 'O campo author é obrigatório',
            ];

            $validator = $request->validate([
                'author' => 'required',
            ], $messages);

            $author = Users::find($request->author);
            if(!$author){
                return response()->json(['message' => 'Autor não encontrado'], 404);
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('/images'.$filename);
                Image::make($image)->save($location);
            }

            $podcasts = new Podcasts();
            $podcasts->slug = Str::slug($request->title);
            $podcasts->season = $request->season;
            $podcasts->episode = $request->episode;
            $podcasts->title = $request->title;
            $podcasts->image = $filename;
            $podcasts->resume = $request->resume;
            $podcasts->content = $request->content;
            $podcasts->player = $request->player;
            $podcasts->aggregators = $request->aggregators;

            //Associa o usuário ao podcast
            $author->podcasts()->save($podcasts);

            //Retorna o podcast com os dados do usuário autor associado
            $podcats->load('author');

            return response()->json(['message' => 'Podcast cadastrado com sucesso', 'podcast' => $podcasts], 201);
        }catch(ValidationException $e){
            return response()->json(['error' => 'Erro de validação', 'message' => $e->getMessage()], 422);  
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /*******Retorna um podcast especifico*******/
    public function show($id)
    {
        try{
            $podcasts = Podcasts::with('slug')->where('slug', $slug)->first();

            if(!$podcasts){
                return response()->json(['message' => 'Podcast não encontrado'], 404);
            }

            return response()->json(['message' => 'Podcast encontrado', 'podcast'=> $podcasts], 200);            
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }     
    }

    /*******Atualiza um podcast especifico*******/
    public function update(Request $request, $id)
    {
        try{
            $podcasts = Podcasts::find($id);

            if(!$podcasts){
                return response()->json(['message' => 'Podcast não encontrado'], 404);
            }

            if($request->hasFile('image')){
                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('/images'.$filename);
                Image::make($image)->save($location);
            }

            if($request -> has('author')){
                $author = Users::find($request->author);
                if($author){
                    $author->podcasts()->save($podcasts);
                }else{
                    return response()->json(['message' => 'Autor não encontrado'], 404);
                }
            }

            if($request -> has('season')){
                $podcasts->season = $request->season;
            }

            if($request -> has('episode')){
                $podcasts->episode = $request->episode;
            }

            if($request -> has('title')){
                $podcasts->title = $request->title;
            }

            if($request -> has('image')){
                //Deleta a imagem antiga
                Storage::delete('public/images/'.$podcasts->image);

                $image = $request->file('image');
                $filename = time().'.'.$image->getClientOriginalExtension();
                $location = public_path('/images'.$filename);
                Image::make($image)->save($location);
                $podcasts->image = $filename;
            }

            if($request -> has('resume')){
                $podcasts->resume = $request->resume;
            }

            if($request -> has('content')){
                $podcasts->content = $request->content;
            }

            if($request -> has('player')){
                $podcasts->player = $request->player;
            }

            if($request -> has('aggregators')){
                $podcasts->aggregators = $request->aggregators;
            }

            $podcasts->save();

            //Retorna o podcast com os dados do usuário autor associado
            $podcats->load('author');

            return response()->json(['message' => 'Podcast atualizado com sucesso', 'podcast' => $podcasts], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /*******Remove um podcast especifico*******/
    public function destroy($id)
    {
        try{
            $podcasts = Podcasts::find($id);

            if(!$podcasts){
                return response()->json(['message' => 'Podcast não encontrado'], 404);
            }

            //Deleta a imagem do podcast
            Storage::delete('public/images/'.$podcasts->image);

            $podcasts->delete();

            return response()->json(['message' => 'Podcast removido com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um erro de processamento', 'message' => $e->getMessage()], 500);
        }
    }
}
