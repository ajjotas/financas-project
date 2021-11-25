<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;

use App\Repository\ConvenioRepository;

class ConvenioController extends Controller
{
    private $convenioRepository;    
  
    public function __construct(ConvenioRepository $convenioRepository)
    {
        $this->convenioRepository = $convenioRepository;
    } 

    public function getAll()
    {
        try {
            return response($this->convenioRepository->all());
        } catch (\Exception $e) {
            return response($e->getMessage(), 500);
        }           
    }
}
