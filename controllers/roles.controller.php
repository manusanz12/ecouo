<?php

class RolesController{


	/*=============================================
	Creación Rol
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

			if(preg_match('/^[A-Za-z0-9]{1,}$/', $_POST["name"] )){


                /*=============================================
				Agrupamos los permisos en un json 
				=============================================*/	

                
				$permisossuser = array();

				if(isset($_POST["p_create"])){	

					array_push($permisossuser, ["Create"=> "Agregar"]);

				}

                if(isset($_POST["p_update"])){	

					array_push($permisossuser, ["Update"=> "Actualizar"]);

				}

                if(isset($_POST["p_suspend"])){	

					array_push($permisossuser, ["Suspend"=> "Suspender"]);

				}

                if(isset($_POST["p_delete"])){	

					array_push($permisossuser, ["Delete"=> "Eliminar"]);

				}


				if(count($permisossuser) > 0){

					$permisossuser = json_encode($permisossuser);
                    

				}else{

					$permisossuser = null;

                   
				}
                


			   	/*=============================================
				Agrupamos la información 
				=============================================*/	
                
                
				/***************** tabla rol  **************/
				$data = array(

					"name_role" => trim($_POST["name"]),
					"permit_role" => $permisossuser,
					"estatus_role" => 1,
					"date_created_role" => date("Y-m-d")

				);

				/*=============================================
				Solicitud a la API
				=============================================*/		

				$url = "roles?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
                                        fncSweetAlert("success", "Your records were created successfully", "/roles");

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
	Edición ROl
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idRoles"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idRoles"]){

				$select = "*";

				$url = "roles?select=".$select."&linkTo=id_role&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);

                
			
				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		

					if(preg_match('/^[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}$/', $_POST["name"])){


                        /*=============================================
						Agrupamos permisos
						=============================================*/	

						$permisossuser = array();

						if(isset($_POST["p_create"])){	

                            array_push($permisossuser, ["Create"=> "Agregar"]);
        
                        }
        
                        if(isset($_POST["p_update"])){	
        
                            array_push($permisossuser, ["Update"=> "Actualizar"]);
        
                        }
        
                        if(isset($_POST["p_suspend"])){	
        
                            array_push($permisossuser, ["Suspend"=> "Suspender"]);
        
                        }
        
                        if(isset($_POST["p_delete"])){	
        
                            array_push($permisossuser, ["Delete"=> "Eliminar"]);
        
                        }
						if(count($permisossuser) > 0){

							$permisossuser = json_encode($permisossuser);

						}else{

							$permisossuser = null;
						}


					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						$data = "name_role=".trim($_POST["name"])."&permit_role=".$permisossuser."&date_updated_role=".date("Y-m-d H:i:s");

									
						/*=============================================
						Solicitud a la API
						=============================================*/		

						$url = "roles?id=".$id."&nameId=id_role&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
								fncSweetAlert("success", "Your records were created successfully", "/roles");

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


