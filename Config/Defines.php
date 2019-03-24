<?php 
if (isset($_SERVER['HTTP_ORIGIN'])) {
    header("Access-Control-Allow-Origin: {$_SERVER['HTTP_ORIGIN']}");
    header('Access-Control-Allow-Credentials: true');
    header('Access-Control-Max-Age: 86400');    // cache for 1 day
}

// Access-Control headers are received during OPTIONS requests
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: GET, POST, OPTIONS");         

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");

    exit(0);
}

//CONVERTE A DATA PARA O PADAO BRASILEIRO
function data_brasil($data_americana){
	return implode('/', array_reverse(explode('-', $data_americana)));
}
//CONVERTE A DATA PARA O PADAO AMERICANO
function data_eua($data_brasilera){
	return implode('-', array_reverse(explode('/', $data_brasilera)));
}
//CONVERTE O VALOR EM MOEDA
function double_moeda($valor){
	return number_format($valor,2,",",".");
}
//CONVERTE A MOEDA EM VALOR
function moeda_double($valor){
	return str_replace(",", ".", str_replace(".", "", $valor));
}
//CONVERTE STRING EM HORA
function string_hora($string){
	return substr($string, 0, 5);
}
//CONVERTE A STRING EM CPF
function string_cpf($string){
	return substr($string, 0, 3) . '.' . substr($string, 3, 3) . '.' . substr($string, 6, 3) . '-' . substr($string, 9, 2);
}
//CONVERTE A STRING EM CNPJ
function string_cnpj($string){
	return substr($string, 0, 2) . '.' . substr($string, 2, 3) . '.' . substr($string, 5, 3) . '/' . substr($string, 8, 4) . '-' . substr($string, 12, 2);
}
//CONVERTE STRING EM CEP
function string_cep($string){
	return substr($string, 0, 5) . '-' . substr($string, 5, 3);
}
//CONVERTE STRING EM TELEFONE
function string_telefone($string){
	if(!empty($string)){
		if(strlen($string) <= 10){
			return '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 4) . '-' . substr($string, 6);
		}else{
			return '(' . substr($string, 0, 2) . ') ' . substr($string, 2, 5) . '-' . substr($string, 7);
		}
	}else{
		return "";
	}
}
?>