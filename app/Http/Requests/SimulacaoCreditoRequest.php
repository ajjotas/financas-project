<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SimulacaoCreditoRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'valor_emprestimo' => 'required|numeric',
            'instituicoes' => 'nullable|array',
            'convenios' => 'nullable|array',
            'parcela' => 'nullable|numeric',
        ];
    }
}
