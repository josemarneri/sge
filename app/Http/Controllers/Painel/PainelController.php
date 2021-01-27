<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Permission;
use App\Models\Role;
use App\Models\post;

class PainelController extends Controller
{
    //
    
    public function index() {
        $totalUsers = User::count();
        $totalRoles = Role::count();
        $totalPermissions = Permission::count();
        $totalPosts = post::count();
        return view('painel.home.index', compact('totalUsers','totalRoles','totalPermissions','totalPosts'));
    }
    
    public function testes() {
        dd(auth()->user()->toArray());
        return 'Testes';
    }
}
