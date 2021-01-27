<?php

namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Cargo;

class CargoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cargo = new Cargo();
        if (count($cargo->all())<1){
            $cargos[] = ['id'=> null, 'nome'=>'Estágiario'];
            $cargos[] = ['id'=> null, 'nome'=>'Desenhista Junior'];
            $cargos[] = ['id'=> null, 'nome'=>'Desenhista Pleno'];
            $cargos[] = ['id'=> null, 'nome'=>'Desenhista Senior'];
            $cargos[] = ['id'=> null, 'nome'=>'Projetista Junior'];
            $cargos[] = ['id'=> null, 'nome'=>'Projetista Pleno'];
            $cargos[] = ['id'=> null, 'nome'=>'Projetista Senior'];
            $cargos[] = ['id'=> null, 'nome'=>'Projetista Master'];
            
            foreach($cargos as $c){
                $cargo->create($c);
            }
        }
    }
}
