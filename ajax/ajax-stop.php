<?php

require_once "../controllers/curl.controller.php";


class StopController{

	public $idItem;
	public $table;
	public $suffix;
	public $token;
	

	public function dataStop(){

		$security = explode("~",base64_decode($this->idItem));

		
		if($security[1] == $this->token){

			
			/*=============================================
			Suspender registro
			=============================================*/

                $valor_suspender=2;
			
				$url = $this->table."?id=".$security[0]."&nameId=id_".$this->suffix."&token=".$this->token."&table=users&suffix=user";
				$method = "PUT";
				$fields = 'estatus_user='.$valor_suspender;

				$response = CurlController::request($url, $method, $fields);

				echo $response->status;		

		}else{

			echo 404;
		}

	}

}

if(isset($_POST["idstopItem"])){

	$validate = new StopController();
	$validate -> idItem = $_POST["idstopItem"];
	$validate -> table = $_POST["table"];
	$validate -> suffix = $_POST["suffix"];
	$validate -> token = $_POST["token"];
	$validate -> dataStop();

}

class StopcatController{

	public $idcatItem;
	public $table;
	public $suffix;
	public $token;
	

	public function datacatStop(){

		$security = explode("~",base64_decode($this->idcatItem));

		
		if($security[1] == $this->token){

			
			/*=============================================
			Suspender registro
			=============================================*/

                $valor_suspender=2;
			
				$url = $this->table."?id=".$security[0]."&nameId=id_".$this->suffix."&token=".$this->token."&table=users&suffix=user";
				$method = "PUT";
				$fields = "estatus_".$this->suffix."=".$valor_suspender;

				$response = CurlController::request($url, $method, $fields);
				
				echo $response->status;		

		}else{

			echo 404;
		}

	}

}

if(isset($_POST["idcatItem"])){

	$validate = new StopcatController();
	$validate -> idcatItem = $_POST["idcatItem"];
	$validate -> table = $_POST["table"];
	$validate -> suffix = $_POST["suffix"];
	$validate -> token = $_POST["token"];
	$validate -> datacatStop();

}