<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Funcao;

class FuncaoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $funcao = new Funcao();
        if (count($funcao->all())<1){            
            $funcoes[] = ['id'=> null, 'nome'=>'Gerente'];
            $funcoes[] = ['id'=> null, 'nome'=>'Coordenador'];
            $funcoes[] = ['id'=> null, 'nome'=>'Projetista'];
            $funcoes[] = ['id'=> null, 'nome'=>'Administrativo'];
            
            foreach($funcoes as $f){
                $funcao->create($f);
            }
        }            
    }
}
