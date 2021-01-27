<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Funcionario;

class FuncionarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (!Funcionario::find(12)){
            $funcionario = new Funcionario();
            $funcionario->nome = 'Josemar Neri';
            $funcionario->id = 12;
            $funcionario->email = 'josemar.neri@nsdproject.com.br';
            $funcionario->endereco = '';
            $funcionario->telefone = '31995501667';
            $funcionario->user_id = 3;
            $funcionario->funcao_id = 1;
            $funcionario->ativo = TRUE;
            $funcionario->save();
        }
    }
}
