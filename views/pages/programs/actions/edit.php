<?php 
	


	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "id_program,name_program,rvoe_program,code_program,mode_program,level_program,duration_program,id_campus_program,estatus_program,date_created_program,id_campus,name_campus";

			$url = "relations?rel=programs,campuses&type=program,campus&select=".$select."&linkTo=id_program&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);



			if($response->status == 200){

				$programs = $response->results[0];
				



			}else{

				echo '<script>

				window.location = "/programs";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/programs";

			</script>';
	

		}

	}

?>


<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $programs->id_program ?>" name="idPrograms"> 
	
		<div class="card-header">

			<?php

			 	require_once "controllers/programs.controller.php";

				$create = new ProgramsController();
				$create -> edit($programs->id_program);

			?>
			
			<div class="col-md-8 offset-md-2">	
				<!--=====================================
                Nombre del Programa
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Nombre del Programa</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="name"
					value="<?php echo $programs->name_program ?>"
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                RVOE
                ======================================-->

                <div class="form-group mt-2">
					
					<label>RVOE</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="rvoe"
					value="<?php echo $programs->rvoe_program ?>"
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>


				<!--=====================================
                Codigo
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Codigo del Programa</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="code_program"
					value="<?php echo $programs->code_program ?>"
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Modalidad
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Modalidad</label>

					<?php 

					$modalidad = file_get_contents("views/assets/json/modalidad.json");
					$modalidad = json_decode($modalidad, true);
					
					?>

					<select class="form-control select2 " name="modalidad" >
						
						
						<?php foreach ($modalidad as $key => $value):?>
							<?php if ($value["name"]== $programs->mode_program): ?>
								<option value="<?php echo $value["name"] ?>" selected><?php echo $value["name"] ?></option>
							<?php endif; ?>		
								<option value="<?php echo $value["name"] ?>"><?php echo $value["name"] ?></option>
							
						<?php endforeach ?>

					</select>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>  

				<!--=====================================
                Nivel
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Nivel</label>

					<?php 

					$nivel = file_get_contents("views/assets/json/nivel.json");
					$nivel = json_decode($nivel, true);
					
					?>

					<select class="form-control select2 " name="nivel" >
						
						
						<?php foreach ($nivel as $key => $value):?>
							<?php if ($value["name"]== $programs->level_program): ?>
								<option value="<?php echo $value["name"] ?>" selected><?php echo $value["name"] ?></option>
							<?php endif; ?>		
								<option value="<?php echo $value["name"] ?>"><?php echo $value["name"] ?></option>
							
						<?php endforeach ?>

					</select>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>  

				<!--=====================================
                Duración
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Duración</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="duration"
					value="<?php echo $programs->duration_program ?>"
					>

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

			                    <?php if ($value->id_campus == $programs->id_campus_program): ?>

			                    	<option value="<?php echo $programs->id_campus_program ?>" selected><?php echo $value->name_campus ?></option>

			                    <?php else: ?>

			                    	<option value="<?php echo $value->id_campus ?>"><?php echo $value->name_campus ?></option>
		
			                    <?php endif ?>	
                  
		                    <?php endforeach ?>

		                </select> 

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>
				
				

				

			</div>

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/programs" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>