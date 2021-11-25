<?php
namespace App\Repository;

interface ConvenioRepository
{
    public function all(): array;

    public function get(array $chaves): array;        
}