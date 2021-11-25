<?php

namespace Tests\Unit\Requests;

use Illuminate\Http\UploadedFile;

use Tests\TestCase;
use App\Http\Requests\SimulacaoCreditoRequest;

class SimulacaoCreditoRequestTest extends TestCase
{
    /**
     * @test
     * @dataProvider camposInvalidosProvider
     */
    public function rules_camposInvalidos_naoPassaNaValidacao($campos, $erroEsperado)
    {
        $rules = $this->getRules();        
        $validatorFactory = $this->getValidatorFactory();

        $validator = $validatorFactory->make($campos, $rules);
        $validacaoPassou = $validator->passes();
        $errosValidacao = $validator->failed();

        $this->assertFalse($validacaoPassou);
        $this->assertCount(1, $errosValidacao);
        $this->assertArrayHasKey($erroEsperado['input'], $errosValidacao);
        $this->assertCount(1, $errosValidacao[$erroEsperado['input']]);
        $this->assertArrayHasKey($erroEsperado['rule'], $errosValidacao[$erroEsperado['input']]);        
    }

    /**
     * @test
     * @dataProvider camposValidosProvider
     */
    public function rules_camposValidos_passaNaValidacao($campos)
    {
        $rules = $this->getRules();        
        $validatorFactory = $this->getValidatorFactory();

        $validator = $validatorFactory->make($campos, $rules);
        $validacaoPassou = $validator->passes();

        $this->assertTrue($validacaoPassou);        
    }    

    protected function getRules() {
        $request = new SimulacaoCreditoRequest();
        return $request->rules();
    }

    protected function getValidatorFactory() {
        return $this->app['validator'];
    }

    public function camposInvalidosProvider()
    {
        return [
            'sem_valor_emprestimo' => [
                ['valor_emprestimo' => null, 'instituicoes' => [], 'convenios' => [], 'parcela' => 10],
                ['input' => 'valor_emprestimo', 'rule' => 'Required']                
            ],
            'valor_emprestimo_invalido' => [
                ['valor_emprestimo' => 'abc', 'instituicoes' => [], 'convenios' => [], 'parcela' => 10],
                ['input' => 'valor_emprestimo', 'rule' => 'Numeric']                
            ],    
            'instituicoes_invalido' => [
                ['valor_emprestimo' => 500.0, 'instituicoes' => 'abv', 'convenios' => [], 'parcela' => 10],
                ['input' => 'instituicoes', 'rule' => 'Array']                
            ],  
            'convenios_invalido' => [
                ['valor_emprestimo' => 500.0, 'instituicoes' => [], 'convenios' => 'abv', 'parcela' => 10],
                ['input' => 'convenios', 'rule' => 'Array']                
            ],    
            'parcela_invalido' => [
                ['valor_emprestimo' => 500.0, 'instituicoes' => [], 'convenios' => [], 'parcela' => 'abc'],
                ['input' => 'parcela', 'rule' => 'Numeric']                
            ],                                                           
        ];
    }    

    public function camposValidosProvider()
    {             

        return [
            'campos_validos' => [
                ['valor_emprestimo' => 500.0, 'instituicoes' => [], 'convenios' => [], 'parcela' => 10],            
            ],                                                
        ];
    }        


}
