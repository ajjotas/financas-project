<?php
namespace App\Repository;

interface InstituicaoRepository
{
    public function all(): array;

    public function get(array $chaves): array;    
}