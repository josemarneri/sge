<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roleUsers = DB::select('select * from role_user where id=1');
        if (count($roleUsers)<1){
            DB::insert('insert into role_user '
                . '(id,user_id, role_id)'
                . 'values(?,?,?)', 
                array(1,1,1));
            DB::insert('insert into role_user '
                . '(user_id, role_id)'
                . 'values(?,?)', 
                array(3,1));
            
        }
        
    }
}
