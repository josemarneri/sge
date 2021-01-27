<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permission = new Permission();
        $lista_funcoes = [             
            'atividade'=> 'Atividades',
            'file'=> 'arquivos',
            'carga'=> 'Carga de trabalho',
            'cargo'=>'Cargos',
            'checklist'=> 'CheckLists',
            'cliente'=> 'Clientes',
            'comessa'=> 'Comessas',
            'desenho'=> 'Desenhos',
            'diariodebordo'=> 'Lançamentos de horas',
            'equipe'=> 'Equipe',            
            'funcionario'=>'Funcionários',
            'orcamento'=> 'Orçamentos',
            'perfil'=> 'Perfil',
            'permission'=> 'Permissões',
            'post'=> 'Posts',
            'projeto'=> 'Projetos',
            'proposta'=> 'Propostas',
            'user'=> 'Usuários',            
            ];        
        

        if (count($permission->all())<1){
            foreach ($lista_funcoes as $key=>$value){
                //Listar
                $lista[] = ['id'=>null, 'name'=>'list-'.$key, 'label'=>'Listar '.$value];
                // Criar
                $lista[] = ['id'=>null, 'name'=>'create-'.$key, 'label'=>'Criar '.$value];
                //Apagar
                $lista[] = ['id'=>null, 'name'=>'delete-'.$key, 'label'=>'Apagar '.$value];
                //Atualizar
                $lista[] = ['id'=>null, 'name'=>'update-'.$key, 'label'=>'Atualizar '.$value];
                //Salvar
                $lista[] = ['id'=>null, 'name'=>'save-'.$key, 'label'=>'Salvar '.$value];
            }

            $permissions[] = ['id'=>null, 'name'=>'menu-engenharia', 'label'=>'Acessar o menu engenharia']; 
            $permissions[] = ['id'=>null, 'name'=>'menu-financeiro', 'label'=>'Acessar o menu financeiro']; 
            $permissions[] = ['id'=>null, 'name'=>'menu-controle', 'label'=>'Acessar o menu controle']; 
            $permissions[] = ['id'=>null, 'name'=>'menu-relatorios', 'label'=>'Acessar o menu relatorios']; 
            $permissions[] = ['id'=>null, 'name'=>'menu-rh', 'label'=>'Acessar o menu rh']; 
            $permissions[] = ['id'=>null, 'name'=>'menu-rh', 'label'=>'Acessar o menu gestão-rh']; 
            $permissions[] = ['id'=>null, 'name'=>'menu-comercial', 'label'=>'Acessar o menu comercial']; 
            $permissions[] = ['id'=>null, 'name'=>'menu-sistema', 'label'=>'Acessar o menu sistema']; 
            
            // Atividades
            $permissions[] = ['id'=>null, 'name'=>'executar-atividade', 'label'=>'Executar atividade']; 
            $permissions[] = ['id'=>null, 'name'=>'avaliar-atividade', 'label'=>'Avaliar atividade'];
            
            foreach ($permissions as $p){
                $permission->create($p);
            }
            
             
            
            foreach ($lista as $p){
                $permission->create($p);
            }
//            foreach ($criar as $p){
//                $permission->create($p);
//            }
//            foreach ($apagar as $p){
//                $permission->create($p);
//            }
//            foreach ($atualizar as $p){
//                $permission->create($p);
//            }
//            foreach ($salvar as $p){
//                $permission->create($p);
//            }
        }
    }
}
