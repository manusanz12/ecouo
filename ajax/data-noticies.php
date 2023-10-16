<?php


require_once "../controllers/curl.controller.php";
require_once "../controllers/template.controller.php";

class DatatableController{

	public function data(){

		if(!empty($_POST)){

			/*=============================================
            Capturando y organizando las variables POST de DT
            =============================================*/
			
			$draw = $_POST["draw"];//Contador utilizado por DataTables para garantizar que los retornos de Ajax de las solicitudes de procesamiento del lado del servidor sean dibujados en secuencia por DataTables 

			$orderByColumnIndex = $_POST['order'][0]['column']; //Índice de la columna de clasificación (0 basado en el índice, es decir, 0 es el primer registro)

			$orderBy = $_POST['columns'][$orderByColumnIndex]["data"];//Obtener el nombre de la columna de clasificación de su índice

			$orderType = $_POST['order'][0]['dir'];// Obtener el orden ASC o DESC

			$start  = $_POST["start"];//Indicador de primer registro de paginación.

            $length = $_POST['length'];//Indicador de la longitud de la paginación.

            /*=============================================
            El total de registros de la data
            =============================================*/
            
            $url = "noticies?select=id_noticie&linkTo=date_created_noticie&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);  
			


			if($response->status == 200){	

				$totalData = $response->total;
			
			}else{

				echo '{"data": []}';

                return;

			}

			/*=============================================
           	Búsqueda de datos
            =============================================*/	

            $select = "id_noticie,state_noticie,url_noticie,url_category,image_noticie,name_noticie,name_category,offer_noticie,description_noticie,tags_noticie,gallery_noticie,top_banner_noticie,default_banner_noticie,horizontal_slider_noticie,vertical_slider_noticie,video_noticie,views_noticie,reviews_noticie,date_created_noticie";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

	            	$linkTo = ["name_noticie","tags_noticie","name_category","date_created_noticie"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);

	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "relations?rel=noticies,categories&type=noticie,category&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

	            		$data = CurlController::request($url,$method,$fields)->results;
						

	            		if($data  == "Not Found"){

	            			$data = array();
	            			$recordsFiltered = count($data);

	            		}else{

	            			$data = $data;
	            			$recordsFiltered = count($data);

	            			break;

	            		}

	            	}

            	}else{

        			echo '{"data": []}';

                	return;

            	}

            }else{

            	/*=============================================
	            Seleccionar datos
	            =============================================*/

	             $url = "relations?rel=noticies,categories&type=noticie,category&select=".$select."&linkTo=date_created_noticie&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

	            $data = CurlController::request($url,$method,$fields)->results;
	           

	            $recordsFiltered = $totalData;

            }

			    /*=============================================
            Cuando la data viene vacía
            =============================================*/

            if(empty($data)){

            	echo '{"data": []}';

            	return;

            }

             /*=============================================
            Construimos el dato JSON a regresar
            =============================================*/


            $dataJson = '{

        	"Draw": '.intval($draw).',
        	"recordsTotal": '.$totalData.',
        	"recordsFiltered": '.$recordsFiltered.',
        	"data": [';

        	/*=============================================
            Recorremos la data
            =============================================*/	

            foreach ($data as $key => $value) {

            	if($_GET["text"] == "flat"){

            		$actions = "";
	            	$state = $value->state_noticie;
	            	$image_noticie = "";
	            	$offer_noticie = "";
	            	$description_noticie = "";
	            	$gallery_noticie = "";
	            	$top_banner_noticie = "";
	            	$default_banner_noticie = "";
	            	$horizontal_slider_noticie = "";
	            	$vertical_slider_noticie = "";
	            	$video_noticie = "";
	            	$tags_noticie = "";
	            	$reviews_noticie = "";


            	}else{

            		/*=============================================
               	    Actions
                	=============================================*/


                	
                		/*=============================================
               	    	Archivos para borrar de la Noticia
                		=============================================*/

                		$filesDelete = array();

                		$filesDelete = array(  
                			"noticies/".$value->url_category."/".$value->image_noticie,
                		    "noticies/".$value->url_category."/top/".json_decode($value->top_banner_noticie, true)["IMG tag"],
                		    "noticies/".$value->url_category."/horizontal/".json_decode($value->horizontal_slider_noticie, true)["IMG tag"],
                		    "noticies/".$value->url_category."/default/".$value->default_banner_noticie,
                		    "noticies/".$value->url_category."/vertical/".$value->vertical_slider_noticie
                		);

                		foreach (json_decode($value->gallery_noticie, true) as $index => $item) {
                			
                			array_push($filesDelete, "noticies/".$value->url_category."/gallery/".$item);
                		
                		}


	                	$actions = "<div class='btn-group'>

                                <a href='/noticies/edit/".base64_encode($value->id_noticie."~".$_GET["token"])."' class='btn btn-warning btn-sm rounded-circle mr-2'>

                                    <i class='fas fa-pencil-alt'></i>

                                </a>

                                <a class='btn btn-danger btn-sm rounded-circle removeItem' idItem='".base64_encode($value->id_noticie."~".$_GET["token"])."' table='noticies' suffix='noticie' deleteFile='".base64_encode(json_encode($filesDelete))."' page='noticies'>

			            		<i class='fas fa-trash'></i>

			            		</a>

                        </div>";

                   
                	$actions =  TemplateController::htmlClean($actions);

                	/*=============================================
	                State
	                =============================================*/

	                 if($value->state_noticie == "show"){

	                   $state = "<div class='custom-control custom-switch'><input type='checkbox' class='custom-control-input' id='switch".$key."' checked onchange='changeState(event,".$value->id_noticie.")'><label class='custom-control-label' for='switch".$key."'></label></div>";

	                }else{

	                     $state = "<div class='custom-control custom-switch'><input type='checkbox' class='custom-control-input' id='switch".$key."' onchange='changeState(event,".$value->id_noticie.")'><label class='custom-control-label' for='switch".$key."'></label></div>";
	                }

                	
	            	 /*=============================================
	                Image Noticia
	                =============================================*/

	                $image_noticie = "<img src='".TemplateController::srcImg()."views/assets/img/noticies/".$value->url_category."/".$value->image_noticie."' style='width:70px'>";

	              	          
	               
  	
	            	/*=============================================
	                Description Noticia
	                =============================================*/ 

	                $description_noticie =  TemplateController::htmlClean($value->description_noticie);
	                $description_noticie =  preg_replace("/\"/","'",$description_noticie);

	            	/*=============================================
	                Gallery Noticia
	                =============================================*/ 

	                $gallery_noticie = "<div class='row'>";

	                foreach (json_decode($value->gallery_noticie, true) as $item) {

	                    $gallery_noticie .= "<figure class='col-3'><img src='".TemplateController::srcImg()."views/assets/img/noticies/".$value->url_category."/gallery/".$item."' style='width:100px'></figure>";
	                    
	                }   

	                $gallery_noticie .= "</div>";

	            	 /*=============================================
	                Top Banner Noticia
	                =============================================*/

	                $top_banner_noticie = "<div class='py-3'>

	                    <p><strong>H3 tag:</strong>".json_decode($value->top_banner_noticie, true)['H3 tag']."</p>
	                    <p><strong>P1 tag:</strong>".json_decode($value->top_banner_noticie, true)['P1 tag']."</p>
	                    <p><strong>H4 tag:</strong>".json_decode($value->top_banner_noticie, true)['H4 tag']."</p>
	                    <p><strong>P2 tag:</strong>".json_decode($value->top_banner_noticie, true)['P2 tag']."</p>
	                    <p><strong>Span tag:</strong>".json_decode($value->top_banner_noticie, true)['Span tag']."</p>
	                    <p><strong>Button tag:</strong>".json_decode($value->top_banner_noticie, true)['Button tag']."</p>
	                    <p><strong>IMG tag:</strong></p>
	                    <img src='".TemplateController::srcImg()."views/assets/img/noticies/".$value->url_category."/top/".json_decode($value->top_banner_noticie, true)['IMG tag']."' class='img-fluid'>

	                </div>";

	                $top_banner_noticie = TemplateController::htmlClean($top_banner_noticie);

	            	  /*=============================================
	                Default Banner Noticia
	                =============================================*/

	                $default_banner_noticie = "<div><img src='".TemplateController::srcImg()."views/assets/img/noticies/".$value->url_category."/default/".$value->default_banner_noticie."' class='img-fluid py-3'></div>";

	            	 /*=============================================
	                Horizontal Slider Noticia
	                =============================================*/

	                $horizontal_slider_noticie = "<div class='py-3'>

	                    <p><strong>H4 tag:</strong>".json_decode($value->horizontal_slider_noticie, true)['H4 tag']."</p>
	                    <p><strong>H3-1 tag:</strong>".json_decode($value->horizontal_slider_noticie, true)['H3-1 tag']."</p>
	                    <p><strong>H3-2 tag:</strong>".json_decode($value->horizontal_slider_noticie, true)['H3-2 tag']."</p>
	                    <p><strong>H3-3 tag:</strong>".json_decode($value->horizontal_slider_noticie, true)['H3-3 tag']."</p>
	                    <p><strong>H3-4s tag:</strong>".json_decode($value->horizontal_slider_noticie, true)['H3-4s tag']."</p>
	                   
	                    <p><strong>Button tag:</strong>".json_decode($value->horizontal_slider_noticie, true)['Button tag']."</p>
	                    <p><strong>IMG tag:</strong></p>

	                    <img src='".TemplateController::srcImg()."views/assets/img/noticies/".$value->url_category."/horizontal/".json_decode($value->horizontal_slider_noticie, true)['IMG tag']."'  class='img-fluid'>

	                </div>";

	                $horizontal_slider_noticie = TemplateController::htmlClean($horizontal_slider_noticie);


	            	 /*=============================================
	                Vertical Slider Noticia
	                =============================================*/

	                $vertical_slider_noticie = "<div><img src='".TemplateController::srcImg()."views/assets/img/noticies/".$value->url_category."/vertical/".$value->vertical_slider_noticie."' class='img-fluid py-3'></div>";


	            	 /*=============================================
	                Video Noticia
	                =============================================*/

	                if($value->video_noticie != null){

	                    if(json_decode($value->video_noticie,true)[0] == "youtube"){

	                        $video_noticie = "<iframe 
	                        class='mb-3'
	                        src='https://www.youtube.com/embed/".json_decode($value->video_noticie,true)[1]."?rel=0&autoplay=0'
	                        height='360' 
	                        frameborder='0'
	                        allowfullscreen></iframe>";
	                    
	                    }else{

	                        $video_noticie = "<iframe 
	                        class='mb-3'
	                        src='https://player.vimeo.com/video/".json_decode($value->video_noticie,true)[1]."'
	                        height='360' 
	                        frameborder='0'
	                        allowfullscreen></iframe>";
	                    }

	                    $video_noticie  =  TemplateController::htmlClean($video_noticie);

	                }else{

	                    $video_noticie = "No Video";

	                }

	            	/*=============================================
	                Tags Noticia
	                =============================================*/

	                $tags_noticie = "";

	                foreach (json_decode($value->tags_noticie, true) as $item) {
	                    
	                    $tags_noticie .= $item.", ";
	                }

	                $tags_noticie = substr($tags_noticie, 0, -2);


	            	/*=============================================
	                Reviews Noticia
	                =============================================*/

	                $reviews = TemplateController::averageReviews(json_decode($value->reviews_noticie,true));

	                $reviews_noticie = "<div>";

	                if($reviews > 0){

	                	for($i = 1; $i <= 5; $i++){

	                		if($reviews < ($i)){

	                			$reviews_noticie .= "<i class='far fa-star text-warning'></i>";

	                		}else{

	                			$reviews_noticie .= "<i class='fas fa-star text-warning'></i>";
	                		}


	                	}


	                }else{

		                for($i = 0; $i < 5; $i++){

		                    $reviews_noticie .= "<i class='far fa-star text-warning'></i>";

		                }

		            }

		            if($value->reviews_noticie!= null){


		            $reviews_noticie .= "<div>Total Reviews ".count(json_decode($value->reviews_noticie,true))."</div>";
		            
		            }


		            $reviews_noticie .= "</div>";

	              

            	}


            	/*=============================================
                Name Noticia
                =============================================*/

                $name_noticie = $value->name_noticie;

               /*=============================================
                Name Category
                =============================================*/

                $name_category = $value->name_category;


                /*=============================================
                Views Noticia
                =============================================*/

                $views_noticie = $value->views_noticie;

               /*=============================================
                Fecha de vencimiento del Noticia
                =============================================*/

                $offer_noticie = $value->offer_noticie;


              	/*=============================================
                Fecha de creación del Noticia
                =============================================*/

                $date_created_noticie = $value->date_created_noticie;


                $dataJson.='{ 
                    "id_noticie":"'.($start+$key+1).'",
                    "actions":"'.$actions.'",
                    "state":"'.$state.'",
                    "image_noticie":"'.$image_noticie.'",
                    "name_noticie":"'.$name_noticie.'",
                    "name_category":"'.$name_category.'", 
                    "offer_noticie":"'.$offer_noticie.'",
                    "description_noticie":"'.$description_noticie.'",
                    "gallery_noticie":"'.$gallery_noticie.'",
                    "top_banner_noticie":"'.$top_banner_noticie.'",
                    "default_banner_noticie":"'.$default_banner_noticie.'",
                    "horizontal_slider_noticie":"'.$horizontal_slider_noticie.'",
                    "vertical_slider_noticie":"'.$vertical_slider_noticie.'",
                    "video_noticie":"'.$video_noticie.'",
                    "tags_noticie":"'.$tags_noticie.'",
                    "views_noticie":"'.$views_noticie.'",
                    "reviews_noticie":"'.$reviews_noticie.'",
                    "date_created_noticie":"'.$date_created_noticie.'"
                  
                },';



            }

            $dataJson = substr($dataJson,0,-1);


            $dataJson .= ']}';

            echo $dataJson;






		}



	}

}

/*=============================================
Activar función DataTable
=============================================*/ 

$data = new DatatableController();
$data -> data();

