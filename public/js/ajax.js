/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function GetXMLHttp() {
    if(navigator.appName == "Microsoft Internet Explorer") {
        xmlHttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    else {
        xmlHttp = new XMLHttpRequest();
    }
    return xmlHttp;
}
 
var xmlRequest = GetXMLHttp();
