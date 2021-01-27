<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\post;
use Illuminate\Support\Facades\Gate;

class SiteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(post $post)
    {
    	//$posts = $post->all();
        //phpinfo();
    	$posts = $post->where('user_id',auth()->user()->id)->get();
        return view('home', compact('posts'));
        //return 'index SiteController';
    }
    
    public function update($idpost)
    {
    	$post=post::find($idpost);
    	
    	//$this->authorize('update-notice',$notice);
    	if (Gate::denies('edit_post', $post)){
    		abort(403, 'Nao autorizado');
    	}
    	
    	return view('update-post',compact('post'));
    }
    
    public function rolesPermissions(){
    	$nameUser = auth()->user()->name;
    	echo("<h1>$nameUser</h1>");
    	$passwd = auth()->user()->getAuthPassword();
    	foreach (auth()->user()->roles as $role){
    		echo("<h2> $role->name </h2> <br>");
    		foreach ($role->permissions as $permission){
    			echo("<h3> $permission->name </h3> <br>");
    		}
    		echo("<hr>");
    	}
    	
    	return $nameUser.' : '.$passwd;
    }
}
