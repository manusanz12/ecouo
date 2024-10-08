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

					array_push($permisossuser, ["Create"]);

				}

                if(isset($_POST["p_update"])){	

					array_push($permisossuser, ["Update"]);

				}

                if(isset($_POST["p_suspend"])){	

					array_push($permisossuser, ["Suspend"]);

				}

                if(isset($_POST["p_delete"])){	

					array_push($permisossuser, ["Delete"]);

				}


				if(count($permisossuser) > 0){

					$permisossuser = json_encode($permisossuser);
                    

				}else{

					$permisossuser = null;

                   
				}

				/*=============================================
				Agrupamos los modulos en un json 
				=============================================*/	

                
				$modulesuser = array();

				if(isset($_POST["m_superadmins"])){	

					array_push($modulesuser, ["Super Admin"]);

				}

                if(isset($_POST["m_admins"])){	

					array_push($modulesuser, ["Admins"]);

				}

                if(isset($_POST["m_students"])){	

					array_push($modulesuser, ["Students"]);

				}

                if(isset($_POST["m_teachers"])){	

					array_push($modulesuser, ["Teachers"]);

				}

				if(isset($_POST["m_catalogue"])){	

					array_push($modulesuser, ["Catalogue"]);

				}
				if(isset($_POST["m_dteachers"])){	

					array_push($modulesuser, ["D_Teachers"]);

				}
				if(isset($_POST["m_dstudents"])){	

					array_push($modulesuser, ["D_Students"]);

				}


				if(count($modulesuser) > 0){

					$modulesuser = json_encode($modulesuser);
                    

				}else{

					$modulesuser = null;

                   
				}
                


			   	/*=============================================
				Agrupamos la información 
				=============================================*/	
                
                
				/***************** tabla rol  **************/
				$data = array(

					"name_role" => trim($_POST["name"]),
					"permit_role" => $permisossuser,
					"module_role" => $modulesuser,
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

                            array_push($permisossuser, ["Create"]);
        
                        }
        
                        if(isset($_POST["p_update"])){	
        
                            array_push($permisossuser, ["Update"]);
        
                        }
        
                        if(isset($_POST["p_suspend"])){	
        
                            array_push($permisossuser, ["Suspend"]);
        
                        }
        
                        if(isset($_POST["p_delete"])){	
        
                            array_push($permisossuser, ["Delete"]);
        
                        }
						if(count($permisossuser) > 0){

							$permisossuser = json_encode($permisossuser,true);
							

						}else{

							$permisossuser = null;
						}

						/*=============================================
							Agrupamos los modulos en un json 
							=============================================*/	

							
							$modulesuser = array();

							if(isset($_POST["m_superadmins"])){	

								array_push($modulesuser, ["Super Admin"]);

							}

							if(isset($_POST["m_admins"])){	

								array_push($modulesuser, ["Admins"]);

							}

							if(isset($_POST["m_students"])){	

								array_push($modulesuser, ["Students"]);

							}

							if(isset($_POST["m_teachers"])){	

								array_push($modulesuser, ["Teachers"]);

							}

							if(isset($_POST["m_catalogue"])){	

								array_push($modulesuser, ["Catalogue"]);

							}
							if(isset($_POST["m_dteachers"])){	

								array_push($modulesuser, ["D_Teachers"]);
			
							}
							if(isset($_POST["m_dstudents"])){	
			
								array_push($modulesuser, ["D_Students"]);
			
							}


							if(count($modulesuser) > 0){

								$modulesuser = json_encode($modulesuser);
								

							}else{

								$modulesuser = null;

							
							}


					   	/*=============================================
						Agrupamos la información 
						=============================================*/		

						$data = "name_role=".trim($_POST["name"])."&permit_role=".$permisossuser."&module_role=".$modulesuser."&date_updated_role=".date("Y-m-d H:i:s");

									
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


