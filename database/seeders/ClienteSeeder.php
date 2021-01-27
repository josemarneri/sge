<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {       
        $cliente = new Cliente();
        if (count($cliente->all())<1){
            $clientes[] = ['id'=> null, 'nome'=>'NSD ', 'sigla'=>'NSD'];
            $clientes[] = ['id'=> null, 'nome'=>'NSD Industrial ', 'sigla'=>'NSDi'];
            $clientes[] = ['id'=> null, 'nome'=>'FCA Group S/A', 'sigla'=>'FCA'];
            $clientes[] = ['id'=> null, 'nome'=>'Renault S/A', 'sigla'=>'RNT'];
            $clientes[] = ['id'=> null, 'nome'=>'Analitica Engenharia', 'sigla'=>'AE'];
            $clientes[] = ['id'=> null, 'nome'=>'Brose', 'sigla'=>'BRO'];
            $clientes[] = ['id'=> null, 'nome'=>'CNHi', 'sigla'=>'CNHi'];
            $clientes[] = ['id'=> null, 'nome'=>'Cooperstandard', 'sigla'=>'COOP'];
            
            foreach($clientes as $c){
                $cliente->create($c);
            }
        }
    }
}
