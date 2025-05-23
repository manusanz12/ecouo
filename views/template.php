<?php 
session_start();

/*=============================================
Traer el dominio principal
=============================================*/

$path = TemplateController::path();

/*=============================================
Capturar las rutas de la URL
=============================================*/

$routesArray = explode("/", $_SERVER['REQUEST_URI']);
$routesArray = array_filter($routesArray);
//echo '<pre>'; print_r($routesArray); echo '</pre>';
/*=============================================
Limpiar la Url de variables GET
=============================================*/
/*foreach ($routesArray as $key => $value) {

  $value = explode("?", $value)[0];
  $routesArray[$key] = $value;
    
}*/


/*=============================================
Traer el total de noticias y eventos
=============================================*/

$url = "noticies?select=id_noticie";
$method = "GET";
$fields = array();
$header = array();

$datanews = CurlController::request($url, $method, $fields, $header);



if($datanews->status == 200){

    $totalnews = $datanews->total;

}else{

    $totalnews = 0;
}

if(!empty(array_filter($routesArray)[1])){

  $urlGet = explode("?", array_filter($routesArray)[1]);

  $urlParams = explode("&", $urlGet[0]);		
  
}



if(!empty($urlParams[0])){

        /*=============================================
				Validar si hay parámetros de paginación
				=============================================*/
				if(isset($urlParams[1])){

					if(is_numeric($urlParams[1])){


						$startAt = ($urlParams[1]*6) - 6;

					}else{

					 	$startAt = null;

					}

				}else{

					$startAt = 0;
				}

				/*=============================================
				Validar si hay parámetros de orden
				=============================================*/

				if(isset($urlParams[2])){

					if(is_string($urlParams[2])){

						if($urlParams[2] == "new"){

							$orderBy = "id_noticie";
							$orderMode = "DESC";

						}

						else if($urlParams[2] == "latest"){

							$orderBy = "id_noticie";
							$orderMode = "ASC";

						}

						else if($urlParams[2] == "low"){

							$orderBy = "id_noticie";
							$orderMode = "ASC";

						}

						else if($urlParams[2] == "high"){

							$orderBy = "id_noticie";
							$orderMode = "DESC";

						}else{

							$orderBy = "id_noticie";
							$orderMode = "DESC";

						}

					}else{
						
						$orderBy = "id_noticie";
						$orderMode = "DESC";

					}

				}else{

					$orderBy = "id_noticie";
					$orderMode = "DESC";
				}

        $linkTo = ["name_noticie","tags_noticie","description_noticie","url_noticie"];
				$select = "id_noticie,state_noticie,url_noticie,url_category,image_noticie,name_noticie,url_noticie,name_category,offer_noticie,description_noticie,tags_noticie,gallery_noticie,top_banner_noticie,default_banner_noticie,horizontal_slider_noticie,vertical_slider_noticie,video_noticie,views_noticie,reviews_noticie,date_created_noticie";

				foreach ($linkTo  as $key => $value) {

					/*=============================================
			    	Filtrar tabla noticias y eventos con el parámetro URL de búsqueda
			    	=============================================*/

				    $url = "relations?rel=noticies,categories&type=noticie,category&linkTo=".$value.",&search=".$urlParams[0].",show&orderBy=".$orderBy."&orderMode=".$orderMode."&startAt=".$startAt."&endAt=12&select=".$select;
				    $method = "GET";
				    $fields = array();
				    $header = array();
            
				    $urlSearch = CurlController::request($url, $method, $fields, $header);
            
            
				   	
					if($urlSearch->status != 404){

						$select = "id_product";

						$url = "relations?rel=noticies,categories&type=noticie,category&linkTo=".$value.",&search=".$urlParams[0].",show&select=".$select;

						$totalSearch = CurlController::request($url, $method, $fields, $header)->total;

						break;

					}
				
				}

}






?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>ECO UO</title>

  <base href="<?php echo TemplateController::path() ?>">


 

   <!-- Icons -->
  <link rel="icon" href="views/assets/img/template/icono.ico">
  <!-- CSS personalizado -->
  <link rel="stylesheet" href="views/assets/custom/template/style.css">
  <link rel="stylesheet" href="views/assets/custom/template/market.css">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="views/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="views/assets/plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
   <!-- Select2 -->
  <link rel="stylesheet" href="views/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="views/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- Material Preloader -->
  <link rel="stylesheet" href="views/assets/plugins/material-preloader/material-preloader.css">
  <!-- Notie Alert -->
  <link rel="stylesheet" href="views/assets/plugins/notie/notie.css">
  <!-- Linear Icons -->
  <link rel="stylesheet" href="views/assets/plugins/linearicons/linearicons.css">
  <!-- Tags Input -->
  <link rel="stylesheet" href="views/assets/plugins/tags-input/tags-input.css">
   <!-- summernote -->
  <link rel="stylesheet" href="views/assets/plugins/summernote/summernote-bs4.min.css">
   <!-- dropzone-->
  <link rel="stylesheet" href="views/assets/plugins/dropzone/dropzone.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="views/assets/plugins/adminlte/css/adminlte.min.css">
   <!-- Template CSS -->
  <link rel="stylesheet" href="views/assets/custom/template/template.css">
  <!-- CSS personalizado -->
  <link rel="stylesheet" href="views/assets/custom/template/personalizados.css">


 
 <!-- PLUGINS -->
   
  <!-- jQuery -->
   <script src="views/assets/plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="views/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="views/assets/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="views/assets/plugins/adminlte/js/adminlte.min.js"></script>
  <!-- Bootstrap Switch -->
  <script src="views/assets/plugins/bootstrap-switch/js/bootstrap-switch.min.js"></script>
  <!-- Select2 -->
  <script src="views/assets/plugins/select2/js/select2.full.min.js"></script>
  <!-- Material Preloader -->
  <!-- https://www.jqueryscript.net/loading/Google-Inbox-Style-Linear-Preloader-Plugin-with-jQuery-CSS3.html -->
  <script src="views/assets/plugins/material-preloader/material-preloader.js"></script>
  <!-- Notie Alert -->
  <!-- https://jaredreich.com/notie/ -->
  <!-- https://github.com/jaredreich/notie -->
  <script src="views/assets/plugins/notie/notie.min.js"></script>
  <!-- Sweet Alert -->
  <!-- https://sweetalert2.github.io/ -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
  <!-- Tags Input -->
  <!-- https://bootstrap-tagsinput.github.io/bootstrap-tagsinput/examples/ -->
  <script src="views/assets/plugins/tags-input/tags-input.js"></script>

  <!-- Summernote 
  https://github.com/summernote/summernote/-->
  <script src="views/assets/plugins/summernote/summernote-bs4.min.js"></script>

  <!-- Dropzone
  https://docs.dropzone.dev/-->
  <script src="views/assets/plugins/dropzone/dropzone.js"></script>


  <?php if (!empty($routesArray[1]) && !isset($routesArray[2])): ?>

    <?php if ($routesArray[1] == "admins" || 
             $routesArray[1] == "administrators" ||
             $routesArray[1] == "teachers" ||
             $routesArray[1] == "students" ||
             $routesArray[1] == "campuses" ||
             $routesArray[1] == "roles" ||
             $routesArray[1] == "programs" ||
             $routesArray[1] == "categories" ||
             $routesArray[1] == "noticies" ||
             $routesArray[1] == "services" ||
             $routesArray[1] == "periods" ||
             $routesArray[1] == "servicios" ||
             $routesArray[1] == "administrativos" ||
             $routesArray[1] == "search" ||
             $routesArray[1] == "perfiles"): ?>
     
        <!-- DataTables  & Plugins -->
        <link rel="stylesheet" href="views/assets/plugins/daterangepicker/daterangepicker.css">
        <link rel="stylesheet" href="views/assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
        <link rel="stylesheet" href="views/assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
        <link rel="stylesheet" href="views/assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css">

        <script src="views/assets/plugins/moment/moment.min.js"></script>
        <script src="views/assets/plugins/daterangepicker/daterangepicker.js"></script>
        <script src="views/assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="views/assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
        <script src="views/assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
        <script src="views/assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
        <script src="views/assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
        <script src="views/assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
        <script src="views/assets/plugins/jszip/jszip.min.js"></script>
        <script src="views/assets/plugins/pdfmake/pdfmake.min.js"></script>
        <script src="views/assets/plugins/pdfmake/vfs_fonts.js"></script>
        <script src="views/assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
        <script src="views/assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
        <script src="views/assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>


      <?php endif ?>

  <?php endif ?>

  <!-- Chart -->
  <script src="views/assets/plugins/chart/js/Chart.min.js"></script>

  <!-- jQuery Knob Chart -->
  <script src="views/assets/plugins/jquery-knob/jquery.knob.min.js"></script>

  <script src="views/assets/custom/alerts/alerts.js"></script>

</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <?php 

  if(!isset($_SESSION["admin"])){

   include "views/pages/login/login.php"; 

   echo '</body></head>';

   return;

  }


  ?>



<?php if (isset($_SESSION["admin"])): ?>

<!-- Site wrapper -->
<div class="wrapper">
  
  <!-- Navbar -->
  <?php include "views/modules/navbar.php"; ?>

  <!-- Main Sidebar Container -->
  <?php include "views/modules/sidebar.php"; ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <?php

    if(!empty($routesArray[1])){
      

      if($routesArray[1] == "admins" ||
         $routesArray[1] == "administrators" ||
         $routesArray[1] == "teachers" ||
         $routesArray[1] == "students" ||
         $routesArray[1] == "campuses" ||
         $routesArray[1] == "roles" ||
         $routesArray[1] == "programs" ||
         $routesArray[1] == "periods" ||
         $routesArray[1] == "categories" ||
         $routesArray[1] == "noticies" ||
         $routesArray[1] == "services" ||
         $routesArray[1] == "logout" ||
         $routesArray[1] == "servicios"||
         $routesArray[1] == "administrativos"||
         $routesArray[1] == "search" ||
         $routesArray[1] == "perfiles"){
          
        include "views/pages/".$routesArray[1]."/".$routesArray[1].".php";

      }else{

         include "views/pages/404/404.php"; 

      }

    }else{

      include "views/pages/home/home.php"; 
 
    }

    ?>
    <!-- Content Header (Page header) -->
  
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <?php include "views/modules/footer.php"; ?>

</div>
<!-- ./wrapper -->

<?php endif ?>

<script src="views/assets/custom/forms/forms.js"></script>

<!--=====================================
	JS PERSONALIZADO
	======================================-->

	<script src="views/assets/plugins/main.js"></script>

</body>
</html>
