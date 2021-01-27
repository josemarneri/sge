<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        $role = new Role();
        if (count($role->all())<1){
            $roles[] = ['id'=>null, 'name'=> 'admin','label'=>'Administrador do sistema'];
            $roles[] = ['id'=>null, 'name'=> 'admin-financeiro','label'=>'Administrador do financeiro'];
            $roles[] = ['id'=>null, 'name'=> 'admin-rh','label'=>'Administrador do RH'];
            $roles[] = ['id'=>null, 'name'=> 'admin-engenharia','label'=>'Administrador da Engenharia'];
            $roles[] = ['id'=>null, 'name'=> 'admin-ti','label'=>'Administrador de TI'];
            $roles[] = ['id'=>null, 'name'=> 'engenharia','label'=>'Funcionários da engenharia'];
            $roles[] = ['id'=>null, 'name'=> 'coordenador','label'=>'Coordenadores da engenharia'];
            $roles[] = ['id'=>null, 'name'=> 'financeiro','label'=>'Funcionários do financeiro'];
            $roles[] = ['id'=>null, 'name'=> 'rh','label'=>'Funcionários do RH'];
            $roles[] = ['id'=>null, 'name'=> 'ti','label'=>'Funcionários do TI'];
            $roles[] = ['id'=>null, 'name'=> 'padrao','label'=>'Padrão mínimo de acesso'];
            
            foreach($roles as $r){
                $role->create($r);
            }
            
        }         
    
    }
}
