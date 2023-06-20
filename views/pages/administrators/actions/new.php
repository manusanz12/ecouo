<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/administrators.controller.php";

				$create = new AdminsController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">


				<!--=====================================
                Matricula
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Matrícula</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-z0-9]{1,}"
					onchange="validateRepeat(event,'t&n','users','matricula_user')"
					name="matricula"
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Nombre 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre</label>

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
                Apellido Paterno 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Apellido Paterno</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="ap"
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Apellido Materno 
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Apellido Materno</label>

					<input 
					type="text" 
					class="form-control"
					pattern="[A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,}"
					onchange="validateJS(event,'text')"
					name="am"
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Correo electrónico personal
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Correo electrónico Personal</label>

					<input 
					type="email" 
					class="form-control"
					pattern="[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
					onchange="validateRepeat(event,'email','users','email_user')"
					name="email_personal"
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>

				<!--=====================================
                Correo electrónico institucional
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Correo electrónico Institucional</label>

					<input 
					type="email" 
					class="form-control"
					pattern="[.a-zA-Z0-9_]+([.][.a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}"
					onchange="validateRepeat(event,'email','users','email_user')"
					name="email"
					required>

					<div class="valid-feedback">Valido.</div>
            		<div class="invalid-feedback">Por favor revisa el dato.</div>

				</div>


				<!--=====================================
                Contraseña
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Contraseña</label>

					<input 
					type="password" 
					class="form-control"
					pattern="[#\\=\\$\\;\\*\\_\\?\\¿\\!\\¡\\:\\.\\,\\0-9a-zA-Z]{1,}"
					onchange="validateJS(event,'pass')"
					name="password"
					required
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

				<!--=====================================
		        ROL
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Rol<sup class="text-danger">*</sup></label>

		            <?php 

		            $url = "roles?select=id_role,name_role,area_role,estatus_role&linkTo=area_role,estatus_role&equalTo=administrativo,1";
		            $method = "GET";
		            $fields = array();

		            $roles = CurlController::request($url, $method, $fields)->results;

		            ?>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="role"
		                style="width:100%"
		                required>

		                    <option value="">Seleccionar Rol</option>

		                    <?php foreach ($roles as $key => $value): ?>	

		                        <option value="<?php echo $value->id_role ?>"><?php echo $value->name_role ?></option>
		                      
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
					
					<label>Imagen</label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::srcImg() ?>views/img/users/default/default.png" class="img-fluid rounded-circle changePicture" style="width:150px">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changePicture')"
						name="picture"
						required>

						<div class="valid-feedback">Valido.</div>
            			<div class="invalid-feedback">Por favor revisa el dato.</div>

						<label for="customFile" class="custom-file-label">Seleccionar  archivo</label>

					</div>

				</div>

							
			</div>
		

		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/administrators" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right">Guardar</button>

				</div>

			</div>

		</div>


	</form>

</div>