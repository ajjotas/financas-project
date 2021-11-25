<?php
namespace App\Services;

use App\Repository\ConvenioRepository;
use App\Repository\InstituicaoRepository;
use App\Repository\TaxaInstituicaoRepository;

class SimulacaoCreditoImp implements SimulacaoCredito
{
    private $convenioRepository;
    private $instituicaoRepository;
    private $taxaRepository;

    private $valorCredito;
    private $chavesInstituicoes;
    private $chavesConvenios;
    private $parcela;

    private $convenios;
    private $instituicoes;
    private $taxas;

    public function __construct(InstituicaoRepository $instituicaoRepository, ConvenioRepository $convenioRepository, TaxaInstituicaoRepository $taxaRepository)
    {
        $this->instituicaoRepository = $instituicaoRepository;
        $this->convenioRepository = $convenioRepository; 
        $this->taxaRepository = $taxaRepository;       
    } 

    public function simularCredito(float $valorCredito, ?array $chavesInstituicoes, ?array $chavesConvenios, ?int $parcela): array
    {
        $this->setFiltros($valorCredito, $chavesInstituicoes, $chavesConvenios, $parcela);
        $this->recuperaInformacoes();
       
        return  $this->montaArrayRetorno();
    }

    private function setFiltros(float $valorCredito, ?array $chavesInstituicoes, ?array $chavesConvenios, ?int $parcela)
    {
        $this->valorCredito = $valorCredito;
        $this->chavesInstituicoes = $chavesInstituicoes;
        $this->chavesConvenios = $chavesConvenios;
        $this->parcela = $parcela;
    }

    private function recuperaInformacoes() 
    {
        $this->recuperarConvenios();
        $this->recuperarInstituicoes();
        $this->recuperarTaxas();
    }

    private function recuperarConvenios()
    {
        if ($this->chavesConvenios) {
            $this->convenios = $this->convenioRepository->get($this->chavesConvenios);
        } else {
            $this->convenios = $this->convenioRepository->all();
        }
    }

    private function recuperarInstituicoes()
    {
        if ($this->chavesInstituicoes) {
            $this->instituicoes = $this->instituicaoRepository->get($this->chavesInstituicoes);
        } else {
            $this->instituicoes = $this->instituicaoRepository->all();
        }
    }   
    
    private function recuperarTaxas()
    {
        $this->taxas = collect($this->taxaRepository->get($this->chavesInstituicoes, $this->chavesConvenios, $this->parcela));
    }  
    
    private function montaArrayRetorno() 
    {
        $resultado = [];
        foreach($this->instituicoes as $instituicao) 
        {
            $informacoes = $this->montaInformacoesInstituicao($instituicao->chave);
            $resultado[$instituicao->valor] = $informacoes;
        }

        return $resultado;
    }

    private function montaInformacoesInstituicao(string $instituicaoChave)
    {
        $informacoes = [];
        $informacoesTaxas = $this->taxas->where('idInstituicao', $instituicaoChave);

        foreach($informacoesTaxas as $informacaoTaxa) {
            $informacoes[] = [
                'taxa' => $informacaoTaxa->taxaJuros,
                'parcelas' => $informacaoTaxa->parcelas,
                'valor_parcela' => $this->valorCredito * $informacaoTaxa->coeficiente,
                'convenio' => $informacaoTaxa->idConvenio,
            ];
        }     

        return $informacoes;
    }
}