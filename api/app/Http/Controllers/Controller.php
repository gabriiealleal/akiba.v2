<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *      title="Rede Akiba API REST",
 *      description="Esta documentação descreve as todas as operações disponíveis para as aplicações da Rede Akiba.",
 *      version="1.0.0",
 *      @OA\Contact(
 *          email="contato@redeakiba.com.br"
 *      ),
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
