<?php

/*=============================================
Traer Servicios administrativos
=============================================*/


//$randomStart = rand(0, ($totalnews-3));
$randomStart = 0;
$tipo_EN="administrativo";
$select = "url_category,horizontal_slider_service,url_service,image_service,default_banner_service,name_service,link_service,type_service";

$url = "relations?rel=services,categories&type=service,category&orderBy=id_service&orderMode=ASC&startAt=".$randomStart."&endAt=5&select=".$select."&linkTo=type_service&equalTo=".$tipo_EN;
$method = "GET";
$fields = array();
$header = array();

$ServicesAdmHSlider = CurlController::request($url, $method, $fields, $header)->results;


//echo '<pre>'; print_r($ServicesAdmHSlider); echo '</pre>';


?>


<section class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1>Servicios Administrativos</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="/">Home</a></li>

          <?php

            if(isset($routesArray[2])){

               if($routesArray[2] == "new" || $routesArray[2] == "edit"){
                  
                  echo '<li class="breadcrumb-item"><a href="/administrativos">Servicios Administrativos</a></li>';
                  echo '<li class="breadcrumb-item active">'.$routesArray[2].'</li>';
                
                }

            }else{

              echo '<li class="breadcrumb-item active">Servicios Administrativos</li>';
            }
            
          ?>
  
        </ol>
      </div>
    </div>
  </div><!-- /.container-fluid -->
</section>

<!-- Main content -->
<section class="content pb-1">

  <div class="container-fluid">
        <div class="row">
            <?php foreach ($ServicesAdmHSlider as $key => $value): ?>  
                <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                    <span class="info-box-icon bg-info elevation-1"><img src="/views/assets/img/services/<?php echo $value->url_category ?>/<?php echo $value->image_service ?>" alt="<?php echo $value->name_service ?>"></span>
                    

                    <div class="info-box-content">
                        <span class="info-box-text"><?php echo $value->name_service ?></span>
                    </div>
                    <!-- /.info-box-content -->
                    </div>
                    <!-- /.info-box -->
                </div>
            <?php endforeach ?>
            <!-- /.col -->
            

        </div>      

  
  </div>

</section>