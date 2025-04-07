<?php 
//$url = "relations?rel=noticies,categories&type=noticie,category&linkTo=id_noticie&equalTo=".$randomId."&select=url_category,top_banner_noticie,url_noticie";

$url = "relations?rel=noticies,categories&type=noticie,category&select=url_category,id_noticie,top_banner_noticie,url_noticie,campus_noticie&linkTo=campus_noticie&search=".$_SESSION['validates']->shortname_campus."";
$method = "GET";
$fields = array();
$header = array();
$randomNews_D = CurlController::request($url, $method, $fields, $header);

foreach ($randomNews_D->results as $result) {

    $idArray[] = $result->id_noticie;
    
}

// Elegir un ID al azar
$randomKey = array_rand($idArray);
$randomId = $idArray[$randomKey];


$url = "relations?rel=noticies,categories&type=noticie,category&select=url_category,id_noticie,top_banner_noticie,url_noticie,campus_noticie&linkTo=campus_noticie,id_noticie&search=".$_SESSION['validates']->shortname_campus.",".$randomId;
$method = "GET";
$fields = array();
$header = array();
$randomNews = CurlController::request($url, $method, $fields, $header)->results[0];
$topBanner = json_decode($randomNews->top_banner_noticie, true);

?>
    
    
    <div class="ps-block--promotion-header bg--cover"  style="background: url(../views/assets/img/noticies/<?php echo $randomNews->url_category ?>/top/<?php echo $topBanner["IMG tag"] ?>);">
            <div class="container">
            <div class="ps-block__left">
                <h3><?php echo $topBanner["H3 tag"] ?></h3>
                <figure>
                <p><?php echo $topBanner["P1 tag"]  ?></p>
                <h4><?php echo $topBanner["H4 tag"] ?></h4>
            </figure>
            </div>
            <div class="ps-block__center">
            <p><?php echo $topBanner["P2 tag"] ?><span><?php echo $topBanner["Span tag"] ?></span></p>
            </div><a class="ps-btn ps-btn--sm" href="<?php echo $path.$randomNews->url_category ?>"><?php echo $topBanner["Button tag"] ?></a>
        </div>
    </div>

