<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/programs.controller.php";

				$create = new ProgramsController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">


				
				<!--=====================================
                Nombre 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre del programa</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="name"
					required>

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
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                CODIGO
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Codigo del programa</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="code_program"
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

					<select class="form-control select2 changeCountry" name="modalidad" >
						
						
						<?php foreach ($modalidad as $key => $value): ?>

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

					<select class="form-control select2 changeCountry" name="nivel" >
						
						
						<?php foreach ($nivel as $key => $value): ?>

							<option value="<?php echo $value["name"] ?>"><?php echo $value["name"] ?></option>
							
						<?php endforeach ?>

					</select>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div> 

				<!--=====================================
                Duracion
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Duración</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'text')"
					name="duration"
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
		        Campus
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Plantel<sup class="text-danger">*</sup></label>

		            <?php 

		            $url = "campuses?select=id_campus,name_campus";
		            $method = "GET";
		            $fields = array();

		            $campuses = CurlController::request($url, $method, $fields)->results;

		            ?>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="campus"
		                style="width:100%"
		                required>

		                    <option value="">Seleccionar Plantel</option>

		                    <?php foreach ($campuses as $key => $value): ?>	

		                        <option value="<?php echo $value->id_campus ?>"><?php echo $value->name_campus ?></option>
		                      
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