<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Services\SimulacaoCredito;
use App\Services\SimulacaoCreditoImp;

class ServicesServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->bind(SimulacaoCredito::class, SimulacaoCreditoImp::class);           
    }

    public function boot()
    {
    }
}
