<?php

class ProgramsController{


	/*=============================================
	Creación Programas
	=============================================*/	

	public function create(){

		if(isset($_POST["name"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"] ) && 
			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["rvoe"] ) && 
			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["code_program"] ) &&
			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["duration"] ) ){

			   	/*=============================================
				Agrupamos la información 
				=============================================*/		
				/***************** tabla Programs  **************/
				$data = array(

					"name_program" => trim(TemplateController::capitalize($_POST["name"])),
					"rvoe_program" => trim($_POST["rvoe"]),
					"code_program" => trim($_POST["code_program"]),
					"mode_program" => trim($_POST["modalidad"]),
					"level_program" => trim($_POST["nivel"]),
					"duration_program" => trim($_POST["duration"]),
					"id_campus_program" => trim($_POST["campus"]),
					"id_campus_program" => trim($_POST["campus"]),
					"estatus_program" => 1,
					"date_created_program" => date("Y-m-d")

				);

				

				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "programs?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
				$method = "POST";
				$fields = $data;

				$response = CurlController::request($url,$method,$fields);
						

				/*=============================================
				Respuesta de la API
				=============================================*/		
				
				if($response->status == 200){

																	

								echo '<script>

									fncFormatInputs();
									matPreloader("off");
									fncSweetAlert("close", "", "");
									fncSweetAlert("success", "Your records were created successfully", "/programs");

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
		}

	}

	/*=============================================
	Edición Programas
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idPrograms"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idPrograms"]){

				$select = "*";

				$url = "programs?select=".$select."&linkTo=id_program&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);
			
				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		

					if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"] ) && 
						preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["rvoe"] ) && 
						preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["code_program"] ) &&
						preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["duration"] ) ){


					   

					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						$data = "name_program=".trim(TemplateController::capitalize($_POST["name"]))."&rvoe_program=".trim($_POST["rvoe"])."&code_program=".trim($_POST["code_program"])."&mode_program=".trim($_POST["modalidad"])."&level_program=".trim($_POST["nivel"])."&duration_program=".trim($_POST["duration"])."&id_campus_program=".trim($_POST["campus"])."&date_updated_program=".date("Y-m-d H:i:s");

						
						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "programs?id=".$id."&nameId=id_program&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
						$method = "PUT";
						$fields = $data;

						$response = CurlController::request($url,$method,$fields);

											
						
						/*=============================================
						Respuesta de la API
						=============================================*/		
						
						if($response->status == 200){		

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your records were created successfully", "/programs");

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

}


