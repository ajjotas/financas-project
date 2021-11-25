<?php
namespace App\Repository;

interface TaxaInstituicaoRepository
{
    public function all(): array;

    public function get(?array $chavesInstituicoes, ?array $chavesConvenios, ?int $parcela): array;    
}