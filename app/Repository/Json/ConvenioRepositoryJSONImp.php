<?php
namespace App\Repository\Json;

use App\Repository\ConvenioRepository;
use App\Data\Convenio;

class ConvenioRepositoryJSONImp implements ConvenioRepository
{

    const FILENAME = "/json/convenios.json";

    public function all(): array
    {
        $registros = $this->lerArquivo(); 

        return $this->arrayConvenios($registros);
    }

    public function get(array $chaves): array
    {
        $registros = $this->lerArquivo(); 
        $registrosFiltrados = collect($registros)->whereIn('chave', $chaves)->toArray();

        return $this->arrayConvenios($registrosFiltrados);
    }    

    private function lerArquivo(): array 
    {
        return json_decode(file_get_contents($this->caminhoArquivo()), true); 
    }

    private function caminhoArquivo(): string
    {
        return storage_path() . self::FILENAME;
    }

    private function arrayConvenios(array $registros): array {
        $convenios = [];
        foreach($registros as $registro) {
            $convenios[] = $this->registroToConvenio($registro);
        }

        return $convenios;
    }

    private function registroToConvenio(array $registro): Convenio
    {
        $convenio = new Convenio();
        $convenio->chave = $registro['chave'];
        $convenio->valor = $registro['valor'];

        return $convenio;
    }
}