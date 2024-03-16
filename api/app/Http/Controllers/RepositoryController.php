<?php

namespace App\Http\Controllers;

use App\Models\Repository;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image; 

class RepositoryController extends Controller
{
    //--------------Retorna todos os arquivos cadastrados------------
    public function index()
    {
        try{
            $repository = Repository::all();

            if($repository -> isEmpty()){
                return response()->json([
                    'message' => 'Nenhuma arquivo encontrado'
                ], 404);
            }

            return response()->json(["message" => "Arquivos encontrados", "arquivos" => $repository], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Cadastra um novo arquivo--------------
    public function store(Request $request)
    {
        try{
            $messages = [
                'category.required' => 'A categoria é obrigatória',
                'file.required' => 'O arquivo é obrigatório',
                'icon.required' => 'O ícone é obrigatório',
            ];

            $request->validate([
                'file' => 'required',
                'category' => 'required',
                'icon' => 'required',
            ], $messages);

            if ($request->hasFile('icon')) {
                $icon_image = $request->file('icon');
                $icon_image_filename = time() . '.' . $icon_image->getClientOriginalExtension();
                $location = public_path('images/' . $icon_image_filename);
                Image::make($icon_image)->save($location);
            }

            $repository = new Repository();
            $repository->category = $request->category;
            $repository->file = $request->file;
            $repository->icon = $icon_image_filename;
            $repository->save();

            return response()->json(['message' => 'Arquivo cadastrado com sucesso', "arquivo" => $repository], 200);
        }catch(ValidationException $e){
            return response()->json(['message' => 'Ocorreu um erro de validação', 'error' => $e->errors()], 400);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', "error" => $e->getMessage()], 500);
        }
    }

    //--------------Retorna um arquivo especifico--------------
    public function show($id)
    {
        try{
            $repository = Repository::find($id);

            if($repository == null){
                return response()->json(['message' => 'Arquivo não encontrado'], 404);
            }

            return response()->json(['message' => 'Arquivo encontrado', 'arquivo' => $repository], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Atualiza um arquivo específico------------
    public function update(Request $request, $id)
    {
        try{
            $repository = Repository::find($id);

            if($repository == null){
                return response()->json(['message' => 'Arquivo não encontrado'], 404);
            }

            if($request->hasFile('icon')){
                $icon_image = $request->file('icon');
                $icon_image_filename = time() . '.' . $icon_image->getClientOriginalExtension();
                $location = public_path('images/' . $icon_image_filename);
                Image::make($icon_image)->save($location);
                $repository->icon = $icon_image_filename;
            }

            if($request->hasFile('file')){
                $repository->file = $request->file;
            }

            if($request->category){
                $repository->category = $request->category;
            }

            $repository->save();

            return response()->json(['message' => 'Arquivo atualizado com sucesso', 'arquivo' => $repository], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }

    //--------------Remove um arquivo especifico------------
    public function destroy($id)
    {
        try{
            $repository = Repository::find($id);

            if($repository == null){
                return response()->json(['message' => 'Arquivo não encontrado'], 404);
            }

            //Deleta o icone do arquivo
            Storage::delete('images/' . $repository->icon);

            //Deleta o arquivo
            $repository->delete();

            return response()->json(['message' => 'Arquivo removido com sucesso'], 200);
        }catch(\Exception $e){
            return response()->json(['message' => 'Ocorreu um erro de processamento', 'error' => $e->getMessage()], 500);
        }
    }
}
