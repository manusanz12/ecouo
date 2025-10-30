<?php
/*=============================================
Traer el total de noticias
=============================================*/



// Verificar rol del usuario
if ($_SESSION['validates']->id_role == 10) {
    // Administrador full: SIN filtro por campus
    $url = "noticies?select=id_noticie";
} else {
    // Otros usuarios: CON filtro por campus
    $tipo_EN="Noticia";
    $url="noticies?select=campus_noticie,type_noticie&linkTo=campus_noticie,type_noticie"
          . "&search=" . $_SESSION['validates']->shortname_campus.",". $tipo_EN;
}
$method = "GET";
$fields = array();
$header = array();

$datanews = CurlController::request($url, $method, $fields, $header);


//echo '<pre>hola'; print_r($datanews); echo '</pre>';

if($datanews->status == 200){

    $totalnews = $datanews->total;

}else{

    $totalnews = 0;
}

//echo '<pre>'; print_r($totalnews); echo '</pre>';

?>


<section class="content-header">
  
  <div class="container-fluid">

    <!-- BOXES -->
    <?php 
    
    include "modules/boxes.php"; 

    ?>

        <!--=====================================
        Header Promotion
        ======================================-->
      <?php //include "top_banner.php" ?>

      <!--=====================================
        Header
        ======================================-->  

        <?php //include "header_home.php" ?>


      <!--=====================================
        Body
        ======================================-->  

        <?php 
          include "body_home.php" 
        ?>  


  </div>

</section>

