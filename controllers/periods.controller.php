<?php

class PeriodsController{


	/*=============================================
	Creación periodo
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

			if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"] ) && 
                preg_match('/^[A-Za-z0-9]{1,}$/', $_POST["year"] )){

			   	/*=============================================
				Agrupamos la información 
				=============================================*/		
				/***************** tabla user  **************/
				$data = array(

					"name_period" => trim($_POST["name"]),
					"year_period" => trim($_POST["year"]),
					"estatus_period" => 1,
					"date_created_period" => date("Y-m-d"),
                    "date_start_period" => trim($_POST["date_start"]),
                    "date_end_period" => trim($_POST["date_end"])

				);

				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "periods?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
                                        fncSweetAlert("success", "Your records were created successfully", "/periods");

                                    </script>';
                

                    }else{

                                echo '<script>

                                    fncFormatInputs();
                                    matPreloader("off");
                                    fncSweetAlert("close", "", "");
                                    fncNotie(3, "Error saving image");

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
	Edición Campus
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idPeriods"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idPeriods"]){

				$select = "*";

				$url = "periods?select=".$select."&linkTo=id_period&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);

                
			
				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		

					if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"] ) && 
                        preg_match('/^[A-Za-z0-9]{1,}$/', $_POST["year"] )){



					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						$data = "name_period=".trim($_POST["name"])."&year_period=".trim($_POST["year"])."&date_updated_period=".date("Y-m-d H:i:s")."&date_start_period=".trim($_POST["date_start"])."&date_end_period=".trim($_POST["date_end"]);

									
						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "periods?id=".$id."&nameId=id_period&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
								fncSweetAlert("success", "Your records were created successfully", "/periods");

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


