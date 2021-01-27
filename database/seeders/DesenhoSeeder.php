<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Desenho;

class DesenhoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $desenho = new Desenho();
        
        if (count($desenho->all())<1){
            $desenhos[] = ['id'=>null, 'pai'=>null, 'descricao'=> 'Complessivo Escotilha','material'=> 'Plástico',
                'peso'=> '30','tratamento'=> 'Pintura', 'user_id'=> 1 , 'projeto_id'=>1];
            echo 'Desenho criado';
            $desenhos[] = ['id'=>null,'pai'=>null,
                'descricao'=> 'Mecanismo Fixo de Abertura da Escotilha','material'=> 'Aço','peso'=> '3','tratamento'=> 'Pintura',
                'user_id'=> 1 , 'projeto_id'=>1];
            echo 'Desenho criado';
            $desenhos[] = ['id'=>null,'pai'=>null,
                'descricao'=> 'Disco do Mecanismo','material'=> 'Plástico','peso'=> '0.2','tratamento'=> 'Pintura',
                'user_id'=> 3 , 'projeto_id'=>1];
            echo 'Desenho criado';
            
            foreach($desenhos as $c){
                $desenho = new Desenho();
                $desenho->fill($c);
                $desenho->save();
            }
        }
    }
}
