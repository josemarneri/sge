/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function getCodigo(campo1,sigla,campo2) {
    if(campo1.value != 0){
        campo2.disabled = false;
        document.form1.codigo.value = sigla;
    }else{
        campo2.disabled = true;
        document.form1.codigo.value = sigla;
    }       
}

function setHorasPendentes(valor) {
    campo2 = document.form1.horas_pendentes;
    campo2.value = valor;           
}

function confirmacao(url, id) {
    var resposta = confirm("Deseja remover esse registro?");

    if (resposta == true) {
         window.location.href = url+id;
    }
}

function disableSalvar(campo){
    campo.disabled = true;
}

function Infor(campo,infor){
    campo.title = infor;
    
}

function statusSalvar(){
    if(document.form1.btnSalvar.disabled == true){
        document.form1.btnSalvar.title= "Selecione um orçamento para habilitar este botão"
    }else{
        document.form1.btnSalvar.title= "Click para salvar a Comessa"
    }
}

function enableSalvar(campo1, campo2){
    if(campo1.value != 0){
        campo2.disabled = false;
    }else{
        campo2.title = campo1.id + " está vazio!";
        campo2.disabled = true;
    }
}
function enableSalvar2(campo1, campo2, campo3){
    if((campo1.value != 0) && (campo2.value != 0)){
        campo3.disabled = false;
    }else{
        campo3.title=campo1.id + " e/ou " + campo2.id + " estão vazios! campo1:" +campo1.value + " campo2:" + campo2.value;
        campo3.disabled = true;
    }
}

function duplicarCampos(origem,destino,tipo){
	var clone = document.getElementById(origem).cloneNode(true);
	var destino = document.getElementById(destino);
	destino.appendChild (clone);
	var camposClonados = clone.getElementsByTagName(tipo);
	for(i=0; i<camposClonados.length;i++){
		camposClonados[i].value = '';
	}
}
function removerCampos(id){
	var node1 = document.getElementById(id);
	node1.removeChild(node1.childNodes[0]);
}

function mascaraData( campo, e ){
    var kC = (document.all) ? event.keyCode : e.keyCode;
    var data = campo.value;	
    if( kC!=8 && kC!=46 )
    {
            if( data.length==2 )
            {
                if(campo.value < 1 || campo.value >31){
                    alert('Digite um valor entre 1 e 31');
                    campo.value = '';
                }else
                    campo.value = data += '/';
            }
            else if( data.length==5 )
            {
                var mes = data.substr(3,2);
                if(mes < 1 || mes >12){          
                    alert('Digite um valor entre 1 e 12');
                    data = data.substring(0,3);
                    campo.value = data;
                }   else
                    campo.value = data += '/';
            }
            else if( data.length==9 )
            {
                var ano = data.substr(6,4);
                if(ano < 200){          
                    alert('Digite um valor acima de 2000');
                    data = data.substring(0,6);
                    campo.value = data;
                }   else
                    campo.value = data 
            }
    }
}

    function HoraToMin(valor){
        var pos = valor.indexOf (":");
        var hora = valor.substring(0,pos);
        var s = valor.substring(0,1);
        var sinal = (s != '-')? 1 : -1;
        var min = valor.substring(pos+1, pos+3);
        var saldo = Math.abs(parseFloat(hora)) * 60 + Math.abs(parseFloat(min))
        return sinal * saldo;
    }
    
    function MinToHora(valor){
        var hora = Math.abs(parseInt(valor / 60));
        var min = Math.abs(valor % 60)<10 ? '0' + Math.abs(valor % 60) : Math.abs(valor % 60);
        var horas = hora + ':' + min
        return horas;
    }
    
    function maxValue(campo1,campo2){
        var c1 =  campo1.value;
        var c2 =  campo2.value;
        var min1 = HoraToMin(c1);
        var min2 = HoraToMin(c2);
        var saldo = min1 - min2;
        if (saldo < 0){
            window.alert("Você está fazendo:" + MinToHora(saldo) + " horas extras nesta data  \n\
                        Está correto?" );
        }
    }
