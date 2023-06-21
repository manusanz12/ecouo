<?php 

/*=============================================
total de Programs
=============================================*/

$url = "relations?rel=users,roles&type=user,role&select=id_user,matricula_user,name_user,email_user,id_role_user,id_campus_user,id_role,name_role,area_role&linkTo=area_role&equalTo=administrativo";
$method = "GET";
$fields = array();
$admons = CurlController::request($url,$method,$fields); 

if($admons->status == 200){ 

  $admons = $admons->total;

}else{

$admons = 0;

} 

/*=============================================
total de bajas de estudiantes
=============================================*/
$url = "users?select=id_user,id_role_user,estatus_user&linkTo=id_role_user,estatus_user&equalTo=1,2";
$users = CurlController::request($url,$method,$fields);

if($users->status == 200){ 

$users = $users->total;

}else{

$users = 0;

}  


/*=============================================
total de estudiantes activos
=============================================*/ 

$url = "users?select=id_user,id_role_user,estatus_user&linkTo=id_role_user,estatus_user&equalTo=1,1";
$usersok = CurlController::request($url,$method,$fields); 

if($usersok->status == 200){ 

$usersok = $usersok->total;

}else{

$usersok = 0;

} 

/*=============================================
total de usuarios
=============================================*/
$url = "users?select=id_user,id_role_user,estatus_user&linkTo=id_role_user,estatus_user&equalTo=2,1";
$teachers = CurlController::request($url,$method,$fields);  

if($teachers->status == 200){ 

$teachers = $teachers->total;

}else{

$teachers = 0;

} 

?>


<div class="row">
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box">
      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Administrativo activos</span>
        <span class="info-box-number">
          <?php echo $admons ?>
        </span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-store"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Bajas de estudiantes</span>
        <span class="info-box-number"><?php echo $users ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->

  <!-- fix for small devices only -->
  <div class="clearfix hidden-md-up"></div>

  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Estudiantes activos</span>
        <span class="info-box-number"><?php echo $usersok ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
  <div class="col-12 col-sm-6 col-md-3">
    <div class="info-box mb-3">
      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

      <div class="info-box-content">
        <span class="info-box-text">Docentes activos</span>
        <span class="info-box-number"><?php echo $teachers ?></span>
      </div>
      <!-- /.info-box-content -->
    </div>
    <!-- /.info-box -->
  </div>
  <!-- /.col -->
</div>