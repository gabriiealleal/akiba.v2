<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request; 
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

/**
 * @OA\Tag(
 *      name="Usuários",
 *      description="Esta seção oferece acesso a operações relacionadas aos usuários cadastrados no sistema da Rede Akiba."
 * )
 */

class UserController extends Controller
{
    /*******Retorna todos os usuários*******/

    /**
     * @OA\Get(
     *      path="/api/usuarios",
     *      tags={"Usuários"},
     *      description="Este endpoint retorna uma lista completa de todos os usuários cadastrados no sistema da Rede Akiba.",
     *      summary="Retorna todos os usuários cadastrados",
     *      @OA\Response(
     *          response=200,
     *          description="Lista de usuários cadastrados",
     *          @OA\JsonContent(ref="#/components/schemas/UserResponse"),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Nenhum usuário encontrado",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Nenhum usuário encontrado"),
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um problema de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de processamento"),
     *          ),
     *      ),
     * )
     */
    public function index()
    {
        try {
            $users = User::all();
            if ($users->isEmpty()) {
                return response()->json(['error' => 'Nenhum usuário encontrado'], 404);
            }
            return response()->json(['message' => 'Lista de usuários cadastrados', 'usuários' => $users], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /*******Cria um novo usuário*******/

    /**
     * @OA\Post(
     *      path="/api/usuarios",
     *      tags={"Usuários"},
     *      description="Este endpoint cria um novo usuário no sistema da Rede Akiba.",
     *      summary="Cria um novo usuário",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Usuário criado",
     *          @OA\JsonContent(ref="#/components/schemas/UserResponse"),
     *      ),
     *      @OA\Response(
     *          response=400,
     *          description="Ocorreu um problema de validação",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de validação"),
     *              @OA\Property(property="messages", type="array", @OA\Items(type="string"), example={"O campo login é obrigatório", "O campo senha é obrigatório", "A senha deve ter no mínimo 6 caracteres", "O e-mail informado já está em uso", "O arquivo enviado não é uma imagem válida"})
     *          ),
     *      ),
     *      @OA\Response(
     *          response=500,
     *          description="Ocorreu um problema de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de processamento"),
     *          ),
     *      ),
     * )
     */
    public function store(Request $request)
    {
        try{
            $messages = [
                'login.required' => 'O campo login é obrigatório',
                'login.unique' => 'O login informado já está em uso',
                'password.required' => 'O campo senha é obrigatório',
                'password.min' => 'A senha deve ter no mínimo 6 caracteres',
                'email.unique' => 'O e-mail informado já está em uso',
                'avatar.file' => 'O arquivo enviado não é válido',
                'avatar.image' => 'O arquivo enviado não é uma imagem válida',
            ];

            $validator = $request->validate([
                'login' => 'required|unique:users',
                'password' => 'required|min:6',
                'email' => 'nullable|unique:users',
                'avatar' => 'nullable|file|image'
            ], $messages);

            $filename = 'default-avatar.jpg'; // substitua por seu avatar padrão
            if($request->hasFile('avatar')){
                $avatar = $request->file('avatar');
                $filename = time().'.'.$avatar -> getClientOriginalExtension();
                $location = public_path('images/'.$filename);
                Image::make($avatar) -> save($location);
            }

            $user = new User;
            $user -> slug = Str::slug($request->nickname);
            $user -> is_active = true;
            $user -> access_levels = $request -> access_levels;
            $user -> login = $request -> login;
            $user -> password = Hash::make($request -> password);
            $user -> avatar = $filename;
            $user -> name = $request -> name;
            $user -> nickname = $request -> nickname;
            $user -> email = $request -> email;
            $user -> age = $request -> age;
            $user -> city = $request -> city;
            $user -> state = $request -> state;
            $user -> country = $request -> country;
            $user -> biography = $request -> biography;
            $user -> social_networks = $request -> social_networks;
            $user -> likes = $request -> likes;

            $user->save();
            return response()->json(['message' => 'Usuário criado', 'usuário' => $user], 200);
        }catch (ValidationException $e) {
            return response()->json(['error' => 'Ocorreu um problema de validação', 'messages' => $e->validator->errors()], 400);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /*******Retorna um usuário especifico*******/

    /**
     * @OA\Get(
     *      path="/api/usuarios/{slug}",
     *      tags={"Usuários"},
     *      description="Este endpoint retorna um usuário específico cadastrado no sistema da Rede Akiba.",
     *      summary="Retorna um usuário específico",
     *      @OA\Parameter(
     *          name="slug",
     *          description="Slug do Usuário: Retorna um usuário baseado no slug fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="string"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Usuário encontrado",
     *          @OA\JsonContent(ref="#/components/schemas/UserResponse"),
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
     *          description="Ocorreu um problema de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de processamento"),
     *          ),
     *      ),
     * )
     */

    public function show($slug)
    {
        try{
            $user = User::where('slug', $slug)->first();

            if(!$user){
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }

            return response()->json(['message' => 'Usuário encontrado', 'usuário' => $user], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /*******Atualiza um usuário especifico*******/

    /**
     * @OA\Patch(
     *      path="/api/usuarios/{id}",
     *      tags={"Usuários"},
     *      description="Este endpoint atualiza parcialmente um usuário específico cadastrado no sistema da Rede Akiba.",
     *      summary="Atualiza parcialmente um usuário específico",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Usuário: Atualiza parcialmente um usuário baseado no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UserRequest"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Usuário atualizado",
     *          @OA\JsonContent(ref="#/components/schemas/UserResponse"),
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
     *          description="Ocorreu um problema de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de processamento"),
     *          ),
     *      ),
     * )
     */
    public function update(Request $request, $id)
    {
        try{
            $user = User::find($id);
    
            if(!$user){
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }
    
            if($request->hasFile('avatar')){
                //Deleta o avatar antigo
                Storage::delete('public/images/'.$user->avatar);

                //Salva o novo avatar
                $avatar = $request->file('avatar');
                $filename = time().'.'.$avatar -> getClientOriginalExtension();
                $location = public_path('images/'.$filename);
                Image::make($avatar) -> save($location);
                $user->avatar = $filename;
            }
    
            if($request->has('nickname')){
                $user->slug = Str::slug($request->nickname);
                $user->nickname = $request->nickname;
            }
    
            if($request->has('access_levels')){
                $user->access_levels = $request->access_levels;
            }
    
            if($request->has('login')){
                $user->login = $request->login;
            }
    
            if($request->has('password')){
                $user->password = Hash::make($request->password);
            }
    
            if($request->has('name')){
                $user->name = $request->name;
            }
    
            if($request->has('email')){
                $user->email = $request->email;
            }
    
            if($request->has('age')){
                $user->age = $request->age;
            }
    
            if($request->has('city')){
                $user->city = $request->city;
            }
    
            if($request->has('state')){
                $user->state = $request->state;
            }
    
            if($request->has('country')){
                $user->country = $request->country;
            }
    
            if($request->has('biography')){
                $user->biography = $request->biography;
            }
    
            if($request->has('social_networks')){
                $user->social_networks = $request->social_networks;
            }
    
            if($request->has('likes')){
                $user->likes = $request->likes;
            }
    
            $user->save();
            return response()->json(['message' => 'Usuário atualizado', 'usuário' => $user], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    /*******Remove um usuário*******/

    /**
     * @OA\Delete(
     *      path="/api/usuarios/{id}",
     *      tags={"Usuários"},
     *      description="Este endpoint remove um usuário específico cadastrado no sistema da Rede Akiba.",
     *      summary="Remove um usuário específico",
     *      @OA\Parameter(
     *          name="id",
     *          description="Id do Usuário: Remove um usuário baseado no id fornecido.",
     *          required=true,
     *          in="path",
     *          @OA\Schema(type="integer"),
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Usuário removido",
     *          @OA\JsonContent(
     *              @OA\Property(property="message", type="string", example="Usuário removido"),
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
     *          description="Ocorreu um problema de processamento",
     *          @OA\JsonContent(
     *              @OA\Property(property="error", type="string", example="Ocorreu um problema de processamento"),
     *          ),
     *      ),
     * )
     */
    public function destroy($id)
    {
        try{
            $user = User::find($id);

            if(!$user){
                return response()->json(['error' => 'Usuário não encontrado'], 404);
            }

            //Deleta o avatar
            Storage::delete('public/images/'.$user->avatar);
            
            $user->delete();
            return response()->json(['message' => 'Usuário removido'], 200);
        }catch(\Exception $e){
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }
}
