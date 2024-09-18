<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/roles.controller.php";

				$create = new RolesController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">


				
				<!--=====================================
                Nombre de Rol
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre de Rol</label>

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
                Permisos
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Permisos</label>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customCreate" name="p_create">
                      <label class="custom-control-label" for="customCreate">Añadir</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customUpdate" name="p_update">
                      <label class="custom-control-label" for="customUpdate">Actualizar</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customsuspend" name="p_suspend">
                      <label class="custom-control-label" for="customsuspend">Suspender</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customDelete" name="p_delete">
                      <label class="custom-control-label" for="customDelete">Eliminar</label>
                    </div>

				</div>

				<!--=====================================
                Módulos
                ======================================-->

                <div class="form-group mt-2">
					
					<label>Módulos</label>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customSuperadmins" name="m_superadmins">
                      <label class="custom-control-label" for="customSuperadmins">Super Admins</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customAdmins" name="m_admins">
                      <label class="custom-control-label" for="customAdmins">Administrativos</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customStudent" name="m_students">
                      <label class="custom-control-label" for="customStudent">Estudiantes</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customTeacher" name="m_teachers">
                      <label class="custom-control-label" for="customTeacher">Maestros</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customCatalogue" name="m_catalogue">
                      <label class="custom-control-label" for="customCatalogue">Catálogos</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customDteachers" name="m_dteachers">
                      <label class="custom-control-label" for="customDteachers">Dashboard Maestro</label>
                    </div>

					<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                      <input type="checkbox" class="custom-control-input" id="customDstudents" name="m_dstudents">
                      <label class="custom-control-label" for="customDstudents">Dashboard Estudiante</label>
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