<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Contracts\Auth\Access\Gate as GateContract;
//use Illuminate\Auth\Access\Gate;

use App\Models\User;
use App\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        \App\Models\User::class => \App\Policies\UserPolicy::class,
        \App\Models\Funcionario::class => \App\Policies\FuncionarioPolicy::class,
        \App\Models\Atividade::class => \App\Policies\AtividadePolicy::class,
        \App\Models\Carga::class => \App\Policies\CargaPolicy::class,
        \App\Models\Cargo::class => \App\Policies\CargoPolicy::class,
        \App\Models\Comessa::class => \App\Policies\ComessaPolicy::class,
        \App\Models\ferias::class => \App\Policies\FeriasPolicy::class,
        \App\Models\Funcao::class => \App\Policies\FuncaoPolicy::class,
        \App\Models\Orcamento::class => \App\Policies\OrcamentoPolicy::class,
        \App\Models\Permission::class => \App\Policies\PermissionPolicy::class,
        \App\Models\Proposta::class => \App\Policies\PropostaPolicy::class,
        \App\Models\Rdp::class => \App\Policies\RdpPolicy::class,
        \App\Models\Role::class => \App\Policies\RolePolicy::class,
        \App\Models\Desenho::class => \App\Policies\DesenhoPolicy::class,
        \App\Models\Projeto::class => \App\Policies\ProjetoPolicy::class,
        \App\Models\Diariodebordo::class => \App\Policies\DiariodebordoPolicy::class,
        
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot(GateContract $gate)
    {
        //*
        $this->registerPolicies($gate);
            $permissions = Permission::with('roles')->get();
            foreach ($permissions as $permission){
        	$gate->define($permission->name, function(User $user) use ($permission){
        		return $user->hasPermission($permission);
        	});        	 
            }

            //dd('1');

        $gate->before(function(User $user, $ability){
            if ($user->hasAnyRoles('admin')){
                return true;
            }
        });
         
         //*/
    }
}