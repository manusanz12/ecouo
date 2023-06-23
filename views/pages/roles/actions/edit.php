<?php 
	


	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "roles?select=".$select."&linkTo=id_role&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$roles = $response->results[0];
				



			}else{

				echo '<script>

				window.location = "/roles";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/roles";

			</script>';
	

		}

	}

?>


<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $roles->id_role ?>" name="idRoles"> 
	
		<div class="card-header">

			<?php

			 	require_once "controllers/roles.controller.php";

				$create = new RolesController();
				$create -> edit($roles->id_role);

			?>
			
			<div class="col-md-8 offset-md-2">	

				
				<!--=====================================
                Nombre de rol 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre del campus<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="name"
					value="<?php echo $roles->name_role ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>
				<!--=====================================
                Permiso de Rol
                ======================================-->

				<?php

                	$p_create = ""; 
                	$p_update = ""; 
                	$p_suspend = ""; 
                	$p_delete = ""; 
                	
                	if($roles->permit_role != null){

											
                		foreach (json_decode($roles->permit_role, true) as $value) {
														
                			if($value[0] == "Create"){

                				$p_create = "checked";
								
                			}

                			if($value[0] == "Update"){

                				$p_update =  "checked";
								
                			}

                			if($value[0] == "Suspend"){

                				$p_suspend =  "checked";
								
                			}

                			if($value[0] == "Delete"){

                				$p_delete =  "checked";
								
                			}

                			                			
                		}
						

                	}

                	?>

					<!--=====================================
					Permiso de Rol
					======================================-->

					<?php

						$m_superadmins = ""; 
						$m_admins = ""; 
						$m_students = ""; 
						$m_teachers = ""; 
						$m_catalogue = ""; 

						if($roles->module_role != null){

							foreach (json_decode($roles->module_role, true) as $value) {

								if($value[0] == "Super Admin"){

									$m_superadmins = "checked";

								}

								if($value[0] == "Admins"){

									$m_admins =  "checked";

								}

								if($value[0] == "Students"){

									$m_students =  "checked";

								}

								if($value[0] == "Teachers"){

									$m_teachers =  "checked";

								}
								if($value[0] == "Catalogue"){

									$m_catalogue =  "checked";

								}

															
							}


						}

					?>

								
				<div class="form-group mt-2">
					
					<label>Permisos</label>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customCreate" name="p_create" <?php echo $p_create ?>>
                      <label class="custom-control-label" for="customCreate">Añadir</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customUpdate" name="p_update" <?php echo $p_update ?>>
                      <label class="custom-control-label" for="customUpdate">Actualizar</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customsuspend" name="p_suspend" <?php echo $p_suspend ?>>
                      <label class="custom-control-label" for="customsuspend">Suspender</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customDelete" name="p_delete" <?php echo $p_delete ?>>
                      <label class="custom-control-label" for="customDelete">Eliminar</label>
                    </div>

				</div>

				<div class="form-group mt-2">
					
					<label>Módulos</label>

							<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
							<input type="checkbox" class="custom-control-input" id="customSuperadmins" name="m_superadmins" <?php echo $m_superadmins ?>>
							<label class="custom-control-label" for="customSuperadmins">Super Admins</label>
							</div>

							<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
							<input type="checkbox" class="custom-control-input" id="customAdmins" name="m_admins" <?php echo $m_admins ?>>
							<label class="custom-control-label" for="customAdmins">Administrativos</label>
							</div>

							<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
							<input type="checkbox" class="custom-control-input" id="customStudent" name="m_students" <?php echo $m_students ?>>
							<label class="custom-control-label" for="customStudent">Estudiantes</label>
							</div>

							<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
							<input type="checkbox" class="custom-control-input" id="customTeacher" name="m_teachers" <?php echo $m_teachers ?>>
							<label class="custom-control-label" for="customTeacher">Maestros</label>
							</div>

							<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
							<input type="checkbox" class="custom-control-input" id="customCatalogue" name="m_catalogue" <?php echo $m_catalogue ?>>
							<label class="custom-control-label" for="customCatalogue">Catálogos</label>
							</div>

				</div>

				
				

			</div>

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/roles" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>