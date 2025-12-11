<?php 
	

	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));

		
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "id_aspirante,idcrm_aspirante,name_aspirante,ap_aspirante,am_aspirante,emailpersonal_aspirante,program_aspirante,id_role_aspirante,id_campus_aspirante,origen_aspirante,ejecutivo_aspirante,nivel_aspirante,modalidad_aspirante,campana_aspirante,etapacrm_aspirante,beca_aspirante,descuento_aspirante,importe_aspirante,fechareportado_aspirante,matricula_suni_aspirante,dv_suni_aspirante,estatus_aspirante,pipeline_aspirante,sexo_aspirante,date_created_aspirante,date_updated_aspirante,id_role,name_role,id_campus,name_campus";

			$url = "relations?rel=aspirantes,roles,campuses&type=aspirante,role,campus&select=".$select."&linkTo=id_aspirante&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			//echo '<pre>'; print_r($url); echo '</pre>';
			//return;
			if($response->status == 200){

				$admin = $response->results[0];
				



			}else{

				echo '<script>

				window.location = "/aspirantes";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/aspirantes";

			</script>';
	

		}

	}

?>


<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $admin->id_aspirante ?>" name="idAspirantes"> 
	
		<div class="card-header">

			<?php

			 	require_once "controllers/aspirantes.controller.php";

				$create = new AspirantesController();
				$create -> edit($admin->id_aspirante);

			?>
			
			<div class="col-md-8 offset-md-2">	

				<!--=====================================
                Matricula
                ======================================-->
				
				<div class="form-group mt-5">
					
					<label>ID CRM: <?php echo $admin->idcrm_aspirante ?></label>

					<!--<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-z0-9]{1,}"
					onchange="validateRepeat(event,'t&n','users','matricula_user')"
					name="matricula"
					value="<?php echo $admin->idcrm_aspirante ?>" 
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
					value="<?php echo $admin->name_aspirante ?>" 
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
					value="<?php echo $admin->ap_aspirante ?>" 
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
					value="<?php echo $admin->am_aspirante ?>" 
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
					onchange="validateRepeat(event,'email','aspirantes','emailpersonal_aspirante')"
					name="email_personal"
					value="<?php echo $admin->emailpersonal_aspirante ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

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

			                    <?php if ($value->id_campus == $admin->id_campus_aspirante): ?>

			                    	<option value="<?php echo $admin->id_campus_aspirante ?>" selected><?php echo $value->name_campus ?></option>

			                    <?php else: ?>

			                    	<option value="<?php echo $value->id_campus ?>"><?php echo $value->name_campus ?></option>
		
			                    <?php endif ?>	
                  
		                    <?php endforeach ?>

		                </select> 

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>

				<!--=====================================
                Origen 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Origen<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="origen"
					value="<?php echo $admin->origen_aspirante ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Ejecutivo 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Ejecutivo<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="ejecutivo"
					value="<?php echo $admin->ejecutivo_aspirante ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				
				<!--=====================================
                Etapa CRM 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Etapa CRM<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="etapa_crm"
					value="<?php echo $admin->etapacrm_aspirante ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>
				

							
			</div>
			
			<div class="col-md-8 offset-md-2">
				


			</div>

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/aspirantes" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>