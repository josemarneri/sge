<?php

namespace App\Http\Controllers\Plm;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Desenho;
use App\Models\Projeto;
use Gate;
use App\Models\Relatorio;
//use Request as Req;
use App\Others\PontoExcel;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Response;

class DesenhoController extends Controller
{
    //
     private $desenho;
    
    public function __construct(Desenho $desenho){
        $this->desenho = $desenho;
    }
    
    public function index(){
        if (Gate::denies('list-desenho')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $desenhos = $this->desenho->all()->sortByDesc('id');
        $desenho = new Desenho();
        $projetos = Projeto::all();
        $relatorio = new Relatorio();
        $hasPlanilha = $relatorio->existPlanilha();
        return view('plm.desenhos.desenhos', compact('desenhos','desenho','projetos','hasPlanilha'));
    }
    
    public function Filtrar(Request $filtro){
        if (Gate::denies('list-desenho')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}

        $desenhos = $this->desenho->Filtrar($filtro);
        rsort($desenhos);   //Função usada para ordenar os desenhos em ordem decrescente

        //dd($desenhos);
        $desenho = new Desenho();
        $projetos = Projeto::all(); // Busca a lista de projetos cadastrados
        $relatorio = new Relatorio();
        $planilha = $relatorio->gerarListaDesenhosExcel($desenhos);               
        $hasPlanilha = $relatorio->existPlanilha();                
        return view('plm.desenhos.desenhos', compact('desenhos','desenho','projetos','hasPlanilha'));
    }
    
    public function BaixarPlanilha(){
        
        $filename = 'Filtro de desenhos - '. auth()->user()->name . '.xlsx';
        $file= Storage::disk( 'public')->get($filename);

        return (new Response($file, 200)) 
                ->header('Content-Type', "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
    }
    
    public function Atualizar($iddesenho){
        $desenho = Desenho::find($iddesenho);
        if (Gate::denies('update-desenho')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}        
        $projetos = Projeto::all();
        
        return view('plm.desenhos.novodesenho', compact('desenho', 'projetos'));
    }
    
    public function Novo(){
        if (Gate::denies('create-desenho')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $desenho = new Desenho();
        $desenho->numero = $this->desenho->gerarNumero();
        $projetos = Projeto::all();
        
        return view('plm.desenhos.novodesenho', compact('desenho','projetos'));
    }
    
   
    
    public function Apagar($iddesenho){
        if (Gate::denies('delete-desenho')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        $desenho = Desenho::find($iddesenho);        
        $desenho->delete();
        return redirect('/plm/desenhos');
    }
    
  
    public function Salvar(Request $request){
        $user = auth()->user();
        //dd($user->id);
        if (Gate::denies('save-desenho')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        if (Desenho::find($request->get('id'))){ 
            $desenho = Desenho::find($request->get('id'));            
            $desenho->fill($request->all()); 
            $desenho->save();
            \Session::flash('mensagem_sucesso', "Desenho ".$desenho->nome." atualizado com sucesso ");
        }else {
              $desenho = new Desenho();
              $request['id']=$desenho->id;
              $request['alias'] = $request['numero'];         
              $request['user_id'] = $user->id;        

              //dd($request);
              $desenho->fill($request->all());
              $desenho->save();
              //$desenho->user_id = $user->id;
              
            \Session::flash('mensagem_sucesso', 'Desenho cadastrado com sucesso');
        }  
        return redirect('/plm/desenhos');
    }
    
    public function ImportarPlanilha(){
         $user = auth()->user();
        //dd($user->id);
        if (Gate::denies('save-desenho')){
    		abort(403, "Acesso não autorizado para o usuário: ". auth()->user()->login);
    	}
        return view('/plm/desenhos/importarplanilha');
        
    }
    public function ReadPlanilha(Request $request){
        $projeto = new Projeto();
        $user = auth()->user();
        $planilha = new PontoExcel;

        $file = $request->file('filefield');
        //$ext = pathinfo($file, PATHINFO_EXTENSION);
        $ext = $request->filefield->extension();
         if (!($ext == 'xlsx' || $ext == 'xls')){
            $mensagem = "Lamento, os desenhos não foram criados, pois"
                    . " o arquivo escolhido não é uma planilha excel";
            \Session::flash('mensagem_sucesso', $mensagem);
            return redirect('/plm/desenhos/novo');
        }
        //dd($file);
        $tabelaDesenhos = $planilha->ImportarDesenhosExcel($file->getPathname());
        $nlines = count($tabelaDesenhos);
        $ncols = count($tabelaDesenhos[0]);
        $mensagem = "Desenhos cadastrados com sucesso:  ";
        if ($tabelaDesenhos[0][0] != 'NÚMERO'){
            $mensagem = "Lamento, os desenhos não foram criados, pois"
                    . " o arquivo escolhido não está no padrão de importação, procure o administrador do sistema!";
            \Session::flash('mensagem_sucesso', $mensagem);
            return redirect('/plm/desenhos/novo');
        }

        for ($i=1; $i<$nlines; $i++){
            $desenho = new Desenho();
            if (!empty($tabelaDesenhos[$i][0])){
                //dd($tabelaDesenhos[$i][0]);
                //dd($tabelaDesenhos);
                $d = $desenho->getByNumero($tabelaDesenhos[$i][0]);
                
                if (empty($d)){
                    $desenho = new Desenho();
                    $desenho->observacoes = "O número: " . $tabelaDesenhos[$i][0] . 
                            "não foi encontrado e um novo número foi criado. - ";
                }else{
                    $desenho = Desenho::find($d->id);
                }
                
                if (!empty($tabelaDesenhos[$i][2])){
                    $desenho->alias = $tabelaDesenhos[$i][2];  
                }

                $desenho->descricao = $tabelaDesenhos[$i][3];
                $desenho->material = $tabelaDesenhos[$i][4];
                $desenho->peso = $tabelaDesenhos[$i][5];
                $desenho->tratamento = $tabelaDesenhos[$i][6];
                $desenho->projeto_id = ($projeto->getProjetoByCodigo($tabelaDesenhos[$i][7])==null)? null : 
                        $projeto->getProjetoByCodigo($tabelaDesenhos[$i][7])->id;
                $desenho->observacoes = $tabelaDesenhos[$i][8];
                $desenho->user_id = $user->id;
                
                $desenho->save();
                //echo "editado";
                //dd($desenho);
                $mensagem .= "Desenho alterado $desenho->numero: $desenho->descricao  - ";
            }else{
                $dados['numero'] = $desenho->numero;
                $dados['alias'] = $desenho->alias;
                if (!empty($tabelaDesenhos[$i][2])){
                    $dados['alias'] = $tabelaDesenhos[$i][2];  
                }
                $dados['descricao'] = $tabelaDesenhos[$i][3];
                $dados['material'] = $tabelaDesenhos[$i][4];
                $dados['peso'] = $tabelaDesenhos[$i][5];
                $dados['tratamento'] = $tabelaDesenhos[$i][6];
                $dados['projeto_id'] = ($projeto->getProjetoByCodigo($tabelaDesenhos[$i][7])==null)? null : 
                        $projeto->getProjetoByCodigo($tabelaDesenhos[$i][7])->id;
                $dados['observacoes'] = $tabelaDesenhos[$i][8];
                $dados['user_id'] = $user->id;

                $desenho->fill($dados);
                $desenho->save();
                $mensagem .= "Desenho criado $desenho->numero: $desenho->descricao  - ";
            }            
        }
        \Session::flash('mensagem_sucesso', $mensagem);
        return redirect('/plm/desenhos/novo');
        
    }
}
