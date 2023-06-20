<?php 
	


	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "campuses?select=".$select."&linkTo=id_campus&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$campus = $response->results[0];
				



			}else{

				echo '<script>

				window.location = "/campuses";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/campuses";

			</script>';
	

		}

	}

?>


<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $campus->id_campus ?>" name="idCampus"> 
	
		<div class="card-header">

			<?php

			 	require_once "controllers/campuses.controller.php";

				$create = new CampusController();
				$create -> edit($campus->id_campus);

			?>
			
			<div class="col-md-8 offset-md-2">	

				
				<!--=====================================
                Nombre de campus 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre del campus<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="name"
					value="<?php echo $campus->name_campus ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Nombre Corto de Campus 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Apellido Paterno<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="name_short" 
					value="<?php echo $campus->shortname_campus ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				
				

			</div>

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/campuses" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>