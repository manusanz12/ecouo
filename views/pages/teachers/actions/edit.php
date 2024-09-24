<?php 
	


	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "id_user,matricula_user,name_user,ap_user,am_user,emailpersonal_user,email_user,picture_user,id_datauser,phone_datauser,movil_datauser,address_datauser,postalcode_datauser,sex_datauser,tiposangre_datauser,pais_datauser,state_datauser,town_datauser,age_datauser,nationality_datauser,id_role_user,id_campus_user,id_role,name_role,id_campus,name_campus";

			$url = "relations?rel=users,datausers,roles,campuses&type=user,datauser,role,campus&select=".$select."&linkTo=id_user&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$admin = $response->results[0];
				



			}else{

				echo '<script>

				window.location = "/teachers";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/teachers";

			</script>';
	

		}

	}

?>


<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $admin->id_user ?>" name="idTeacher"> 
	
		<div class="card-header">

			<?php

			 	require_once "controllers/teachers.controller.php";

				$create = new TeachersController();
				$create -> edit($admin->id_user);

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Matricula
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>Matrícula: <?php echo $admin->matricula_user ?></label>

					<!--<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-z0-9]{1,}"
					onchange="validateRepeat(event,'t&n','users','matricula_user')"
					name="matricula"
					value="<?php echo $admin->matricula_user ?>" 
					>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>-->

				</div>

				<!--=====================================
                Nombre 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="name"
					value="<?php echo $admin->name_user ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Apellido Paterno 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Apellido Paterno<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="ap" 
					value="<?php echo $admin->ap_user ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Apellido Materno 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Apellido Materno<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="am"
					value="<?php echo $admin->am_user ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Correo electrónico personal
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Correo electrónico Personal<sup class="text-danger">*</sup></label>

					<input 
					type="email" 
					class="form-control"
					pattern="[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
					onchange="validateRepeat(event,'email','users','email_user')"
					name="email_personal"
					value="<?php echo $admin->emailpersonal_user ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Correo electrónico institucional
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Correo electrónico Institucional<sup class="text-danger">*</sup></label>

					<input 
					type="email" 
					class="form-control"
					pattern="[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
					onchange="validateRepeat(event,'email','users','email_user')"
					name="email"
					value="<?php echo $admin->email_user ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>



				<!--=====================================
                Contraseña
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Password</label>

					<input 
					type="password" 
					class="form-control"
					pattern="[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}"
					onchange="validateJS(event,'pass')" 
					name="password"
					placeholder="*******"
					>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>

				<!--=====================================
		        Campus
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Campus<sup class="text-danger">*</sup></label>

		            <?php 

		            $url = "campuses?select=id_campus,name_campus";
		            $method = "GET";
		            $fields = array();

		            $campuses = CurlController::request($url, $method, $fields)->results; 
					
		            ?>

		            <div class="form-group my-4__content">
		                
		                <select
		                class="form-control select2"
		                name="campus"
		                style="width:100%"
		                onchange="changeCategory(event)"
		                required>
		                   
		                    <?php foreach ($campuses as $key => $value): ?>

			                    <?php if ($value->id_campus == $admin->id_campus_user): ?>

									<option value="<?php echo $admin->id_campus_user ?>" selected><?php echo $value->name_campus ?></option>

			                    <?php else: ?>

			                    	<option value="<?php echo $value->id_campus ?>"><?php  echo $value->name_campus ?></option>
		
			                    <?php endif ?>	
								
		                    <?php endforeach ?>

		                </select> 

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>


				<!--=====================================
                Foto
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Picture</label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::returnImg($admin->id_user,$admin->picture_user,'direct') ?>" class="img-fluid rounded-circle changePicture" style="width:150px">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changePicture')" 
						name="picture">

						<div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

						<label for="customFile" class="custom-file-label">Choose file</label>

					</div>

				</div>

							
			</div>
			
			<div class="col-md-8 offset-md-2">
				
				<!--=====================================
                Teléfono
                ======================================-->

                <div class="form-group mt-2 mb-5">
					
					<label>Teléfono</label>

					<div class="input-group">

						<!--<div class="input-group-append">
							<span class="input-group-text dialCode">Aqui si se usa el odigo de area por país</span>
						</div>-->

						<input 
						type="text" 
						class="form-control"
						pattern="[-\\(\\)\\0-9 ]{1,}"
						onchange="validateJS(event,'phone')"
						name="phone"
						value="<?php echo $admin->phone_datauser?>"
						>

					</div>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>						

				<!--=====================================
                Teléfono Movil
                ======================================-->

                <div class="form-group mt-2 mb-5">
					
					<label>Móvil</label>

					<div class="input-group">

						<!--<div class="input-group-append">
							<span class="input-group-text dialCode">Aqui si se usa el odigo de area por país</span>
						</div>-->

						<input 
						type="text" 
						class="form-control"
						pattern="[-\\(\\)\\0-9 ]{1,}"
						onchange="validateJS(event,'phone')"
						name="movil"
						value="<?php echo $admin->movil_datauser?>"
						>

					</div>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>		

				<!--=====================================
                Sexo
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Sexo</label>

					<?php 

					$tipo_sexo = file_get_contents("views/assets/json/sexo.json");
					$tipo_sexo = json_decode($tipo_sexo, true);
					
					?>

					<select class="form-control select2 " name="tipo_sexo" >
						
						
						<?php foreach ($tipo_sexo as $key => $value):?>
							<?php if ($value["code"]== $admin->sex_datauser): ?>
								<option value="<?php echo $value["code"] ?>" selected><?php echo $value["name"] ?></option>
							<?php endif; ?>		
								<option value="<?php echo $value["code"] ?>"><?php echo $value["name"] ?></option>
							
						<?php endforeach ?>

					</select>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>  
				
				<!--=====================================
                Dirección
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Dirección</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="address"
					value="<?php echo $admin->address_datauser ?>"
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Codigo Postal
                ======================================-->

                <div class="form-group mt-2 mb-5">
					
					<label>Codigo Postal</label>

					<div class="input-group">

						<div class="input-group-append">
							<!--<span class="input-group-text dialCode">Aqui si se usa el odigo de area por país</span>-->
						</div>

						<input 
						type="text" 
						class="form-control"
						pattern="[-\\(\\)\\0-9 ]{1,}"
						onchange="validateJS(event,'phone')"
						name="postalcode"
						value="<?php echo $admin->postalcode_datauser?>"
						>

					</div>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>	
				
				<!--=====================================
                Tipo de sangre
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Tipo de sangre</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="tsangre"
					value="<?php echo $admin->tiposangre_datauser ?>"
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                País
                ======================================-->

				<div class="form-group mt-2">
					
					<label>País</label>

					<?php 

					$countries = file_get_contents("views/assets/json/countries.json");
					$countries = json_decode($countries, true);

					?>

					<select class="form-control select2 changeCountry" name="country" >
						
						
						<?php foreach ($countries as $key => $value): ?>

							<?php if ($value["name"]== $admin->pais_datauser): ?>
								<option value="<?php echo $value["name"] ?>" selected><?php echo $value["name"] ?></option>
							<?php endif; ?>		

							<option value="<?php echo $value["name"] ?>"><?php echo $value["name"] ?></option>
							
						<?php endforeach ?>

					</select>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>  


				<!--=====================================
                Estado
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Estado</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="state"
					value="<?php echo $admin->state_datauser ?>" 
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Municipio
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Municipio</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="town"
					value="<?php echo $admin->town_datauser ?>" 
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Nacionalidad
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nacionalidad</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="nationality"
					value="<?php echo $admin->nationality_datauser ?>" 
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

			</div>

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/teachers" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>