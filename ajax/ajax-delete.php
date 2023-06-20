<?php

require_once "../controllers/curl.controller.php";


class DeleteController{

	public $idItem;
	public $table;
	public $suffix;
	public $token;
	public $deleteFile;

	public function dataDelete(){

		$security = explode("~",base64_decode($this->idItem));

		
		if($security[1] == $this->token){

			/*=============================================
			Validar primero que la categoría no tenga productos
			=============================================*/
				
			if($this->table == "campuses" || $this->table == "subcategories" || $this->table == "stores"){

				$url = "users?select=id_campus_user&linkTo=id_".$this->suffix."_user&equalTo=".$security[0];
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url, $method, $fields);

			
				if($response->status == 200){

					echo "no-delete";

					return;

				}
			
			}


			/*=============================================
			Validar que si vengan archivos para borrar
			=============================================*/

			if($this->deleteFile != "no"){

				if($this->table == "products"){

					$count = 0;

					foreach (json_decode(base64_decode($this->deleteFile),true) as $key => $value) {

						$count++;
						
						$fields = array(
									
						 "deleteFile"=>$value

						);

						CurlController::requestFile($fields);

						if($count == count(json_decode(base64_decode($this->deleteFile),true))){

							$picture = "ok";
						}
					}

				}else{

					$fields = array(
									
					 "deleteFile"=>$this->deleteFile,
					 "deleteDir"=>$this->suffix

					);

					$picture = CurlController::requestFile($fields);


				}

			}else{

				$picture = "ok";
				
			}

			/*=============================================
			Eliminar registro
			=============================================*/

			if($picture == "ok"){

				$url = $this->table."?id=".$security[0]."&nameId=id_".$this->suffix."&token=".$this->token."&table=users&suffix=user";
				$method = "DELETE";
				$fields = array();

				$response = CurlController::request($url, $method, $fields);

				if($response->status==200){
					$url_2 = "datausers?id=".$security[0]."&nameId=id_datauser&token=".$this->token."&table=users&suffix=user";
					$method_2 = "DELETE";
					$fields_2 = array();

					$response = CurlController::request($url_2, $method_2, $fields_2);
					
					echo $response->status;
				}
			}

		}else{

			echo 404;
		}

	}

}

if(isset($_POST["idItem"])){

	$validate = new DeleteController();
	$validate -> idItem = $_POST["idItem"];
	$validate -> table = $_POST["table"];
	$validate -> suffix = $_POST["suffix"];
	$validate -> token = $_POST["token"];
	$validate -> deleteFile = $_POST["deleteFile"];
	$validate -> dataDelete();

}

class DeletecatController{

	public $idcatItem;
	public $table;
	public $suffix;
	public $token;
	

	public function datacatDelete(){

		$security = explode("~",base64_decode($this->idcatItem));
		
		

		if($security[1] == $this->token){
			

			/*=============================================
			Validar primero que la categoría no tenga productos
			=============================================*/
			
			if($this->table == "campuses"){

				$url = "users?select=id_campus_user&linkTo=id_".$this->suffix."_user&equalTo=".$security[0];
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url, $method, $fields);
				
				
				if($response->status == 200){

					echo "no-delete";

					return;

				}
			
			}
		

			$picture ="ok";
				
			/*=============================================
			Eliminar registro
			=============================================*/

				if($picture == "ok"){

					$url = $this->table."?id=".$security[0]."&nameId=id_".$this->suffix."&token=".$this->token."&table=users&suffix=user";
					$method = "DELETE";
					$fields = array();

					$response = CurlController::request($url, $method, $fields);
					

					if($response->status==200){
											
						echo $response->status;
						
					}
				}

			}else{

				echo 404;
			}

	}

}

if(isset($_POST["idcatItem"])){

	$validate = new DeletecatController();
	$validate -> idcatItem = $_POST["idcatItem"];
	$validate -> table = $_POST["table"];
	$validate -> suffix = $_POST["suffix"];
	$validate -> token = $_POST["token"];
	$validate -> datacatDelete();

}