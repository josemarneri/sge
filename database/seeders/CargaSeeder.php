<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Funcionario;
use App\Models\Carga;

class CargaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $funcionarios = Funcionario::all();
        $carga = new Carga();
        $hoje = new \DateTime();
        $data = $hoje->format('Y-m-d');
        foreach($funcionarios as $f){
            if(!Carga::where('funcionario_id','=',$f->id)->get()->first()){
                $array = [ 'funcionario_id'=>$f->id, 'comessa_id'=> 4, 
                    'data_inicio' => $data,'data_fim'=>null, 'livre' => true];
                $carga->create($array);
            }
            
        }
    }
}
