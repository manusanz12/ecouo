<?php

class AspirantesController{

	/*=============================================
	Creación Aspirantes
	=============================================*/	

	public function create(){

		if(isset($_POST["matricula"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[A-Za-z0-9]{1,}$/', $_POST["matricula"] ) &&
			   preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"] ) && 
			   preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["ap"] ) && 
			   preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["am"] ) && 
			   preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email_personal"] )){

			   	/*=============================================
				Agrupamos la información 
				=============================================*/		
				/***************** tabla aspirantes  **************/
				$data = array(

					"idcrm_aspirante" => trim(strtolower($_POST["matricula"])),
					"name_aspirante" => trim(TemplateController::capitalize($_POST["name"])),
					"ap_aspirante" => trim(TemplateController::capitalize($_POST["ap"])),
					"am_aspirante" => trim(TemplateController::capitalize($_POST["am"])),
					"emailpersonal_aspirante" => trim(strtolower($_POST["email_personal"])),
					"movil_aspirante" => trim(strtolower($_POST["phone"])),
					"id_role_aspirante" => "20",
					"id_campus_aspirante" => trim($_POST["campus"]),
					"origen_aspirante" => trim(TemplateController::capitalize($_POST["origen"])),
					"ejecutivo_aspirante" => trim(TemplateController::capitalize($_POST["ejecutivo"])),
					"etapacrm_aspirante" => trim(TemplateController::capitalize($_POST["etapa_crm"])),
					"estatus_aspirante" => 1,
					"date_created_aspirante" => date("Y-m-d")

				);

				

				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "aspirantes?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
									fncSweetAlert("success", "Your records were created successfully", "/aspirantes");

								</script>';
				}else{

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncNotie(3, "Error saving record");

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
	Edición Aspirantes
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idAspirantes"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idAspirantes"]){

				$select = "id_aspirante,idcrm_aspirante,name_aspirante,ap_aspirante,am_aspirante,emailpersonal_aspirante,movil_aspirante,program_aspirante,id_role_aspirante,id_campus_aspirante,origen_aspirante,ejecutivo_aspirante,nivel_aspirante,modalidad_aspirante,campana_aspirante,etapacrm_aspirante,beca_aspirante,descuento_aspirante,importe_aspirante,fechareportado_aspirante,matricula_suni_aspirante,dv_suni_aspirante,estatus_aspirante,pipeline_aspirante,sexo_aspirante,date_created_aspirante,date_updated_aspirante";

				$url = "aspirantes?select=".$select."&linkTo=id_aspirante&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);
			
				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		

					if (preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"]) &&
						preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["ap"] ) && 
						preg_match('/^[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["email_personal"] ) ){


					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						$data = "name_aspirante=".trim(TemplateController::capitalize($_POST["name"]))."&ap_aspirante=".trim(TemplateController::capitalize($_POST["ap"]))."&am_aspirante=".trim(TemplateController::capitalize($_POST["am"]))."&emailpersonal_aspirante=".trim(strtolower($_POST["email_personal"]))."&movil_aspirante=".trim(strtolower($_POST["phone"]))."&id_campus_aspirante=".trim($_POST["campus"])."&origen_aspirante=".trim(TemplateController::capitalize($_POST["origen"]))."&ejecutivo_aspirante=".trim(TemplateController::capitalize($_POST["ejecutivo"]))."&etapacrm_aspirante=".trim(TemplateController::capitalize($_POST["etapa_crm"]))."&date_updated_aspirante=".date("Y-m-d H:i:s");

						//$data_user="address_datauser=".trim($_POST["address"])."&phone_datauser=".trim($_POST["phone"])."&movil_datauser=".trim($_POST["movil"]);
						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "aspirantes?id=".$id."&nameId=id_aspirante&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
								fncSweetAlert("success", "Your records were created successfully", "/aspirantes");

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


