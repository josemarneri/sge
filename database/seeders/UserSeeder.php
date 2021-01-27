<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        if (!$user->find(1)){
            $user->id = 1;
            $user->name = 'Administrador';
            $user->login = 'admin';
            $user->ativo = 1;
            $user->email = 'josemar.neri@yahoo.com.br';
            $user->password = bcrypt('admin');
            $user->remember_token = bcrypt(csrf_token());
            $user->save();
            
            $user2 = new User();
            $user2->id = 2;
            $user2->name = 'Nulo';
            $user2->login = 'Nulo';
            $user2->ativo = 1;
            $user2->email = 'nulo@xx.br';
            $user2->password = bcrypt('123');
            $user2->remember_token = bcrypt(csrf_token());
            $user2->save();
            
            $user2 = new User();
            $user2->id = 3;
            $user2->name = 'Josemar da Silva Neri';
            $user2->login = 'josemar';
            $user2->ativo = 1;
            $user2->email = 'josemar.neri@gmail.com';
            $user2->password = bcrypt('123');
            $user2->remember_token = bcrypt(csrf_token());
            $user2->save();
            
            $user2 = new User();
            $user2->id = 4;
            $user2->name = 'Fulano';
            $user2->login = 'fulano';
            $user2->ativo = 1;
            $user2->email = 'fulano@xxxx.br';
            $user2->password = bcrypt('123');
            $user2->remember_token = bcrypt(csrf_token());
            $user2->save();
            
            $user2 = new User();
            $user2->id = 5;
            $user2->name = 'Ciclano';
            $user2->login = 'ciclano';
            $user2->ativo = 1;
            $user2->email = 'ciclano@xxxx.br';
            $user2->password = bcrypt('123');
            $user2->remember_token = bcrypt(csrf_token());
            $user2->save();
            
            
        }
        
    }
}
