<?php 
date_default_timezone_set('America/Sao_Paulo');

class Connection { 
	public static $instance; 
	private function __construct() { 
		// 
	} 

	public static function getInstance() { 
		$host = 'localhost'; //ENDEREÇO DO SERVIDOR DB
		$user = 'root'; //USUÁRIO DO SERVIDOR DB
		$pass = 'admin123'; //SENHA DO SERVIDOR DB
		$db   = 'ProductListPhpApi'; //BANCO DE DADOS SELECIONADO
		if (!isset(self::$instance)) { 
			self::$instance = new PDO('mysql:host='.$host.';dbname='.$db, $user, $pass, []); 
			self::$instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
			self::$instance->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_EMPTY_STRING); 
		} 
		return self::$instance; 
	} 

	static function executeSql($sql) {
        try {
            $arrayRetorno['status'] = true;
            $arrayRetorno['result'] = $sql->execute();
            $arrayRetorno['count'] = $sql->rowCount();
            if ($num = Database::$con->lastInsertId()) {
                $arrayRetorno['lastId'] = $num;
            }
            $arrayRetorno['MSN'] = "";
        } catch (PDOException $Exception) {
            $arrayErro = $Exception->getCode();
            $arrayRetorno['status'] = false;
            $arrayRetorno['result'] = "";
            $arrayRetorno['msnErro'] = $arrayErro['msnErro'];
            $arrayRetorno['MSN'] = $arrayErro['erro'];
            $arrayRetorno['cliente'] = $arrayErro['cliente'];
            //Database::sendMailerror($Exception);
        }
        return $arrayRetorno;
    }
}

//EVITA APARECER ERROS PARA O USUÁRIO
//error_reporting(0);
?>