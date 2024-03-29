<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Users;

/**
 * @OA\Tag(
 *      name="Autenticação",
 *      description="Esta seção oferece acesso a operações relacionadas a autenticação de usuários no sistema da Rede Akiba.",
 * )
 */

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/login",
     *     summary="Autentica o usuário",
     *     description="Esse endpoint autentica o usuário na Rede Akiba e retorna um token de acesso.",
     *     tags={"Autenticação"},
     *     @OA\RequestBody(
     *         description="Credencias de acesso do usuário",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"login","password"},
     *             @OA\Property(property="login", type="string"),
     *             @OA\Property(property="password", type="string"),
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Erro de autenticação",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object", 
     *                 @OA\Property(property="login", type="array", 
     *                     @OA\Items(type="string", example="Credenciais inválidas.")
     *                 )
     *             )
     *         )
     *     ),
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);

        $user = Users::where('login', $request->login)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'login' => ['Credenciais inválidas.'],
            ]);
        }

        $token = $user->createToken('laravel-token')->plainTextToken;

        $response = [
            'token' => $token,
        ];

        return response($response, 200);
    }

    /**
     * @OA\Get(
     *     path="/api/verificarlogin",
     *     summary="Verifica o login",
     *     description="Esse endpoint verifica se o usuário está autenticado para acessar as aplicações da Rede Akiba.",
     *     tags={"Autenticação"},
     *     @OA\Response(
     *         response=200,
     *         description="Usuário logado e dados encontrados",
     *         @OA\JsonContent(ref="#/components/schemas/UserResponse")
     *     ),
     * )
     */
    public function verifyLogin(Request $request)
    {
        // Verifique se o usuário está autenticado
        $user = $request->user();
        if (!$user) {
            return response()->json(['error' => 'Token de autenticação não fornecido ou inválido.'], Response::HTTP_UNAUTHORIZED);
        }
    
        // Se o usuário estiver autenticado, retorne seus detalhes junto com a confirmação de login
        return response()->json([
            'message' => 'Usuário autenticado e detalhes encontrados.',
            'user' => $user
        ], Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/deslogar",
     *     summary="Desloga o usuário",
     *     description="Este endpoint desloga o usuário de todas as aplicações da Rede Akiba.",
     *     tags={"Autenticação"},
     *     @OA\Response(
     *         response=200,
     *         description="Usuário deslogado com sucesso.",
     *         @OA\JsonContent(
     *             type="string",
     *             example="Deslogado com sucesso."
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Não autorizado - Token de acesso não fornecido ou inválido."
     *     ),
     * )
     */
    public function logout(Request $request)
    {
        // Verifica se há um usuário autenticado com token
        if ($user = $request->user()) {
            // Invalida o token atual
            $user->currentAccessToken()->delete();
    
            // Retorna uma resposta indicando o logout bem-sucedido
            return response()->json('Deslogado com sucesso.', 200);
        }
    
        // Se não houver um usuário autenticado, retorna uma resposta genérica.
        // Isso evita expor se um token era válido ou não, mantendo a abordagem segura e consistente.
        return response()->json('Nenhuma sessão ativa encontrada ou já deslogado.', 200);
    }
}