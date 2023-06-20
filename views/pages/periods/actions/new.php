<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/periods.controller.php";

				$create = new PeriodsController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">


				
				
				<!--=====================================
                Nombre de Periodo
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Nombre del Periodo</label>

					<input 
					type="text" 
					class="form-control"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="name"
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Year
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Año</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[-\\(\\)\\0-9 ]{1,}"
					onchange="validateJS(event,'phone')"
					name="year"
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