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
        window.alert(sigla);
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
        campo2.title = " O campo: " + campo1.title + " está vazio!";
        campo2.disabled = true;
    }
}
function marcarTodos(campo1, nome){
    var campo2 = document.getElementsByName(nome);
//    var campo2 = document.getElementByName(nome);
    if(campo1.checked == true){ 
        for (var i =0; i<campo2.length ; i++){
            campo2[i].checked = true;
        }

    }else{
        for (var i =0; i<campo2.length ; i++){
            campo2[i].checked = false;
        }
    }
}
function preencherTodos(campo1, nome){
    var campo2 = document.getElementsByName(nome);
//    var campo2 = document.getElementByName(nome);
    if(campo1.checked == true){ 
        for (var i =1; i<campo2.length ; i++){
            campo2[i].value = campo2[0].value;
        }

    }else{
        for (var i =1; i<campo2.length ; i++){
            campo2[i].value = '';
        }
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
function preencherDescricao(campo1, campo2, campo3){
    if((campo1.value != 0) && (campo2.value != 0)){
        var comessa = campo1.selectedOptions[0].textContent;
        var atividade = campo2.selectedOptions[0].textContent;
        pos1 = comessa.indexOf('-');
        comessa = comessa.substring(pos1+2,comessa.length);
        pos2 = atividade.indexOf('-');
        atividade = atividade.substring(pos2+2,atividade.length);
        campo3.value = comessa + " - " + atividade;
    }else {
        campo3.value = campo1.title;
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

function mascaraPercentual( campo, e , ndec = 2){
    var kC = (window.event) ? event.keyCode : e.keyCode;
//    var kC = (window.event) ? window.alert(event.type) : e.keyCode;
    var decimalChar = '.';
    var valor = campo.value;
    if( kC == 9 ){
        return true;
    }
    if( kC!=46 )
    {
        if( kC == 8 && valor.length > 0)
            {
                var pos = valor.indexOf(decimalChar);
                
                var v1 = valor.substring(0,(pos - 1));
                if (parseInt(v1) < 10){
                    v1 = '0' + parseInt(v1);
                }
                var v2 = valor.substring((pos - 1),pos);
                var v3 = valor.substring(pos+1);
                campo.value = v1 + decimalChar + v2 +  v3;
                return true;
            }
//        window.alert(valor + '-' +campo.length+ '-' + (kC));
        if((kC>=48 && kC<=57) || (kC>=96 && kC<=105)){            
            if( valor.length == 0 )
            {
                var valor = '0'+decimalChar;
                for (i = 1; i<ndec; i++){
                    valor += '0';
                }
                campo.value = valor;
                return true;
            }            

            if( valor.length >= 4 )
            {
                var pos = valor.indexOf(decimalChar);
                var v1 = valor.substring(0,pos);
                var v2 = valor.substring(pos+1,pos+2);
                var inteiro = parseInt(v1 + v2);
                if (inteiro < 10){
                    inteiro = '0' + inteiro;
                }
                var v3 = valor.substring(pos+2);
                valor = inteiro + decimalChar + v3;
                var valorFinal = valor + (kC % 48);
                valorFinal = parseFloat(valorFinal);
                if (valorFinal >100){
                    window.alert("O valor deve ser menor do que 100% ");
                    return false;
                }              
                  campo.value = valor;
                  return true;
            }
        }else{
            return false;

        }       
        
    }{
        return false;
    }
}
function mascaraMoeda( campo, e , ndec = 2){
    //ndec = numero de casas decimais
    var kC = (window.event) ? event.keyCode : e.keyCode;
//    var kC = (window.event) ? window.alert(event.type) : e.keyCode;
    var decimalChar = '.';
    if( kC == 9 ){
        return true;
    }
    var valor = campo.value;	
    if( kC!=46 )
    {
        if( kC == 8 && valor.length > 0)
            {
                var pos = valor.indexOf(decimalChar);
                
                var v1 = valor.substring(0,(pos - 1));
                if (parseInt(v1) < 10){
                    v1 = '0' + parseInt(v1);
                }
                var v2 = valor.substring((pos - 1),pos);
                var v3 = valor.substring(pos+1,pos+ndec+1);
                campo.value = v1 + decimalChar + v2 +  v3;
                return true;
            }
//        window.alert(valor + '-' +campo.length+ '-' + (kC));
        if((kC>=48 && kC<=57) || (kC>=96 && kC<=105)){            
            if( valor.length == 0 )
            {
                var valor = '0'+decimalChar;
                for (i = 1; i<ndec; i++){
                    valor += '0';
                }
                campo.value = valor;
                return true;
            }            

            if( valor.length >= (ndec+2) )
            {
                var pos = valor.indexOf(decimalChar);
                var v1 = valor.substring(0,pos);
                var v2 = valor.substring(pos+1,pos+2);
                var inteiro = parseInt(v1 + v2);
                if (inteiro < 10){
                    inteiro = '0' + inteiro;
                }
                var v3 = valor.substring(pos+2,pos+ndec+1);
                valor = inteiro + decimalChar + v3;            
                  campo.value = valor;
                  return true;
            }
        }else{
            return false;
        }
        
    }{
        return false;
    }
}

function cutLast(campo){
    var valor = campo.value;
    var le = valor.length;
    var sub = valor.substring(0,le);
    window.alert(sub);
    campo.value = sub;
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
