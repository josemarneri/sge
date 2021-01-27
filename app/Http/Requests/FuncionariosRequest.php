<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FuncionariosRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
            'id' => 'required|numeric',
            'nome'=> 'required|max:50',
            'endereco'=> 'max:50',
            'telefone'=> 'max:15',
            'email' => 'max:50',
            'user_id' => 'numeric',           
            'ativo' => 'boolean',
        ];
    }
    
    public function messages() {
        //parent::messages();
        
        return [
            'id' => [
                'required' => 'o campo :attribute deve ser preenchido',
                'numeric' => 'o campo :attribute só pode conter numeros',
            ],
            'ativo' => [
                'boolean' => 'o campo :attribute só aceita 0 ou 1',                
            ],
        ];
    }
}
