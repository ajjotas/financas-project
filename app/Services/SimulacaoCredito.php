<?php
namespace App\Services;

interface SimulacaoCredito
{
    public function simularCredito(float $valorCredito, ?array $instituicoes, ?array $convenios, ?int $parcelas): array;
}