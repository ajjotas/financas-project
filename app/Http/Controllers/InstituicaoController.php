<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Repository\InstituicaoRepository;

class InstituicaoController extends Controller
{
    private $instituicaoRepository;    
  
    public function __construct(InstituicaoRepository $instituicaoRepository)
    {
        $this->instituicaoRepository = $instituicaoRepository;
    } 

    public function getAll()
    {
        try {
            return response($this->instituicaoRepository->all());
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }         
    }
}
