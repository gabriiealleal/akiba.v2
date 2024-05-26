<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\JsonResponse;
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
     *     path="/login",
     *     summary="Autentica o usuário",
     *     description="Esse endpoint autentica o usuário na Rede Akiba e retorna um token de acesso.",
     *     tags={"Autenticação"},
     *     @OA\RequestBody(
     *         description="Credenciais de acesso do usuário",
     *         required=true,
     *         @OA\JsonContent(
     *             required={"login", "password"},
     *             @OA\Property(property="login", type="string", description="Login do usuário"),
     *             @OA\Property(property="password", type="string", description="Senha do usuário")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Logado com sucesso",
     *         @OA\JsonContent(
     *             @OA\Property(property="token", type="string", description="Token de acesso do usuário")
     *         )
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Credenciais inválidas",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Credenciais inválidas.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=403,
     *         description="Conta desativada",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Esta conta está desativada.")
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados de entrada inválidos",
     *         @OA\JsonContent(
     *             @OA\Property(property="errors", type="object",
     *                 @OA\Property(property="login", type="array",
     *                     @OA\Items(type="string", example="O campo login é obrigatório.")
     *                 ),
     *                 @OA\Property(property="password", type="array",
     *                     @OA\Items(type="string", example="O campo senha é obrigatório.")
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function login(Request $request)
    {
        $request->validate([
            'login' => 'required',
            'password' => 'required',
        ]);
    
        $user = Users::where('login', $request->login)->first();
    
        // Primeiro, verifique se o usuário existe
        if (!$user) {
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401); // 401 é o código de status para "Não autorizado"
        }
    
        // Verifique se o usuário está desligado
        if ($user->is_active === 0) {
            return response()->json([
                'message' => 'Esta conta está desativada'
            ], 403); // 403 é o código de status para "Proibido"
        }
    
        // Em seguida, verifique se a senha está correta
        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Credenciais inválidas.'
            ], 401);
        }
    
        // Se tudo estiver correto, crie e retorne o token
        $token = $user->createToken($user->name.' - AuthToken')->plainTextToken;
    
        return response()->json([
            'access_token' => $token,
        ]);
    }

    /**
     * @OA\Get(
     *     path="/verificarlogin",
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
        // Tenta autenticar o usuário com o middleware 'auth:sanctum'
        $user = $request->user('sanctum');
    
        // Verifique se o usuário está autenticado
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
     *     path="/deslogar",
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