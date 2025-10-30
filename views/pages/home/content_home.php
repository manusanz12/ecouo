<?php
/*=============================================
Traer Eventos aleatoriamente
=============================================*/
// Determinar límite de registros según cantidad total
if ($totalnews <= 1) {
    $startAt = 0;
    $endAt = 1; // Solo un registro
} else {
    $randomStart = rand(0, ($totalnews-3));
    $startAt = $randomStart;
    $endAt = 2; // Rango normal
}


$tipo_EN="Evento";
$select = "url_category,horizontal_slider_noticie,url_noticie,default_banner_noticie,name_noticie,type_noticie";

// Verificar rol del usuario
if ($_SESSION['validates']->id_role == 10) {
    // Administrador full: SIN filtro por campus
    $url = "relations?rel=noticies,categories&type=noticie,category"
         . "&orderBy=id_noticie&orderMode=ASC"
         . "&startAt=" . $startAt . "&endAt=" . $endAt
         . "&select=" . $select;
} else {
    // Otros usuarios: CON filtro por campus
    $url = "relations?rel=noticies,categories&type=noticie,category"
         . "&orderBy=id_noticie&orderMode=ASC&relike=likeit"
         . "&startAt=".$startAt."&endAt=".$endAt
         . "&select=".$select
         . "&linkTo=type_noticie,campus_noticie"
         . "&search=".$tipo_EN .",".$_SESSION['validates']->shortname_campus;
}


$method = "GET";
$fields = array();
$header = array();

$NewsHSlider = CurlController::request($url, $method, $fields, $header)->results;

/*=============================================
Traer el total de Servicios academicos
=============================================*/

$tipo_EN="academia";
// Verificar rol del usuario
if ($_SESSION['validates']->id_role == 10) {
    // Administrador full: SIN filtro por campus
    $url = "services?select=id_service&linkTo=type_service&equalTo=".$tipo_EN;
} else {
    // Otros usuarios: CON filtro por campus
    $tipo_EN="academia";
    $url="services?select=campus_service,type_service&linkTo=campus_service,type_service"
          . "&search=" . $_SESSION['validates']->shortname_campus.",". $tipo_EN;
}
$method = "GET";
$fields = array();
$header = array();

$dataService = CurlController::request($url, $method, $fields, $header);




if($dataService->status == 200){

    $totalService_Academi = $dataService->total;

}else{

    $totalService_Academi = 0;
}

//echo '<pre>'; print_r($totalService_Academi); echo '</pre>';
/*=============================================
Traer Servicios academicos por el rol
=============================================*/


$tipo_EN="academia";
$select = "url_category,horizontal_slider_service,url_service,image_service,default_banner_service,name_service,link_service,type_service";

// Verificar rol del usuario
if ($_SESSION['validates']->id_role == 10) {
    // Administrador full: SIN filtro por campus
    $url = "relations?rel=services,categories&type=service,category"
         . "&orderBy=id_service&orderMode=ASC"
         . "&startAt=" . $startAt . "&endAt=" . $endAt
         . "&select=" . $select
         . "&linkTo=type_service&equalTo=".$tipo_EN;
         ;
} else {
    // Otros usuarios: CON filtro por campus
    $url = "relations?rel=services,categories&type=service,category"
         . "&orderBy=id_service&orderMode=ASC&relike=likeit"
         . "&startAt=".$startAt."&endAt=".$endAt
         . "&select=".$select
         . "&linkTo=type_service,campus_service"
         . "&search=".$tipo_EN .",".$_SESSION['validates']->shortname_campus;
}


$method = "GET";
$fields = array();
$header = array();

$ServicesHSlider = CurlController::request($url, $method, $fields, $header)->results;

//echo '<pre>hola'; print_r($ServicesHSlider); echo '</pre>';

/*=============================================
Traer Total de Servicios administrativos
=============================================*/

$tipo_EN="administrativo";
// Verificar rol del usuario
if ($_SESSION['validates']->id_role == 10) {
    // Administrador full: SIN filtro por campus
    $url = "services?select=id_service&linkTo=type_service&equalTo=".$tipo_EN;
} else {
    // Otros usuarios: CON filtro por campus
    $tipo_EN="academia";
    $url="services?select=campus_service,type_service&linkTo=campus_service,type_service"
          . "&search=" . $_SESSION['validates']->shortname_campus.",". $tipo_EN;
}
$method = "GET";
$fields = array();
$header = array();

$dataService = CurlController::request($url, $method, $fields, $header);




if($dataService->status == 200){

    $totalService_Admin = $dataService->total;

}else{

    $totalService_Admin = 0;
}

/*=============================================
Traer Servicios administrativos por el rol
=============================================*/


$tipo_EN="administrativo";
$select = "url_category,horizontal_slider_service,url_service,image_service,default_banner_service,name_service,link_service,type_service";

// Verificar rol del usuario
if ($_SESSION['validates']->id_role == 10) {
    // Administrador full: SIN filtro por campus
    $url = "relations?rel=services,categories&type=service,category"
         . "&orderBy=id_service&orderMode=ASC"
         . "&startAt=" . $startAt . "&endAt=" . $endAt
         . "&select=" . $select
         . "&linkTo=type_service&equalTo=".$tipo_EN;
         ;
} else {
    // Otros usuarios: CON filtro por campus
    $url = "relations?rel=services,categories&type=service,category"
         . "&orderBy=id_service&orderMode=ASC&relike=likeit"
         . "&startAt=".$startAt."&endAt=".$endAt
         . "&select=".$select
         . "&linkTo=type_service,campus_service"
         . "&search=".$tipo_EN .",".$_SESSION['validates']->shortname_campus;
}

$method = "GET";
$fields = array();
$header = array();

$ServicesAdmHSlider = CurlController::request($url, $method, $fields, $header)->results;


//echo '<pre>'; print_r($ServicesAdmHSlider); echo '</pre>';

$V_active="active";
?>
        
        <!-- START Servicios & eventos-->
        <h5 class="mt-4 mb-2"></h5>

        <div class="row">

          <div class="col-md-6">

                      <div class="accordionhome">
                        <div class="accordionhome-item">
                          <div class="accordionhome-header">Servicios Administrativos</div>
                          <div class="accordionhome-content">
                            <div class="accordionhome-buttons">
                                <?php foreach ($ServicesAdmHSlider as $key => $value): ?>
                                  <a href="<?php echo $value->link_service ?>" target="_blank">
                                  <img src="/views/assets/img/services/<?php echo $value->url_category ?>/<?php echo $value->image_service ?>" alt="<?php echo $value->name_service ?>">
                                  <p><?php echo $value->name_service ?></p>
                                  </a> 
                                <?php endforeach ?>
                                 <a href="administrativos" class="btn-mas">Ver más</a>
                            </div>      
                          </div>
                          
                        </div>
                        <div class="accordionhome-item">
                          <div class="accordionhome-header">Servicios Académicos</div>
                          <div class="accordionhome-content">
                            <div class="accordionhome-buttons">
                                  <?php foreach ($ServicesHSlider as $key => $value): ?>
                                    <a href="<?php echo $value->link_service ?>" target="_blank">
                                    <img src="/views/assets/img/services/<?php echo $value->url_category ?>/<?php echo $value->image_service ?>" alt="<?php echo $value->name_service ?>">
                                    <p><?php echo $value->name_service ?></p>
                                    </a> 
                                  <?php endforeach ?> 
                                  <a href="servicios" class="btn-mas">Ver más</a>
                            </div>
                          </div>
                        </div>
                        
                      </div>
                  
          </div>           
              <!-- /.info-box -->
            
          <!-- /.col -->
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Eventos</h3>
              </div>
              <!-- /.card-header -->


              
              <div class="card-body">
                <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
                  <ol class="carousel-indicators">
                    <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
                    <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                  </ol>
                  <div class="carousel-inner">
                  <?php foreach ($NewsHSlider as $key => $value): ?>
                      <?php 

                      $hSlider = json_decode($value->horizontal_slider_noticie, true);
                      
                      ?>  
                      <div class="carousel-item <?php echo $V_active; ?>">
                        <img class="d-block w-100" src="/views/assets/img/noticies/<?php echo $value->url_category  ?>/horizontal/<?php echo $hSlider["IMG tag"]; ?>" alt="First slide" height="300">
                      </div>
                  <?php 
                    $V_active="";
                    endforeach ?>
                    <!--<div class="carousel-item">
                      <img class="d-block w-100" src="https://placehold.it/900x500/3c8dbc/ffffff&text=I+Love+Bootstrap" alt="Second slide">
                    </div>
                    <div class="carousel-item">
                      <img class="d-block w-100" src="https://placehold.it/900x500/f39c12/ffffff&text=I+Love+Bootstrap" alt="Third slide">
                    </div>-->
                  </div>
                  <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
                    <span class="carousel-control-custom-icon" aria-hidden="true">
                      <i class="fas fa-chevron-left"></i>
                    </span>
                    <span class="sr-only">Previous</span>
                  </a>
                  <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
                    <span class="carousel-control-custom-icon" aria-hidden="true">
                      <i class="fas fa-chevron-right"></i>
                    </span>
                    <span class="sr-only">Next</span>
                  </a>
                </div>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
          <!-- /.col -->
        </div>
        <!-- /.row -->
        <!-- END Servicios & eventosL-->


