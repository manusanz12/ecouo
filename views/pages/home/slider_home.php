<?php
/*=============================================
Traer noticias aleatoriamente
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

$tipo_EN="Noticia";
$select = "url_category,horizontal_slider_noticie,url_noticie,default_banner_noticie,name_noticie,link_noticie,campus_noticie,role_noticie";

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
         . "&linkTo=type_noticie,campus_noticie,role_noticie"
         . "&search=".$tipo_EN.",".$_SESSION['validates']->shortname_campus.",".$_SESSION['validates']->name_role;
}

$method = "GET";
$fields = array();
$header = array();

$NewsHSlider = CurlController::request($url, $method, $fields, $header)->results;

//echo '<pre>'; print_r($_SESSION['validates']->name_role); echo '</pre>';
//echo '<pre>'; print_r($url); echo '</pre>';

?>
    
    <div class="ps-home-banner">
        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">




            <ol class="carousel-indicators">
            <li data-target="#carouselExampleControls" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleControls" data-slide-to="1"></li>
            <li data-target="#carouselExampleControls" data-slide-to="2"></li>
            </ol>
            <?php
            $V_active="active";
            ?>
            <div class="carousel-inner">
                <?php foreach ($NewsHSlider as $key => $value): ?>

                    <?php 

                        $hSlider = json_decode($value->horizontal_slider_noticie, true);
                    
                    ?>    
                    <div class="carousel-item <?php echo $V_active; ?>" data-background="/views/assets/img/noticies/<?php echo $value->url_category  ?>/horizontal/<?php echo $hSlider["IMG tag"]; ?>">
                        <div class="ps-banner--market-4" >
                                <img src="/views/assets/img/noticies/<?php echo $value->url_category  ?>/horizontal/<?php echo $hSlider["IMG tag"]; ?>"  alt="...">
                                <div class="ps-banner__content">
                                <h4><?php echo $hSlider["H4 tag"] ?></h4>
                                <h3><?php echo $hSlider["H3-1 tag"] ?><br/> 
                                    <?php echo $hSlider["H3-2 tag"] ?><br/> 
                                    <p> <?php echo $hSlider["H3-3 tag"] ?> <strong>  <?php echo $hSlider["H3-4s tag"] ?></strong></p>
                                </h3>
                                <!--<a class="ps-btn" href="<?php echo $path.$value->link_noticie ?>"> <?php echo $hSlider["Button tag"] ?></a>-->
                                <a class="ps-btn" href="<?php echo $value->link_noticie ?>" target="_blank"> <?php echo $hSlider["Button tag"] ?></a>
                                </div>
                        </div>        
                    </div>
                <?php 
                $V_active="";
                endforeach ?>
                <!--<div class="carousel-item ">
                <img src="img/slider/horizontal/2.jpg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item ">
                <img src="img/slider/horizontal/3.jpg" class="d-block w-100" alt="...">
                </div>-->
            </div>
            <button class="carousel-control-prev" type="button" data-target="#carouselExampleControls" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-target="#carouselExampleControls" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </button>

        </div>
                


    </div><!-- End Home Banner-->
     

        


