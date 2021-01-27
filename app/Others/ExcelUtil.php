<?php
ini_set('max_execution_time','-1');
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Others;

use App\Others\SimpleXLSX;

/**
 * Description of ExcelUtil
 *
 * @author neri
 */
class ExcelUtil {
    //put your code here
 
	// Atributo recebe a instância da conexão PDO
	private $conexao  = null;
 
     // Atributo recebe uma instância da classe SimpleXLSX
	private $planilha = null;
 
	// Atributo recebe a quantidade de linhas da planilha
	private $linhas   = null;
 
	// Atributo recebe a quantidade de colunas da planilha
	private $colunas  = null;
 
	/*
	 * Método Construtor da classe
	 * @param $path - Caminho e nome da planilha do Excel xlsx
	 * @param $conexao - Instância da conexão PDO
	 */
	public function __construct($path=null){
 
		if(!empty($path) && file_exists($path)):
			$this->planilha = new SimpleXLSX($path);
			list($this->colunas, $this->linhas) = $this->planilha->dimension();
		else:
			echo 'Arquivo não encontrado!';
			exit();
		endif;
 
	}
 
	/*
	 * Método que retorna o valor do atributo $linhas
	 * @return Valor inteiro contendo a quantidade de linhas na planilha
	 */
	public function getQtdeLinhas(){
		return $this->linhas;
	}
 
	/*
	 * Método que retorna o valor do atributo $colunas
	 * @return Valor inteiro contendo a quantidade de colunas na planilha
	 */
	public function getQtdeColunas(){
		return $this->colunas;
	}
 
	/*
	 * Método para ler os dados da planilha e inserir no banco de dados
	 * @return Valor Inteiro contendo a quantidade de linhas importadas
	 */
	public function insertDados(){
 
		try{
			$sql = 'INSERT INTO cliente (codigo, nome, cpf, email, celular)VALUES(?, ?, ?, ?, ?)';
			$stm = $this->conexao->prepare($sql);
			
			//$linha = ;
			foreach($this->planilha->rows() as $chave => $valor):
				if ($chave >= 1 && !$this->isRegistroDuplicado(trim($valor[2]))):		
					$codigo  = trim($valor[]);
					$nome    = trim($valor[1]);
					$cpf     = trim($valor[2]);
					$email   = trim($valor[3]);
					$celular = trim($valor[4]);
 
					$stm->bindValue(1, $codigo);
					$stm->bindValue(2, $nome);
					$stm->bindValue(3, $cpf);
					$stm->bindValue(4, $email);
					$stm->bindValue(5, $celular);
					$retorno = $stm->execute();
					
					if($retorno == true) $linha++;
				 endif;
			endforeach;
 
			return $linha;
		}catch(Exception $erro){
			echo 'Erro: ' . $erro->getMessage();
		}
 
	}
}
