<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Http\Requests\SimulacaoCreditoRequest;
use App\Services\SimulacaoCredito;

class CreditoController extends Controller
{
    private $simulacaoCredito;
  
    public function __construct(SimulacaoCredito $simulacaoCredito)
    {
       $this->simulacaoCredito = $simulacaoCredito;
    } 

    public function simulacaoCredito(SimulacaoCreditoRequest $request)
    {
        try {
            return response($this->simulacaoCredito->simularCredito(
                $request->valor_emprestimo,
                $request->instituicoes,
                $request->convenios,
                $request->parcela
            ));
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }       
    }
}
