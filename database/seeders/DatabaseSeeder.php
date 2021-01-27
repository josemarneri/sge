<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
         $this->call([
        UserSeeder::class,
        RoleSeeder::class, 
        RoleUserSeeder::class,
        PermissionSeeder::class,
        FuncaoSeeder::class,
        CargoSeeder::class,
        FuncionarioSeeder::class,
        ClienteSeeder::class,  
        OrcamentoSeeder::class,
        ComessaSeeder::class,
        CargaSeeder::class,
        ProjetoSeeder::class,             
        DesenhoSeeder::class,             
             
    ]);
        
    }
}
