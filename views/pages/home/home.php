<?php
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


?>


<section class="content-header">
  
  <div class="container-fluid">

    <!-- BOXES -->
    <?php include "modules/boxes.php"; ?>

        <!--=====================================
        Header Promotion
        ======================================-->
      <!--<?php include "top_banner.php" ?>-->

      <!--=====================================
        Header
        ======================================-->  

        <!--<?php include "header_home.php" ?>-->


      <!--=====================================
        Body
        ======================================-->  

        <?php include "body_home.php" ?>  


  </div>

</section>

