<?php
namespace App\Repository\Json;

use App\Repository\InstituicaoRepository;
use App\Data\Instituicao;

class InstituicaoRepositoryJSONImp implements InstituicaoRepository
{

    const FILENAME = "/json/instituicoes.json";

    public function all(): array
    {
        $registros = $this->lerArquivo();  

        return $this->arrayInstituicoes($registros);
    }

    public function get(array $chaves): array
    {
        $registros = $this->lerArquivo(); 
        $registrosFiltrados = collect($registros)->whereIn('chave', $chaves)->toArray();

        return $this->arrayInstituicoes($registrosFiltrados);
    }    

    private function lerArquivo(): array 
    {
        return json_decode(file_get_contents($this->caminhoArquivo()), true); 
    }

    private function caminhoArquivo(): string
    {
        return storage_path() . self::FILENAME;
    }

    private function arrayInstituicoes(array $registros): array {
        $instituicao = [];
        foreach($registros as $registro) {
            $instituicao[] = $this->registroToInstituicao($registro);
        }

        return $instituicao;
    }

    private function registroToInstituicao(array $registro): Instituicao
    {
        $instituicao = new Instituicao();
        $instituicao->chave = $registro['chave'];
        $instituicao->valor = $registro['valor'];

        return $instituicao;
    }
}