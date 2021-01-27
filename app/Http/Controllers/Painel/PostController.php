<?php

namespace App\Http\Controllers\Painel;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\post;

class PostController extends Controller
{
    //
    private $post;
    
    public function __construct(post $post){
        $this->post = $post;
       // $this->filter('before','post_id')->only(array('post','apagar'));
    }
    
    public function index(){
        $posts = $this->post->all();
        return view('painel.posts.index', compact('posts'));
    }
    
    public function Salvar(Request $request){
        if ($request->get('id')){ 
            $id = $request->get('id');
            $post = post::find($id);
            $post->user_id = $request->get('user_id');
            $post->title = $request->get('title');
            $post->description = $request->get('description');
            //dd($post);
            $post->save();
            \Session::flash('mensagem_sucesso', "Post $post->id atualizado com sucesso ");
        }else {
            $post = new post();
            $post = $post->create($request->all());
            \Session::flash('mensagem_sucesso', 'Post cadastrado com sucesso');
        }        
        return redirect('post/novo');
    }
    
    public function Novo(){
        $post = new post();
        return view('painel.posts.novopost', compact('post'));
    }

    public function Apagar($idpost){
        $post = post::find($idpost);
        $post->delete();
        return redirect('post/');
    }
    
    public function Atualizar($idpost){
        $post = post::find($idpost);
        return view('painel.posts.novopost', compact('post'));
    }
}
