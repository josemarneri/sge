<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Comessa;

class ComessaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $hoje = new \DateTime();
        $data = $hoje->format('Y-m-d');
        $comessa = new Comessa();
        if (count($comessa->all())<1){
            $comessas[] = ['id'=> null,'orcamento_id'=> 1 , 'codigo'=> 'NSD.1.1' , 'descricao'=>'Faltas ou atrasos',
                'n_horas'=> 1000 , 'data_inicio'=> $data, 'data_fim'=> '2021-12-31', 'gerente_id'=>12,
                'coordenador_id' => null, 'ativa' => true];
            $comessas[] = ['id'=> null,'orcamento_id'=> 1 , 'codigo'=> 'NSD.1.2' , 'descricao'=>'Atestado',
                'n_horas'=> 1000 , 'data_inicio'=> $data, 'data_fim'=> '2021-12-31', 'gerente_id'=>12,
                'coordenador_id' => null, 'ativa' => true];
            $comessas[] = ['id'=> null,'orcamento_id'=> 1 , 'codigo'=> 'NSD.1.3' , 'descricao'=>'Banco de horas',
                'n_horas'=> 2000 , 'data_inicio'=> $data, 'data_fim'=> '2021-12-31', 'gerente_id'=>12,
                'coordenador_id' => null, 'ativa' => true];
            $comessas[] = ['id'=> null,'orcamento_id'=> 1 , 'codigo'=> 'NSD.1.4' , 'descricao'=>'Sem atividade',
                'n_horas'=> 1000 , 'data_inicio'=> $data, 'data_fim'=> '2021-12-31', 'gerente_id'=>12,
                'coordenador_id' => null, 'ativa' => true];
            
            foreach($comessas as $c){
                $comessa->create($c);
            }
        }
    }
}
