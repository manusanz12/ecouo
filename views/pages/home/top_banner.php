<?php 

$randomId = rand(1, $totalnews);

$url = "relations?rel=noticies,categories&type=noticie,category&linkTo=id_noticie&equalTo=".$randomId."&select=url_category,top_banner_noticie,url_noticie";
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

