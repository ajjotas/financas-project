<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Repository\ConvenioRepository;
use App\Repository\Json\ConvenioRepositoryJSONImp;
use App\Repository\InstituicaoRepository;
use App\Repository\Json\InstituicaoRepositoryJSONImp;
use App\Repository\TaxaInstituicaoRepository;
use App\Repository\Json\TaxaInstituicaoRepositoryJSONImp;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(ConvenioRepository::class, ConvenioRepositoryJSONImp::class);
        $this->app->bind(InstituicaoRepository::class, InstituicaoRepositoryJSONImp::class);         
        $this->app->bind(TaxaInstituicaoRepository::class, TaxaInstituicaoRepositoryJSONImp::class);            
    }

    public function boot()
    {
    }
}
