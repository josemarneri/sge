<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Permission;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    use HasFactory;
    protected $fillable = [
      'id','name','label',  
    ];
    public function permissions(){
    	return $this->belongsToMany(Permission::class);
    
    }
    
    public function hasPermission($role_id) {
        if (empty($role_id)) {
            return false;
        }
        $query = "select * from permission_role where role_id = $role_id";
        $permissions = \DB::select($query);
        if(!empty($permissions)){
            return true;
        }
        return false;
    }
    
    public function getPermissions() {
        $permissoes = DB::table('permission_role')
                ->join('permissions', function($join){
                    $join->on('permission_role.permission_id', '=', 'permissions.id')
                            ->where('permission_role.role_id','=', $this->id)
                            ->select('permissions.*');
                })->get();

        return $permissoes;

    }
    
    public function isInUser($user_id) {
        $teste = DB::table('role_user')->where([
                        ['role_id', '=', $this->id],
                        ['user_id', '=', $user_id],                
                    ])->get();

        if(count($teste)>0){
            return true;
        }
        return false;
    }
    
    public function limpaPerfis($user_id) {
        $roles = DB::table('role_user')->where('user_id','=', $user_id)->get();
        //dd($roles, $user_id);
        foreach($roles as $r){            
            DB::table('role_user')->where('id', '=', $r->id)->delete();
        }
    }
    
    public function addPerfis($user_id, $roles_id) {
        if(empty($roles_id)){
            return false;
        }
        foreach($roles_id as $role_id){
            DB::table('role_user')->insert([
                ['role_id' => $role_id, 'user_id' => $user_id]
            ]);            
        }  
        return true;
    }
}
