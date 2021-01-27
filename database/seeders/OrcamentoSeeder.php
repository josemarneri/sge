<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Orcamento;

class OrcamentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $orcamento = new Orcamento();
        if (count($orcamento->all())<1){
            $orcamentos[] = ['id'=> null, 'cliente_id'=> 1 , 'descricao'=>'Administrativo',
                'status'=> 'Aprovado', 'pedido'=> null, 'anexo_id'=> null];
            
            foreach($orcamentos as $c){
                $orcamento->create($c);
            }
        }
    }
}