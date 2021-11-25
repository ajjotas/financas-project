<?php
namespace App\Repository\Json;

use App\Repository\TaxaInstituicaoRepository;
use App\Data\TaxaInstituicao;

class TaxaInstituicaoRepositoryJSONImp implements TaxaInstituicaoRepository
{

    const FILENAME = "/json/taxas_instituicoes.json";

    public function all(): array
    {
        $registros = $this->lerArquivo();  

        return $this->arrayTaxasInstituicoes($registros);
    }

    public function get(?array $chavesInstituicoes, ?array $chavesConvenios, ?int $parcela): array 
    {
        $registros = $this->lerArquivo(); 
        $registrosFiltrados = collect($registros);
        
        if (!is_null($parcela)) {
            $registrosFiltrados = $registrosFiltrados->where('parcelas', '>=', $parcela);
        } 
        if (!is_null($chavesInstituicoes)) {
            $registrosFiltrados = $registrosFiltrados->whereIn('instituicao', $chavesInstituicoes);
        } 
        if (!is_null($chavesConvenios)) {
            $registrosFiltrados = $registrosFiltrados->whereIn('convenio', $chavesConvenios);
        }         

        return $this->arrayTaxasInstituicoes($registrosFiltrados->toArray());
    }  

    private function lerArquivo(): array 
    {
        return json_decode(file_get_contents($this->caminhoArquivo()), true); 
    }

    private function caminhoArquivo(): string
    {
        return storage_path() . self::FILENAME;
    }

    private function arrayTaxasInstituicoes(array $registros): array {
        $taxasInstituicoes = [];
        foreach($registros as $registro) {
            $taxasInstituicoes[] = $this->registroToTaxaInstituicao($registro);
        }

        return $taxasInstituicoes;
    }

    private function registroToTaxaInstituicao(array $registro): TaxaInstituicao
    {
        $taxaInstituicao = new TaxaInstituicao();

        $taxaInstituicao->parcelas = $registro['parcelas'];
        $taxaInstituicao->taxaJuros = $registro['taxaJuros'];
        $taxaInstituicao->coeficiente = $registro['coeficiente'];
        $taxaInstituicao->idInstituicao = $registro['instituicao'];
        $taxaInstituicao->idConvenio = $registro['convenio'];

        return $taxaInstituicao;
    }
}