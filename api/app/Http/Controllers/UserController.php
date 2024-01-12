<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request; 

/**
 * @OA\Tag(
 *      name="Usuários",
 *      description="Gerenciamento de Usuários: Esta seção oferece acesso a operações relacionadas à administração, criação, atualização e exclusão de usuários no sistema da Rede Akiba."
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
            return response()->json($users, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Ocorreu um problema de processamento', 'message' => $e->getMessage()], 500);
        }
    }

    //Retorna um usuário específico
    public function store(Request $request)
    {
        //
    }

    //Cria um novo usuário
    public function show($id)
    {
        //
    }

    //Atualiza um usuário específico
    public function update(Request $request, $id)
    {
        //
    }

    //Remove um usuário específico
    public function destroy($id)
    {
        //
    }
}
