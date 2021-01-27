<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Permission extends Model
{
    use HasFactory;
        protected $fillable = [
        'id','name','label',
    ];
    public function roles(){
		return $this->belongsToMany(\App\Models\Role::class);
    }
    
    public function limpaPermissoes($role_id) {
        $permissoes = DB::table('permission_role')->where('role_id','=', $role_id)->get();
        $permissao = new Permission();
        foreach($permissoes as $p){            
            DB::table('permission_role')->where('permission_id', '=', $p->permission_id)->delete();
        }
    }
    
    public function addPermissoes($role_id, $permissions_id) {
        //dd($role_id,$permissoes);
        if(empty($permissions_id)){
            return false;
        }
        foreach($permissions_id as $permissao_id){
            DB::table('permission_role')->insert([
                ['permission_id' => $permissao_id, 'role_id' => $role_id]
            ]);            
        }  
        return true;
    }
    
    public function isInRole($role_id) {
        $teste = DB::table('permission_role')->where([
                        ['permission_id', '=', $this->id],
                        ['role_id', '=', $role_id],                
                    ])->get();
        if(count($teste)>0){
            return true;
        }
        return false;
    }
}
