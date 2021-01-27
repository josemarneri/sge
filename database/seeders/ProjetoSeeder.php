<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Projeto;

class ProjetoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $projeto = new Projeto();
         
        if (count($projeto->all())<1){
            $projetos[] = ['id'=> null, 'codigo'=>'NSD_001', 
                'descricao'=> 'Teste de sistema', 'observacoes'=> 'teste',
                'comessa_id'=> null];

            
            foreach($projetos as $p){
                $projeto->create($p);
            }
        }
    }
}

