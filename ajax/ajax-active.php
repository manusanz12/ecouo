<?php

require_once "../controllers/curl.controller.php";


class ActtiveController{

	public $idItem;
	public $table;
	public $suffix;
	public $token;
	

	public function dataActive(){

		$security = explode("~",base64_decode($this->idItem));

		
		if($security[1] == $this->token){

			
			/*=============================================
			activar registro
			=============================================*/

                $valor_activar=1;
			
				$url = $this->table."?id=".$security[0]."&nameId=id_".$this->suffix."&token=".$this->token."&table=users&suffix=user";
				$method = "PUT";
				$fields = 'estatus_user='.$valor_activar;

				$response = CurlController::request($url, $method, $fields);

				echo $response->status;		

		}else{

			echo 404;
		}

	}

}

if(isset($_POST["idactiveItem"])){

	$validate = new ActtiveController();
	$validate -> idItem = $_POST["idactiveItem"];
	$validate -> table = $_POST["table"];
	$validate -> suffix = $_POST["suffix"];
	$validate -> token = $_POST["token"];
	$validate -> dataActive();

}

class ActtivecatController{

	public $idactivecatItem;
	public $table;
	public $suffix;
	public $token;
	

	public function datacatActive(){

		$security = explode("~",base64_decode($this->idactivecatItem));

		
		if($security[1] == $this->token){

			
			/*=============================================
			activar registro
			=============================================*/

                $valor_activar=1;
			
				$url = $this->table."?id=".$security[0]."&nameId=id_".$this->suffix."&token=".$this->token."&table=users&suffix=user";
				$method = "PUT";
				$fields = 'estatus_campus='.$valor_activar;

				$response = CurlController::request($url, $method, $fields);

				echo $response->status;		

		}else{

			echo 404;
		}

	}

}

if(isset($_POST["idactivecatItem"])){

	$validate = new ActtivecatController();
	$validate -> idactivecatItem = $_POST["idactivecatItem"];
	$validate -> table = $_POST["table"];
	$validate -> suffix = $_POST["suffix"];
	$validate -> token = $_POST["token"];
	$validate -> datacatActive();

}