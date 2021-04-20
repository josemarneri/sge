<?php
//namespace App\Http\Controllers;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group(['prefix' => 'painel'], function(){
    //PainelController
    Route::get('/', [App\Http\Controllers\Painel\PainelController::class,'index'])->name('painel');
    
    //AtividadeController
    Route::get('atividades',[App\Http\Controllers\Painel\AtividadeController::class,'index'])->name('atividades');
    Route::get('atividades/novo/{comessa_id?}', [App\Http\Controllers\Painel\AtividadeController::class,'Novo'])->name('atividades/novo/{comessa_id?}');
    Route::post('atividades/salvar', [App\Http\Controllers\Painel\AtividadeController::class,'Salvar'])->name('atividades/salvar');
    Route::get('atividades/atualizar/{id}', [App\Http\Controllers\Painel\AtividadeController::class,'Atualizar'])->name('atividades/atualizar/{id}');
    Route::get('atividades/apagar/{id}', [App\Http\Controllers\Painel\AtividadeController::class,'Apagar'])->name('atividades/apagar/{id}');
    Route::get('atividades/iniciar/{id}', [App\Http\Controllers\Painel\AtividadeController::class,'Iniciar'])->name('atividades/iniciar/{id}');
    Route::get('atividades/concluir/{id}', [App\Http\Controllers\Painel\AtividadeController::class,'Concluir'])->name('atividades/concluir/{id}');
    Route::get('atividades/avaliar/{id}', [App\Http\Controllers\Painel\AtividadeController::class,'Avaliar'])->name('atividades/avaliar/{id}');
    Route::get('atividades/addnota/{id}', [App\Http\Controllers\Painel\AtividadeController::class,'addNota'])->name('atividades/addnota/{id}');
    Route::get('atividades/getCodigo/{id}', [App\Http\Controllers\Painel\AtividadeController::class,'getCodigo'])->name('atividades/getCodigo/{id}');
    Route::get('atividades/funcionarioshabilitados/{id}', [App\Http\Controllers\Painel\AtividadeController::class,'getFuncionarios'])->name('atividades/funcionarioshabilitados/{id}');
    //Route::post('atividades/selectfuncionarios', [App\Http\Controllers\Painel\AtividadeController::class,'getFuncionarios');
    
//BeneficioController
    Route::get('beneficios', [App\Http\Controllers\Painel\BeneficioController::class,'index'])->name('beneficios');
    Route::get('beneficios/atualizar/{id}', [App\Http\Controllers\Painel\BeneficioController::class,'Atualizar'])->name('beneficios/atualizar/{id}');
    Route::get('beneficios/apagar/{id}', [App\Http\Controllers\Painel\BeneficioController::class,'Apagar'])->name('beneficios/apagar/{id}');
    Route::get('beneficios/novo', [App\Http\Controllers\Painel\BeneficioController::class,'Novo'])->name('beneficios/novo');
    Route::post('beneficios/salvar', [App\Http\Controllers\Painel\BeneficioController::class,'Salvar'])->name('beneficios/salvar');
    Route::get('beneficios/beneficiados/{id}', [App\Http\Controllers\Painel\BeneficioController::class,'NovosBeneficiados'])->name('beneficios/beneficiados/{id}');
    Route::post('beneficiados/salvar', [App\Http\Controllers\Painel\BeneficioController::class,'SalvarBeneficiados'])->name('beneficiados/salvar');
    Route::get('beneficios/ativardesativar/{id}', [App\Http\Controllers\Painel\BeneficioController::class,'AtivarDesativar'])->name('beneficios/ativardesativar/{id}');
    
    //ClienteController
    Route::get('clientes',[App\Http\Controllers\Painel\ClienteController::class,'index'])->name('clientes');
    Route::get('clientes/novo', [App\Http\Controllers\Painel\ClienteController::class,'Novo'])->name('clientes/novo');
    Route::post('clientes/salvar', [App\Http\Controllers\Painel\ClienteController::class,'Salvar'])->name('clientes/salvar');
    Route::get('clientes/atualizar/{id}', [App\Http\Controllers\Painel\ClienteController::class,'Atualizar'])->name('clientes/atualizar/{id}');
    Route::get('clientes/apagar/{id}', [App\Http\Controllers\Painel\ClienteController::class,'Apagar'])->name('clientes/apagar/{id}');
    
    //CargaController
    Route::get('cargas',[App\Http\Controllers\Painel\CargaController::class,'index'])->name('cargas');
    Route::get('cargas/novo', [App\Http\Controllers\Painel\CargaController::class,'Novo'])->name('cargas/novo');
    Route::post('cargas/salvar', [App\Http\Controllers\Painel\CargaController::class,'Salvar'])->name('cargas/salvar');
    Route::get('cargas/atualizar/{id}', [App\Http\Controllers\Painel\CargaController::class,'Atualizar'])->name('cargas/atualizar/{id}');
    Route::get('cargas/apagar/{id}', [App\Http\Controllers\Painel\CargaController::class,'Apagar'])->name('cargas/apagar/{id}');
    Route::get('cargas/livre/{id}', [App\Http\Controllers\Painel\CargaController::class,'Livre'])->name('cargas/livre/{id}');
    
    //CargoController
    Route::get('cargos',[App\Http\Controllers\Painel\CargoController::class,'index'])->name('cargos');
    Route::get('cargos/novo', [App\Http\Controllers\Painel\CargoController::class,'Novo'])->name('cargos/novo');
    Route::post('cargos/salvar', [App\Http\Controllers\Painel\CargoController::class,'Salvar'])->name('cargos/salvar');
    Route::get('cargos/atualizar/{id}', [App\Http\Controllers\Painel\CargoController::class,'Atualizar'])->name('cargos/atualizar/{id}');
    Route::get('cargos/apagar/{id}', [App\Http\Controllers\Painel\CargoController::class,'Apagar'])->name('cargos/apagar/{id}');
    
    //ChecklistController
    Route::get('checklists',[App\Http\Controllers\Painel\ChecklistController::class,'index'])->name('checklists');
    Route::get('checklists/novo', [App\Http\Controllers\Painel\ChecklistController::class,'Novo'])->name('checklists/novo');
    Route::post('checklists/salvar', [App\Http\Controllers\Painel\ChecklistController::class,'Salvar'])->name('checklists/salvar');
    Route::get('checklists/atualizar/{id}', [App\Http\Controllers\Painel\ChecklistController::class,'Atualizar'])->name('checklists/atualizar/{id}');
    Route::get('checklists/apagar/{id}', [App\Http\Controllers\Painel\ChecklistController::class,'Apagar'])->name('checklists/apagar/{id}');
    Route::get('checklists/apagarpergunta/{id}', [App\Http\Controllers\Painel\ChecklistController::class,'ApagarPergunta'])->name('checklists/apagarpergunta/{id}');    
    
     //ComessaController
    Route::get('comessas',[App\Http\Controllers\Painel\ComessaController::class,'index'])->name('comessas');
    Route::get('comessas/novo/{orcamento_id?}', [App\Http\Controllers\Painel\ComessaController::class,'Novo'])->name('comessas/novo/{orcamento_id');
    Route::post('comessas/salvar', [App\Http\Controllers\Painel\ComessaController::class,'Salvar'])->name('comessas/salvar');
    Route::get('comessas/atualizar/{id}', [App\Http\Controllers\Painel\ComessaController::class,'Atualizar'])->name('comessas/atualizar/{id}');
    Route::get('comessas/apagar/{id}', [App\Http\Controllers\Painel\ComessaController::class,'Apagar'])->name('comessas/apagar/{id}');
    Route::get('comessas/ativardesativar/{id}', [App\Http\Controllers\Painel\ComessaController::class,'AtivarDesativar'])->name('comessas/ativardesativar/{id}');
    Route::get('comessas/getCodigo/{id}', [App\Http\Controllers\Painel\ComessaController::class,'getCodigo'])->name('comessas/getCodigo/{id}');
    
    //DescontoController
    Route::get('descontos', [App\Http\Controllers\Painel\DescontoController::class,'index'])->name('descontos');
    Route::get('descontos/atualizar/{id}', [App\Http\Controllers\Painel\DescontoController::class,'Atualizar'])->name('descontos/atualizar/{id}');
    Route::get('descontos/apagar/{id}', [App\Http\Controllers\Painel\DescontoController::class,'Apagar'])->name('descontos/apagar/{id}');
    Route::get('descontos/novo', [App\Http\Controllers\Painel\DescontoController::class,'Novo'])->name('descontos/novo');
    Route::post('descontos/salvar', [App\Http\Controllers\Painel\DescontoController::class,'Salvar'])->name('descontos/salvar');
    Route::get('descontos/descontados/{id}', [App\Http\Controllers\Painel\DescontoController::class,'NovosDescontados'])->name('descontos/descontados/{id}');
    Route::post('descontados/salvar', [App\Http\Controllers\Painel\DescontoController::class,'SalvarDescontados'])->name('descontados/salvar');
    Route::get('descontos/ativardesativar/{id}', [App\Http\Controllers\Painel\DescontoController::class,'AtivarDesativar'])->name('beneficios/ativardesativar/{id}');
    
    //DiariosdebordoController
    Route::get('diariosdebordo',[App\Http\Controllers\Painel\DiariosdebordoController::class,'index'])->name('diariosdebordo');
    Route::get('diariosdebordo/novo', [App\Http\Controllers\Painel\DiariosdebordoController::class,'Novo'])->name('diariosdebordo/novo');
    Route::post('diariosdebordo/salvar', [App\Http\Controllers\Painel\DiariosdebordoController::class,'Salvar'])->name('diariosdebordo/salvar');
    Route::get('diariosdebordo/atualizar/{id}', [App\Http\Controllers\Painel\DiariosdebordoController::class,'Atualizar'])->name('diariosdebordo/atualizar/{id}');
    Route::get('diariosdebordo/apagar/{id}', [App\Http\Controllers\Painel\DiariosdebordoController::class,'Apagar'])->name('diariosdebordo/apagar/{id}');
    Route::get('diariosdebordo/atividades/{id}', [App\Http\Controllers\Painel\DiariosdebordoController::class,'getAtividades'])->name('diariosdebordo/atividades/{id}');
    Route::get('diariosdebordo/descricao/{id}', [App\Http\Controllers\Painel\DiariosdebordoController::class,'getDescricao'])->name('diariosdebordo/descricao/{id}');
    Route::get('diariosdebordo/descricaoatividade/{id}', [App\Http\Controllers\Painel\DiariosdebordoController::class,'getDescricaoAtividade'])->name('diariosdebordo/descricaoatividade/{id}');
    Route::get('diariosdebordo/horaspendentes/{data}', [App\Http\Controllers\Painel\DiariosdebordoController::class,'getHorasPendentes'])->name('diariosdebordo/horaspendentes/{data');
    

    //Equipe
    Route::get('comessas/equipe/{id}', [App\Http\Controllers\Painel\ComessaController::class,'NovaEquipe'])->name('comessas/equipe/{id}');
    Route::post('equipe/salvar', [App\Http\Controllers\Painel\ComessaController::class,'SalvarEquipe'])->name('equipe/salvar');  
    
    //FornecedorController
    Route::get('fornecedores',[App\Http\Controllers\Painel\FornecedorController::class,'index'])->name('fornecedores');
    Route::get('fornecedores/novo', [App\Http\Controllers\Painel\FornecedorController::class,'Novo'])->name('fornecedores/novo');
    Route::post('fornecedores/salvar', [App\Http\Controllers\Painel\FornecedorController::class,'Salvar'])->name('fornecedores/salvar');
    Route::get('fornecedores/atualizar/{id}', [App\Http\Controllers\Painel\FornecedorController::class,'Atualizar'])->name('fornecedores/atualizar/{id}');
    Route::get('fornecedores/apagar/{id}', [App\Http\Controllers\Painel\FornecedorController::class,'Apagar'])->name('fornecedores/apagar/{id}');
    
    //FuncionarioController
    Route::get('funcionarios',[App\Http\Controllers\Painel\FuncionarioController::class,'index'])->name('funcionarios');
    Route::get('funcionarios/novo', [App\Http\Controllers\Painel\FuncionarioController::class,'Novo'])->name('funcionarios/novo');    
    Route::get('funcionarios/financeiro/{id}', [App\Http\Controllers\Painel\FuncionarioController::class,'Financeiro'])->name('funcionarios/financeiro/{id}');
    Route::get('funcionarios/ativar/{id}', [App\Http\Controllers\Painel\FuncionarioController::class,'AtivarDesativar'])->name('funcionarios/ativar/{id}');
    Route::post('funcionarios/salvar', [App\Http\Controllers\Painel\FuncionarioController::class,'Salvar'])->name('funcionarios/salvar');
    Route::get('funcionarios/atualizar/{id}', [App\Http\Controllers\Painel\FuncionarioController::class,'Atualizar'])->name('funcionarios/atualizar/{id}');
    Route::get('funcionarios/apagar/{id}', [App\Http\Controllers\Painel\FuncionarioController::class,'Apagar'])->name('funcionarios/apagar/{id}');
    Route::get('funcionarios/apagarbeneficio/{beneficio_id}/{funcionario_id}', [App\Http\Controllers\Painel\FuncionarioController::class,'ApagarBeneficio'])->name('funcionarios/apagarbeneficio');
    Route::get('funcionarios/apagardesconto/{desconto_id}/{funcionario_id}', [App\Http\Controllers\Painel\FuncionarioController::class,'ApagarDesconto'])->name('funcionarios/apagardespesa');
    Route::get('funcionarios/getSalarios/{id}', [App\Http\Controllers\Painel\FuncionarioController::class,'getSalarios'])->name('funcionarios/getSalarios/{id}');
    Route::get('funcionarios/alterardadospessoais/{id}', [App\Http\Controllers\Painel\FuncionarioController::class,'AlterarDadosPessoais'])->name('funcionarios/alterardadospessoais/{id}');
    Route::post('funcionarios/salvardadospessoais', [App\Http\Controllers\Painel\FuncionarioController::class,'SalvarDadosPessoais'])->name('funcionarios/salvardadospessoais');
    
    
    
    //OrcamentoController
    Route::get('orcamentos',[App\Http\Controllers\Painel\OrcamentoController::class,'index'])->name('orcamentos');
    Route::get('orcamentos/novo', [App\Http\Controllers\Painel\OrcamentoController::class,'Novo'])->name('orcamentos/novo');
    Route::post('orcamentos/salvar', [App\Http\Controllers\Painel\OrcamentoController::class,'Salvar'])->name('orcamentos/salvar');
    Route::get('orcamentos/atualizar/{id}', [App\Http\Controllers\Painel\OrcamentoController::class,'Atualizar'])->name('orcamentos/atualizar/{id}');
    Route::get('orcamentos/apagar/{id}', [App\Http\Controllers\Painel\OrcamentoController::class,'Apagar'])->name('orcamentos/apagar/{id}');
    Route::get('orcamentos/verproposta/{id}', [App\Http\Controllers\Painel\OrcamentoController::class,'VerProposta'])->name('orcamentos/verproposta/{id}');
    Route::get('orcamentos/atualizarproposta/{id}', [App\Http\Controllers\Painel\OrcamentoController::class,'AtualizarProposta'])->name('orcamentos/atualizarproposta/{id}');
    Route::get('orcamentos/novaproposta/{id}', [App\Http\Controllers\Painel\OrcamentoController::class,'NovaProposta'])->name('orcamentos/novaproposta/{id}');
    Route::post('orcamentos/salvarproposta', [App\Http\Controllers\Painel\OrcamentoController::class,'SalvarProposta'])->name('orcamentos/salvarproposta');
    
    //PermissionController
    Route::get('permissoes',[App\Http\Controllers\Painel\PermissionController::class,'index'])->name('permissoes');
    Route::get('permissoes/novo', [App\Http\Controllers\Painel\PermissionController::class,'Novo'])->name('permissoes/novo');
    Route::post('permissoes/salvar', [App\Http\Controllers\Painel\PermissionController::class,'Salvar'])->name('permissoes/salvar');
    Route::get('permissoes/atualizar/{id}', [App\Http\Controllers\Painel\PermissionController::class,'Atualizar'])->name('permissoes/atualizar/{id}');
    Route::get('permissoes/apagar/{id}', [App\Http\Controllers\Painel\PermissionController::class,'Apagar'])->name('permissoes/apagar/{id}');
    
    //RelatorioController
    Route::get('relatorios',[App\Http\Controllers\Util\RelatorioController::class,'index'])->name('relatorios');
    Route::get('gerarrelatoriodehoras',[App\Http\Controllers\Util\RelatorioController::class,'GerarRelatorioHora'])->name('gerarrelatoriodehoras');
    
    //RoleController
    Route::get('perfis',[App\Http\Controllers\Painel\RoleController::class,'index'])->name('perfis');
    Route::get('perfis/novo', [App\Http\Controllers\Painel\RoleController::class,'Novo'])->name('perfis/novo');
    Route::post('perfis/salvar', [App\Http\Controllers\Painel\RoleController::class,'Salvar'])->name('perfis/salvar');
    Route::get('perfis/atualizar/{id}', [App\Http\Controllers\Painel\RoleController::class,'Atualizar'])->name('perfis/atualizar/{id}');
    Route::get('perfis/apagar/{id}', [App\Http\Controllers\Painel\RoleController::class,'Apagar'])->name('perfis/apagar/{id}');
    Route::get('perfis/addusuarioperfil/{id}', [App\Http\Controllers\Painel\RoleController::class,'addUsuario'])->name('perfis/addusuarioperfil/{id}');
    Route::post('perfis/salvarperfiladd', [App\Http\Controllers\Painel\RoleController::class,'SalvarPerfilAdd'])->name('perfis/salvarperfiladd');
    
    //SalarioController
    Route::get('salarios', [App\Http\Controllers\Painel\SalarioController::class,'index'])->name('salarios');
    Route::get('salarios/atualizar/{id}', [App\Http\Controllers\Painel\SalarioController::class,'Atualizar'])->name('salarios/atualizar');
    Route::get('salarios/apagar/{id}', [App\Http\Controllers\Painel\SalarioController::class,'Apagar'])->name('salarios/apagar');
    Route::get('salarios/novo', [App\Http\Controllers\Painel\SalarioController::class,'Novo'])->name('salarios/novo');
    Route::post('salarios/salvar', [App\Http\Controllers\Painel\SalarioController::class,'Salvar'])->name('salarios/salvar');
    
    //UserController
    Route::get('usuarios',[App\Http\Controllers\Painel\UserController::class,'index'])->name('usuarios');
    Route::get('usuarios/novo', [App\Http\Controllers\Painel\UserController::class,'Novo'])->name('usuarios/novo');
    Route::post('usuarios/salvar', [App\Http\Controllers\Painel\UserController::class,'Salvar'])->name('usuarios/salvar');
    Route::get('usuarios/ativar/{id}', [App\Http\Controllers\Painel\UserController::class,'AtivarDesativar'])->name('usuarios/ativar/{id}');
    Route::post('usuarios/salvarnovasenha', [App\Http\Controllers\Painel\UserController::class,'SalvarNovaSenha'])->name('usuarios/salvarnovasenha');
    Route::get('usuarios/atualizar/{id}', [App\Http\Controllers\Painel\UserController::class,'Atualizar'])->name('usuarios/atualizar/{id}');
    Route::get('usuarios/apagar/{id}', [App\Http\Controllers\Painel\UserController::class,'Apagar'])->name('usuarios/apagar/{id}');
    Route::get('usuarios/alterarsenha/{id}', [App\Http\Controllers\Painel\UserController::class,'AlterarSenha'])->name('usuarios/alterarsenha/{id}');

    
    
    
    //PostControler
    Route::get('posts', [App\Http\Controllers\Painel\PostController::class,'index'])->name('posts');
    
    //RoleController
    Route::get('role', [App\Http\Controllers\Painel\RoleController::class,'index'])->name('role');
    
    //PermissionController
    Route::get('permission', [App\Http\Controllers\Painel\PermissionController::class,'index'])->name('permission');
    
});
//ArquivoController
Route::group(['prefix' => 'arquivos'], function(){    
    Route::get('arquivos',[App\Http\Controllers\Util\ArquivoController::class,'index'])->name('arquivos');
    Route::get('/',[App\Http\Controllers\Util\ArquivoController::class,'index'])->name('/');
    Route::post('carregar', [App\Http\Controllers\Util\ArquivoController::class,'Carregar'])->name('carregar');
    Route::get('anexar/{anexode}/{from_id?}', [App\Http\Controllers\Util\ArquivoController::class,'ListarAnexos'])->name('anexar/{anexode}/{from_id?}');
    Route::post('anexar', [App\Http\Controllers\Util\ArquivoController::class,'Anexar'])->name('anexar');
    Route::get('baixar/{id}', [App\Http\Controllers\Util\ArquivoController::class,'Baixar'])->name('baixar/{id}');
    Route::get('apagar/{id}', [App\Http\Controllers\Util\ArquivoController::class,'Apagar'])->name('apagar/{id}');  
});

//PlmController
Route::group(['prefix' => 'plm'], function(){    
Route::get('desenhos',[App\Http\Controllers\Plm\DesenhoController::class,'index'])->name('desenhos');
    Route::get('desenhos/novo', [App\Http\Controllers\Plm\DesenhoController::class,'Novo'])->name('desenhos/novo');
    Route::post('desenhos/salvar', [App\Http\Controllers\Plm\DesenhoController::class,'Salvar'])->name('desenhos/salvar');
    Route::any('desenhos/filtrar', [App\Http\Controllers\Plm\DesenhoController::class,'Filtrar'])->name('desenhos/filtrar');
    Route::get('desenhos/atualizar/{id}', [App\Http\Controllers\Plm\DesenhoController::class,'Atualizar'])->name('desenhos/atualizar/{id}');
    Route::get('desenhos/apagar/{id}', [App\Http\Controllers\Plm\DesenhoController::class,'Apagar'])->name('desenhos/apagar/{id}');  
    Route::get('desenhos/novo/importarplanilha', [App\Http\Controllers\Plm\DesenhoController::class,'ImportarPlanilha'])->name('desenhos/novo/importarplanilha');  
    Route::post('desenhos/novo/lerplanilha', [App\Http\Controllers\Plm\DesenhoController::class,'ReadPlanilha'])->name('desenhos/novo/lerplanilha');  
    Route::get('desenhos/baixarplanilha', [App\Http\Controllers\Plm\DesenhoController::class,'BaixarPlanilha'])->name('desenhos/baixarplanilha');  
  
    
Route::get('projetos',[App\Http\Controllers\Plm\ProjetoController::class,'index'])->name('projetos');
    Route::get('projetos/novo', [App\Http\Controllers\Plm\ProjetoController::class,'Novo'])->name('projetos/novo');
    Route::post('projetos/salvar', [App\Http\Controllers\Plm\ProjetoController::class,'Salvar'])->name('projetos/salvar');
    Route::post('projetos/filtrar', [App\Http\Controllers\Plm\ProjetoController::class,'Filtrar'])->name('projetos/filtrar');
    Route::get('projetos/atualizar/{id}', [App\Http\Controllers\Plm\ProjetoController::class,'Atualizar'])->name('projetos/atualizar/{id}');
    Route::get('projetos/apagar/{id}', [App\Http\Controllers\Plm\ProjetoController::class,'Apagar'])->name('projetos/apagar/{id}');  
});

//UtilController
Route::group(['prefix' => 'util'], function(){ 
    
    Route::get('/',[App\Http\Controllers\Util\UtilController::class,'index'])->name('/'); 
    Route::post('importarfuncionariosdoexcel', [App\Http\Controllers\Util\UtilController::class,'CreateFuncionarioFromExcel'])->name('importarfuncionariosdoexcel');
    Route::post('importarusuariosdoexcel', [App\Http\Controllers\Util\UtilController::class,'CreateUserFromExcel'])->name('importarusuariosdoexcel');
    
    //RelatorioController
    Route::get('relatorios',[App\Http\Controllers\Util\RelatorioController::class,'index'])->name('relatorios');
    Route::get('gerarrelatorio',[App\Http\Controllers\Util\RelatorioController::class,'GerarRelatorio'])->name('gerarrelatorio');
    Route::post('relatorios/gerarrelatoriohoras',[App\Http\Controllers\Util\RelatorioController::class,'GerarRelatorioHoras'])->name('relatorios/gerarrelatoriohoras');
    Route::get('relatorios/funcionarioshabilitados/{id}', [App\Http\Controllers\Util\RelatorioController::class,'getFuncionarios'])->name('relatorios/funcionarioshabilitados/{id}');
    Route::get('relatoriohoras',[App\Http\Controllers\Util\RelatorioController::class,'RelatorioHoras'])->name('relatoriohoras');
    Route::get('relatoriohorasgeral',[App\Http\Controllers\Util\RelatorioController::class,'RelatorioHorasGeral'])->name('relatoriohorasgeral');
    Route::post('gerarPdf', [App\Http\Controllers\Util\RelatorioController::class,'gerarPDF'])->name('gerarPDF');
    
});
//FinanceiroController
Route::group(['prefix' => 'financeiro'], function(){ 

    //FinanceiroController
    Route::get('consultivar',[App\Http\Controllers\Financeiro\FinanceiroController::class,'consultivarHoras'])->name('consultivar');    
    Route::post('consultivar/filtrar',[App\Http\Controllers\Financeiro\FinanceiroController::class,'ConsultivarFiltrar'])->name('consultivar/filtrar');    
    Route::post('consultivar/salvar',[App\Http\Controllers\Financeiro\FinanceiroController::class,'ConsultivarSalvar'])->name('consultivar/salvar');    
    Route::get('consultivar/funcionarioshabilitados/{id}', [App\Http\Controllers\Financeiro\FinanceiroController::class,'getFuncionarios'])->name('consultivar/funcionarioshabilitados/{id}');
    
    Route::get('faturar',[App\Http\Controllers\Financeiro\FinanceiroController::class,'faturarHoras'])->name('faturar');
    Route::post('faturar/filtrar',[App\Http\Controllers\Financeiro\FinanceiroController::class,'FaturarFiltrar'])->name('faturar/filtrar');    
    Route::post('faturar/salvar',[App\Http\Controllers\Financeiro\FinanceiroController::class,'FaturarSalvar'])->name('faturar/salvar');
    Route::get('faturar/funcionarioshabilitados/{id}', [App\Http\Controllers\Financeiro\FinanceiroController::class,'getFuncionarios'])->name('faturar/funcionarioshabilitados/{id}');
    
    //DespesaController
    Route::get('despesas',[App\Http\Controllers\Financeiro\DespesaController::class,'index'])->name('despesas');
    Route::get('despesas/novo',[App\Http\Controllers\Financeiro\DespesaController::class,'Novo'])->name('despesas/novo');    
    Route::get('despesas/atualizar/{id}',[App\Http\Controllers\Financeiro\DespesaController::class,'Atualizar'])->name('despesas/atualizar');    
    Route::get('despesas/apagar/{id}',[App\Http\Controllers\Financeiro\DespesaController::class,'Apagar'])->name('despesas/apagar');    
    Route::post('despesas/filtrar',[App\Http\Controllers\Financeiro\DespesaController::class,'Filtrar'])->name('despesas/filtrar');    
    Route::post('despesas/salvar',[App\Http\Controllers\Financeiro\DespesaController::class,'Salvar'])->name('despesas/salvar');
    
    //PagamentoController
    Route::get('pagamentos',[App\Http\Controllers\Financeiro\PagamentoController::class,'index'])->name('pagamentos');
    Route::get('pagamentos/novo',[App\Http\Controllers\Financeiro\PagamentoController::class,'Novo'])->name('pagamentos/novo');    
    Route::get('pagamentos/novosalario',[App\Http\Controllers\Financeiro\PagamentoController::class,'NovoSalario'])->name('pagamentos/novosalario');    
    Route::get('pagamentos/atualizar/{id}',[App\Http\Controllers\Financeiro\PagamentoController::class,'Atualizar'])->name('pagamentos/atualizar');    
    Route::get('pagamentos/atualizarsalario/{id}',[App\Http\Controllers\Financeiro\PagamentoController::class,'AtualizarSalario'])->name('pagamentos/atualizarsalario');    
    Route::get('pagamentos/apagar/{id}',[App\Http\Controllers\Financeiro\PagamentoController::class,'Apagar'])->name('pagamentos/apagar');    
    Route::post('pagamentos/filtrar',[App\Http\Controllers\Financeiro\PagamentoController::class,'Filtrar'])->name('pagamentos/filtrar');    
    Route::get('pagamentos/preencherdadossalario/{id}/{inicio}/{fim}',[App\Http\Controllers\Financeiro\PagamentoController::class,'PreencherDados'])->name('pagamentos/preencherdadossalario');    
    Route::post('pagamentos/salvar',[App\Http\Controllers\Financeiro\PagamentoController::class,'Salvar'])->name('pagamentos/salvar');
    
    //RecebidoController
    Route::get('recebidos',[App\Http\Controllers\Financeiro\RecebidoController::class,'index'])->name('recebidos');
    Route::get('recebidos/novo',[App\Http\Controllers\Financeiro\RecebidoController::class,'Novo'])->name('recebidos/novo');    
    Route::get('recebidos/atualizar/{id}',[App\Http\Controllers\Financeiro\RecebidoController::class,'Atualizar'])->name('recebidos/atualizar');    
    Route::get('recebidos/apagar/{id}',[App\Http\Controllers\Financeiro\RecebidoController::class,'Apagar'])->name('recebidos/apagar');    
    Route::post('recebidos/filtrar',[App\Http\Controllers\Financeiro\RecebidoController::class,'Filtrar'])->name('recebidos/filtrar');    
    Route::post('recebidos/salvar',[App\Http\Controllers\Financeiro\RecebidoController::class,'Salvar'])->name('recebidos/salvar');
    
    
    
});

//RdpController
Route::group(['prefix' => 'rdp'], function(){    
    Route::get('/',[App\Http\Controllers\Painel\RdpController::class,'index'])->name('/');
    Route::post('exceltodb', [App\Http\Controllers\Painel\RdpController::class,'ImportFromExcelToDB'])->name('exceltodb');
    Route::get('baixar/{id}', [App\Http\Controllers\Util\ArquivoController::class,'Baixar'])->name('baixar/{id}');
    Route::get('apagar/{id}', [App\Http\Controllers\Util\ArquivoController::class,'Apagar'])->name('apagar/{id}');  
});


Route::group(['prefix' => 'error'], function(){    
    Route::get('/',[App\Http\Controllers\Painel\RdpController::class,'index'])->name('/');
 
});


Route::group(['prefix' => 'post'], function(){
    //Exibir os posts
    Route::get('/', [App\Http\Controllers\Painel\PostController::class,'index'])->name('/');    
    //inserir posts
    Route::get('novo',[App\Http\Controllers\Painel\PostController::class,'Novo'])->name('novo'); 
    //apagar posts
    Route::get('apagar/{id}',[App\Http\Controllers\Painel\PostController::class,'Apagar'])->name('apagar/{id}');    
    //atualizar posts
    Route::get('atualizar/{id}',[App\Http\Controllers\Painel\PostController::class,'Atualizar'])->name('atualizar/{id}');    
    //salvar
    Route::post('salvar/',[App\Http\Controllers\Painel\PostController::class,'Salvar'])->name('salvar/');
    
});

//Route::auth();
Route::get('/excel', [App\Http\Controllers\Util\ExcelController::class,'index'])->name('/excel');
Route::get('/rdp', [App\Http\Controllers\Painel\RdpController::class,'index'])->name('/rdp');
Route::get('/func/{id?}', [App\Http\Controllers\Painel\UserController::class,'getFuncionario'])->name('func/{id?}');
Route::get('/test/{id?}', [App\Http\Controllers\Util\ExcelController::class,'test'])->name('/test/{id?}');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/', [App\Http\Controllers\SiteController::class, 'index'])->name('/');

//SiteController;
Route::group(['prefix' => 'sistema'], function(){
    Route::get('/', [App\Http\Controllers\SiteController::class, 'index'])->name('/');
    Route::get('logs', [App\Http\Controllers\SiteController::class, 'Logs'])->name('logs');
});
