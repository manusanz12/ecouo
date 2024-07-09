<?php
/*=============================================
Traer noticias aleatoriamente
=============================================*/


$randomStart = rand(0, ($totalnews-3));

$select = "url_category,horizontal_slider_noticie,url_noticie,default_banner_noticie,name_noticie";

$url = "relations?rel=noticies,categories&type=noticie,category&orderBy=id_noticie&orderMode=ASC&startAt=".$randomStart."&endAt=2&select=".$select;
$method = "GET";
$fields = array();
$header = array();

$NewsHSlider = CurlController::request($url, $method, $fields, $header)->results;
//echo '<pre>'; print_r($NewsHSlider); echo '</pre>';


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
                                <a class="ps-btn" href="<?php echo $path.$value->url_product ?>"> <?php echo $hSlider["Button tag"] ?></a>
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
     

        


