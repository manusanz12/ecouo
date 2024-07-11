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
            
            $url = "services?select=id_service&linkTo=date_created_service&between1=".$_GET["between1"]."&between2=".$_GET["between2"];

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

            $select = "id_service,state_service,url_service,url_category,image_service,name_service,name_category,offer_service,description_service,tags_service,gallery_service,top_banner_service,default_banner_service,horizontal_slider_service,vertical_slider_service,video_service,views_service,reviews_service,date_created_service";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){

	            	$linkTo = ["name_service","tags_service","name_category","date_created_service"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);

	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "relations?rel=services,categories&type=service,category&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

	             $url = "relations?rel=services,categories&type=service,category&select=".$select."&linkTo=date_created_service&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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
	            	$state = $value->state_service;
	            	$image_service = "";
	            	$offer_service = "";
	            	$description_service = "";
	            	$gallery_service = "";
	            	$top_banner_service = "";
	            	$default_banner_service = "";
	            	$horizontal_slider_service = "";
	            	$vertical_slider_service = "";
	            	$video_service = "";
	            	$tags_service = "";
	            	$reviews_service = "";


            	}else{

            		/*=============================================
               	    Actions
                	=============================================*/


                	
                		/*=============================================
               	    	Archivos para borrar de la Noticia
                		=============================================*/

                		$filesDelete = array();

                		$filesDelete = array(  
                			"services/".$value->url_category."/".$value->image_service,
                		    "services/".$value->url_category."/top/".json_decode($value->top_banner_service, true)["IMG tag"],
                		    "services/".$value->url_category."/horizontal/".json_decode($value->horizontal_slider_service, true)["IMG tag"],
                		    "services/".$value->url_category."/default/".$value->default_banner_service,
                		    "services/".$value->url_category."/vertical/".$value->vertical_slider_service
                		);

                		foreach (json_decode($value->gallery_service, true) as $index => $item) {
                			
                			array_push($filesDelete, "services/".$value->url_category."/gallery/".$item);
                		
                		}


	                	$actions = "<div class='btn-group'>

                                <a href='/services/edit/".base64_encode($value->id_service."~".$_GET["token"])."' class='btn btn-warning btn-sm rounded-circle mr-2'>

                                    <i class='fas fa-pencil-alt'></i>

                                </a>

                                <a class='btn btn-danger btn-sm rounded-circle removeItem' idItem='".base64_encode($value->id_service."~".$_GET["token"])."' table='services' suffix='service' deleteFile='".base64_encode(json_encode($filesDelete))."' page='services'>

			            		<i class='fas fa-trash'></i>

			            		</a>

                        </div>";

                   
                	$actions =  TemplateController::htmlClean($actions);

                	/*=============================================
	                State
	                =============================================*/

	                 if($value->state_service == "show"){

	                   $state = "<div class='custom-control custom-switch'><input type='checkbox' class='custom-control-input' id='switch".$key."' checked onchange='changeState(event,".$value->id_service.")'><label class='custom-control-label' for='switch".$key."'></label></div>";

	                }else{

	                     $state = "<div class='custom-control custom-switch'><input type='checkbox' class='custom-control-input' id='switch".$key."' onchange='changeState(event,".$value->id_service.")'><label class='custom-control-label' for='switch".$key."'></label></div>";
	                }

                	
	            	 /*=============================================
	                Image Noticia
	                =============================================*/

	                $image_service = "<img src='".TemplateController::srcImg()."views/assets/img/services/".$value->url_category."/".$value->image_service."' style='width:70px'>";

	              	          
	               
  	
	            	/*=============================================
	                Description Noticia
	                =============================================*/ 

	                $description_service =  TemplateController::htmlClean($value->description_service);
	                $description_service =  preg_replace("/\"/","'",$description_service);

	            	/*=============================================
	                Gallery Noticia
	                =============================================*/ 

	                $gallery_service = "<div class='row'>";

	                foreach (json_decode($value->gallery_service, true) as $item) {

	                    $gallery_service .= "<figure class='col-3'><img src='".TemplateController::srcImg()."views/assets/img/services/".$value->url_category."/gallery/".$item."' style='width:100px'></figure>";
	                    
	                }   

	                $gallery_service .= "</div>";

	            	 /*=============================================
	                Top Banner Noticia
	                =============================================*/

	                $top_banner_service = "<div class='py-3'>

	                    <p><strong>H3 tag:</strong>".json_decode($value->top_banner_service, true)['H3 tag']."</p>
	                    <p><strong>P1 tag:</strong>".json_decode($value->top_banner_service, true)['P1 tag']."</p>
	                    <p><strong>H4 tag:</strong>".json_decode($value->top_banner_service, true)['H4 tag']."</p>
	                    <p><strong>P2 tag:</strong>".json_decode($value->top_banner_service, true)['P2 tag']."</p>
	                    <p><strong>Span tag:</strong>".json_decode($value->top_banner_service, true)['Span tag']."</p>
	                    <p><strong>Button tag:</strong>".json_decode($value->top_banner_service, true)['Button tag']."</p>
	                    <p><strong>IMG tag:</strong></p>
	                    <img src='".TemplateController::srcImg()."views/assets/img/services/".$value->url_category."/top/".json_decode($value->top_banner_service, true)['IMG tag']."' class='img-fluid'>

	                </div>";

	                $top_banner_service = TemplateController::htmlClean($top_banner_service);

	            	  /*=============================================
	                Default Banner Noticia
	                =============================================*/

	                $default_banner_service = "<div><img src='".TemplateController::srcImg()."views/assets/img/services/".$value->url_category."/default/".$value->default_banner_service."' class='img-fluid py-3'></div>";

	            	 /*=============================================
	                Horizontal Slider Noticia
	                =============================================*/

	                $horizontal_slider_service = "<div class='py-3'>

	                    <p><strong>H4 tag:</strong>".json_decode($value->horizontal_slider_service, true)['H4 tag']."</p>
	                    <p><strong>H3-1 tag:</strong>".json_decode($value->horizontal_slider_service, true)['H3-1 tag']."</p>
	                    <p><strong>H3-2 tag:</strong>".json_decode($value->horizontal_slider_service, true)['H3-2 tag']."</p>
	                    <p><strong>H3-3 tag:</strong>".json_decode($value->horizontal_slider_service, true)['H3-3 tag']."</p>
	                    <p><strong>H3-4s tag:</strong>".json_decode($value->horizontal_slider_service, true)['H3-4s tag']."</p>
	                   
	                    <p><strong>Button tag:</strong>".json_decode($value->horizontal_slider_service, true)['Button tag']."</p>
	                    <p><strong>IMG tag:</strong></p>

	                    <img src='".TemplateController::srcImg()."views/assets/img/services/".$value->url_category."/horizontal/".json_decode($value->horizontal_slider_service, true)['IMG tag']."'  class='img-fluid'>

	                </div>";

	                $horizontal_slider_service = TemplateController::htmlClean($horizontal_slider_service);


	            	 /*=============================================
	                Vertical Slider Noticia
	                =============================================*/

	                $vertical_slider_service = "<div><img src='".TemplateController::srcImg()."views/assets/img/services/".$value->url_category."/vertical/".$value->vertical_slider_service."' class='img-fluid py-3'></div>";


	            	 /*=============================================
	                Video Noticia
	                =============================================*/

	                if($value->video_service != null){

	                    if(json_decode($value->video_service,true)[0] == "youtube"){

	                        $video_service = "<iframe 
	                        class='mb-3'
	                        src='https://www.youtube.com/embed/".json_decode($value->video_service,true)[1]."?rel=0&autoplay=0'
	                        height='360' 
	                        frameborder='0'
	                        allowfullscreen></iframe>";
	                    
	                    }else{

	                        $video_service = "<iframe 
	                        class='mb-3'
	                        src='https://player.vimeo.com/video/".json_decode($value->video_service,true)[1]."'
	                        height='360' 
	                        frameborder='0'
	                        allowfullscreen></iframe>";
	                    }

	                    $video_service  =  TemplateController::htmlClean($video_service);

	                }else{

	                    $video_service = "No Video";

	                }

	            	/*=============================================
	                Tags Noticia
	                =============================================*/

	                $tags_service = "";

	                foreach (json_decode($value->tags_service, true) as $item) {
	                    
	                    $tags_service .= $item.", ";
	                }

	                $tags_service = substr($tags_service, 0, -2);


	            	/*=============================================
	                Reviews Noticia
	                =============================================*/

	                $reviews = TemplateController::averageReviews(json_decode($value->reviews_service,true));

	                $reviews_service = "<div>";

	                if($reviews > 0){

	                	for($i = 1; $i <= 5; $i++){

	                		if($reviews < ($i)){

	                			$reviews_service .= "<i class='far fa-star text-warning'></i>";

	                		}else{

	                			$reviews_service .= "<i class='fas fa-star text-warning'></i>";
	                		}


	                	}


	                }else{

		                for($i = 0; $i < 5; $i++){

		                    $reviews_service .= "<i class='far fa-star text-warning'></i>";

		                }

		            }

		            if($value->reviews_service!= null){


		            $reviews_service .= "<div>Total Reviews ".count(json_decode($value->reviews_service,true))."</div>";
		            
		            }


		            $reviews_service .= "</div>";

	              

            	}


            	/*=============================================
                Name Noticia
                =============================================*/

                $name_service = $value->name_service;

               /*=============================================
                Name Category
                =============================================*/

                $name_category = $value->name_category;


                /*=============================================
                Views Noticia
                =============================================*/

                $views_service = $value->views_service;

               /*=============================================
                Fecha de vencimiento del Noticia
                =============================================*/

                $offer_service = $value->offer_service;


              	/*=============================================
                Fecha de creación del Noticia
                =============================================*/

                $date_created_service = $value->date_created_service;


                $dataJson.='{ 
                    "id_service":"'.($start+$key+1).'",
                    "actions":"'.$actions.'",
                    "state":"'.$state.'",
                    "image_service":"'.$image_service.'",
                    "name_service":"'.$name_service.'",
                    "name_category":"'.$name_category.'", 
                    "offer_service":"'.$offer_service.'",
                    "description_service":"'.$description_service.'",
                    "gallery_service":"'.$gallery_service.'",
                    "top_banner_service":"'.$top_banner_service.'",
                    "default_banner_service":"'.$default_banner_service.'",
                    "horizontal_slider_service":"'.$horizontal_slider_service.'",
                    "vertical_slider_service":"'.$vertical_slider_service.'",
                    "video_service":"'.$video_service.'",
                    "tags_service":"'.$tags_service.'",
                    "views_service":"'.$views_service.'",
                    "reviews_service":"'.$reviews_service.'",
                    "date_created_service":"'.$date_created_service.'"
                  
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

