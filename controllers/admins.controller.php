<?php

class AdminsController{

	/*=============================================
	Login de administradores
	=============================================*/	

	public function login(){

		if(isset($_POST["loginEmail"])){

			//////////// animación de carga de inicio ///////////////////////
			/*echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			//////////// fin animación de carga de inicio ///////////////////////

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/	

			if(preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["loginEmail"] )){


				$url = "users?login=true&suffix=user";
				$method = "POST";
				$fields = array(

					"email_user" => $_POST["loginEmail"],
					"password_user" => $_POST["loginPassword"]

				);

				$response = CurlController::request($url,$method,$fields);
				

				/*=============================================
				Validamos que si escriba correctamente los datos
				=============================================*/	
				
				if($response->status == 200){

					/*=============================================
					Validamos que permisos y modulos tiene acceso el user
					=============================================*/	
					$Id_user=$response->results[0]->id_user;
					$id_roles=$response->results[0]->id_role_user;
					//$Id_campus=$response->results[0]->id_campus_user;
					
					//$url = "relations?rel=users,roles,campuses&type=user,role,campus&select=id_user,id_role_user,id_role,name_role,area_role,permit_role,module_role,id_campus,name_campus,shortname_campus&linkTo=id_user&search=".$Id_user;
					$url = "relations?rel=users,roles,campuses&type=user,role,campus&select=id_user,id_role_user,id_role,name_role,area_role,permit_role,module_role,id_campus,name_campus,shortname_campus&linkTo=id_user&equalTo=".$Id_user;
					$method = "GET";
					$fields = array();

					$response2 = CurlController::request($url,$method,$fields);  
					
					$_SESSION["validates"] = $response2->results[0];


					
					/*=============================================
					Validamos que si tenga rol administrativo
					=============================================*/	

					
					/*if($response->results[0]->id_role_user == "1" || $response->results[0]->id_role_user == "2"){

						echo ' <div class="alert alert-danger">You do not have permissions to access</div>';
						return;
					}*/

					


					/*=============================================
					Creamos variable de sesión
					=============================================*/	

					$_SESSION["admin"] = $response->results[0];
					$_SESSION["user"] = $response->results[0];
									
					echo '<script>

					fncFormatInputs();

					localStorage.setItem("token_user", "'.$response->results[0]->token_user.'");
					
					window.location = "'.$_SERVER["REQUEST_URI"].'"

					</script>';


				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
				
					</script> 
					<div class="alert alert-danger">'.$response->results.'</div>';

				}

			}else{

				echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
				
					</script> 

				 <div class="alert alert-danger">Field syntax error</div>';

			}		

		}

	}

	/*=============================================
	Creación administradores
	=============================================*/	

	public function create(){

		if(isset($_POST["matricula"])){

			/*echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';*/

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[A-Za-z0-9]{1,}$/', $_POST["matricula"] ) &&
			   preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"] ) && 
			   preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["ap"] ) && 
			   preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["am"] ) && 
			   preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"] ) &&
			   preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email_personal"] ) &&
			   preg_match('/^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/', $_POST["password"] )){

			   	/*=============================================
				Agrupamos la información 
				=============================================*/		
				/***************** tabla user  **************/
				$data = array(

					"matricula_user" => trim(strtolower($_POST["matricula"])),
					"name_user" => trim(TemplateController::capitalize($_POST["name"])),
					"ap_user" => trim(TemplateController::capitalize($_POST["ap"])),
					"am_user" => trim(TemplateController::capitalize($_POST["am"])),
					"emailpersonal_user" => trim(strtolower($_POST["email_personal"])),
					"email_user" => trim(strtolower($_POST["email"])),
					"id_role_user" => "10",
					"id_campus_user" => trim($_POST["campus"]),
					"password_user" =>  trim($_POST["password"]),
					"estatus_user" => 1,
					"method_user" => "direct",
					"verification_user" => 1,
					"date_created_user" => date("Y-m-d")

				);

				

				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "users?register=true&suffix=user";
				$method = "POST";
				$fields = $data;

				$response = CurlController::request($url,$method,$fields);
						

				/*=============================================
				Respuesta de la API
				=============================================*/		
				
				if($response->status == 200){

					/*=============================================
					Tomamos el ID
					=============================================*/		

					$id = $response->results->lastId;

						/*=============================================
						Solicitud a la API para crear registro en segunda tabla
						=============================================*/
						
						/***************** tabla datauser  **************/
						$data2 = array(

							"id_datauser" => $id

						);
							
						$url_2 = "datausers?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
						$method_2 = "POST";
						$fields_2 = $data2;

						/*echo '<prev>'; print_r($url); echo '</prev>';
						return;*/

						$response = CurlController::request($url_2,$method_2,$fields_2);

						/*echo '<prev>'; print_r($response); echo '</prev>';
						return;*/
												

						/*=============================================
						Validamos y creamos la imagen en el servidor
						=============================================*/	

						if(isset($_FILES["picture"]["tmp_name"]) && !empty($_FILES["picture"]["tmp_name"])){	

							$fields = array(
							
								"file"=>$_FILES["picture"]["tmp_name"],
								"type"=>$_FILES["picture"]["type"],
								"folder"=>"users/".$id,
								"size"=>$_FILES["picture"]["size"],
								"name"=>$id,
								"width"=>300,
								"height"=>300
							);

									
							
							$picture = CurlController::requestFile($fields);
							
							

							/*=============================================
							Solicitud a la API
							=============================================*/	
							
							$url = "users?id=".$id."&nameId=id_user&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
							$method = "PUT";
							$fields = 'picture_user='.$picture;

							$response = CurlController::request($url,$method,$fields);
							
							if($response->status == 200){

								echo '<script>

									fncFormatInputs();
									matPreloader("off");
									fncSweetAlert("close", "", "");
									fncSweetAlert("success", "Your records were created successfully", "/admins");

								</script>';



							}
							

						}else{

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncNotie(3, "Error saving image");

							</script>';

						}
					
				}

			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "Field syntax error");

				</script>';

				
			}
		}

	}

	/*=============================================
	Edición administradores
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idAdmin"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idAdmin"]){

				$select = "id_user,matricula_user,name_user,ap_user,am_user,emailpersonal_user,email_user,picture_user,id_campus_user,password_user";

				$url = "users?select=".$select."&linkTo=id_user&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);
			
				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		

					if (preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"]) &&
						preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["ap"] ) && 
						preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email"] ) &&
						preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email_personal"] ) ){


					   	/*=============================================
						Validar cambio contraseña
						=============================================*/	

						if(!empty($_POST["password"])){

							$password = crypt(trim($_POST["password"]), '$2a$07$azybxcagssoy060696UOsdg23sdfhsd$');
						
						}else{

							$password = $response->results[0]->password_user;

						}

						/*=============================================
						Validar cambio imagen
						=============================================*/	

						if(isset($_FILES["picture"]["tmp_name"]) && !empty($_FILES["picture"]["tmp_name"])){	

								$fields = array(
								
									"file"=>$_FILES["picture"]["tmp_name"],
									"type"=>$_FILES["picture"]["type"],
									"folder"=>"users/".$id,
									"name"=>$id,
									"width"=>300,
									"height"=>300
								);

								$picture = CurlController::requestFile($fields);

						}else{

							$picture = $response->results[0]->picture_user;

						}

					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						$data = "name_user=".trim(TemplateController::capitalize($_POST["name"]))."&ap_user=".trim(TemplateController::capitalize($_POST["ap"]))."&am_user=".trim(TemplateController::capitalize($_POST["am"]))."&emailpersonal_user=".trim(strtolower($_POST["email_personal"]))."&email_user=".trim(strtolower($_POST["email"]))."&id_campus_user=".trim($_POST["campus"])."&password_user=".$password."&date_updated_user=".date("Y-m-d H:i:s")."&picture_user=".$picture;

						$data_user="address_datauser=".trim($_POST["address"])."&phone_datauser=".trim($_POST["phone"])."&movil_datauser=".trim($_POST["movil"])."&postalcode_datauser=".trim($_POST["postalcode"])."&sex_datauser=".trim($_POST["tipo_sexo"])."&tiposangre_datauser=".trim($_POST["tsangre"])."&pais_datauser=".trim($_POST["country"])."&state_datauser=".trim(TemplateController::capitalize($_POST["state"]))."&town_datauser=".trim(TemplateController::capitalize($_POST["town"]))."&nationality_datauser=".trim(TemplateController::capitalize($_POST["nationality"]));

						//$data_user="address_datauser=".trim($_POST["address"])."&phone_datauser=".trim($_POST["phone"])."&movil_datauser=".trim($_POST["movil"]);
						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "users?id=".$id."&nameId=id_user&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
						$method = "PUT";
						$fields = $data;

						$response = CurlController::request($url,$method,$fields);

						$url_2 = "datausers?id=".$id."&nameId=id_datauser&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
						$method_2 = "PUT";
						$fields_2 = $data_user;

						$response_2 = CurlController::request($url_2,$method_2,$fields_2);
						
						
						/*=============================================
						Respuesta de la API
						=============================================*/		
						
						if($response->status == 200){		

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your records were created successfully", "/admins");

							</script>';
	
						}else{

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncNotie(3, "Error editing the registry");

							</script>';
							
						}

					}else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Field syntax error");

						</script>';
						
					}

				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error editing the registry");

					</script>';

					
				}

			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "Error editing the registry");

				</script>';

				
			}
		}

	}

	/*=============================================
	Cambiar contraseña
	=============================================*/	

	public function changePassword(){

		if(isset($_POST["changePassword"])){

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/	

		  	if(preg_match('/^[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}$/', $_POST["changePassword"])){
			
	  			/*=============================================
				Encriptamos la contraseña
				=============================================*/
				
				$crypt = crypt($_POST["changePassword"], '$2a$07$azybxcagssoy060696UOsdg23sdfhsd$');

				/*=============================================
				Actualizar contraseña en base de datos
				=============================================*/

				$url = "users?id=".$_SESSION["user"]->id_user."&nameId=id_user&token=".$_SESSION["user"]->token_user;
				$method = "PUT";
				$fields =  "password_user=".$crypt;
				//$header = array();					

				//$updatePassword = CurlController::request($url, $method, $fields, $header);		
				$updatePassword = CurlController::request($url, $method, $fields);		

				if($updatePassword->status == 200){	

					echo '<script>
								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your new password has been Changed", "/perfiles");
								
							</script>
						';

					/*=============================================
					Enviamos nueva contraseña al correo electrónico
					=============================================*/							
				
					/*$name = $_SESSION["user"]->name_user;
					$subject = "Change of password";
					$email = $_SESSION["user"]->email_user;
					$message = "You have changed your password";
					$url = TemplateController::path()."account&login";

					$sendEmail = TemplateController::sendEmail($name, $subject, $email, $message, $url);

					if($sendEmail == "ok"){

						echo '<script>

								fncFormatInputs();

								fncNotie(1, "Your new password has been successfully sent, please check your email inbox.");

							</script>
						';

					}else{

						echo '<script>

								fncFormatInputs();

								fncNotie(3, "'.$sendEmail.'");

							</script>
						';

					}*/

				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error editing the password");

					</script>';
				}

			}else{

				echo '<script>

					fncFormatInputs();

					fncSweetAlert(
						"error",
						"Error in the syntax of the fields",
						""
					);

				</script>';	

			}


		}

	}

	/*=============================================
	Cambiar foto de perfil
	=============================================*/

	public function changePicture(){

		/*=============================================
		Validamos la sintaxis de los campos
		=============================================*/	

	  	if(isset($_FILES['changePicture']["tmp_name"]) && !empty($_FILES['changePicture']["tmp_name"])){

			$fields = array(
								
									"file"=>$_FILES['changePicture']["tmp_name"],
									"type"=>$_FILES["changePicture"]["type"],
									"folder"=>"users/".$_SESSION["user"]->id_user,
									"name"=>$_SESSION["user"]->id_user,
									"width"=>300,
									"height"=>300
								);

	
	  		$saveImage = CurlController::requestFile($fields);

	  		if($saveImage != "error"){

	  			/*=============================================
				Actualizar fotografía en base de datos
				=============================================*/	

				$url = "users?id=".$_SESSION["user"]->id_user."&nameId=id_user&token=".$_SESSION["user"]->token_user;
				$method = "PUT";
				$fields =  "picture_user=".$saveImage;
				//$header = array();					

				//$updatePicture = CurlController::request($url, $method, $fields, $header);	
				$updatePicture = CurlController::request($url, $method, $fields);	

				if($updatePicture->status == 200){	

					$_SESSION["user"]->picture_user = $saveImage;
					$_SESSION["admin"]->picture_user = $saveImage;

					echo '<script>

						fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your new picture has been changed successfully", "/perfiles");

						
					</script>';		

				}else{
					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error updating the picture");


					</script>';		

				}				
	  		}else{

	  			echo '<script>

					fncFormatInputs();

					fncSweetAlert(
						"error",
						"An error occurred while creating the image, please try again",
						""
					);

				</script>';	

	  		}

	  	}

	}

}


