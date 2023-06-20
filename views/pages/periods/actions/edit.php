<?php 
	


	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "periods?select=".$select."&linkTo=id_period&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$periods = $response->results[0];
				



			}else{

				echo '<script>

				window.location = "/periods";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/periods";

			</script>';
	

		}

	}

?>


<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $periods->id_period ?>" name="idPeriods"> 
	
		<div class="card-header">

			<?php

			 	require_once "controllers/periods.controller.php";

				$create = new PeriodsController();
				$create -> edit($periods->id_period);

			?>
			
			<div class="col-md-8 offset-md-2">	

				
				<!--=====================================
                Nombre de periodo 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre del Periodo<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="name"
					value="<?php echo $periods->name_period ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Año 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Año<sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="year" 
					value="<?php echo $periods->year_period ?>" 
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Fecha inicio
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Feche de apertura de periodo</label>

					<input 
					type="date" 
					class="form-control"
					name="date_start"
					value="<?php echo $periods->date_start_period ?>" 
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Fecha fin
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Feche de cierre de periodo</label>

					<input 
					type="date" 
					class="form-control"
					name="date_end"
					value="<?php echo $periods->date_end_period ?>" 
					>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>
				

			</div>

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/periods" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>