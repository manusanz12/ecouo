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
            
            $url = "roles?select=id_role,name_role,permit_role,estatus_role,date_created_role";

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

            $select = "id_role,name_role,permit_role,estatus_role,date_created_role";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){// Validar que no coloquen caracteres alfanumericos

	            	$linkTo = ["name_role","date_created_roles"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);//reemplaza espacio al momento de buscar ajustando un guion bajo

	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "roles?&select=".$select."&linkTo=".$value."&search=".$search."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

                        
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

	            $url = "roles?&select=".$select."&linkTo=date_created_role&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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
	            	
            	}else{
					
					if($value->estatus_role!=2){	
							
							$actions ="<a class='btn btn-success btn-sm rounded-circle stopcatItem' idcatItem='".base64_encode($value->id_role."~".$_GET["token"])."' table='roles' suffix='role' page='roles'>

										<i class='fas fa-eye'></i>

										</a>
										";
					}
					else{
							$actions ="<a class='btn btn-secondary btn-sm rounded-circle activecatItem' idactivecatItem='".base64_encode($value->id_role."~".$_GET["token"])."' table='roles' suffix='role' page='roles'>

										<i class='fas fa-eye-slash'></i>

										</a>
										";
					}					
							$actions .= "<a href='/roles/edit/".base64_encode($value->id_role."~".$_GET["token"])."' class='btn btn-warning btn-sm mr-1 rounded-circle'>
							
										<i class='fas fa-pencil-alt'></i>

										</a>

										<a class='btn btn-danger btn-sm rounded-circle removecatItem' idcatItem='".base64_encode($value->id_role."~".$_GET["token"])."'  table='roles' suffix='role' page='roles'>

										<i class='fas fa-trash'></i>

										</a>";

							

							$actions = TemplateController::htmlClean($actions);
            	}	

                
            	$name_role = $value->name_role;
            	
                $permit_role = "";

            	if($value->permit_role != null){

	            	foreach(json_decode($value->permit_role, true) as $index => $item) {

	            		$permit_role .= $item[array_keys($item)[0]].", ";
	            		
	            	}

	            	$permit_role = substr($permit_role,0,-2);

	            }


				$date_created_role = $value->date_created_role;	

            	$dataJson.='{ 

            		"id_role":"'.($start+$key+1).'",
            		"name_role":"'.$name_role.'",
            		"permit_role":"'.$permit_role.'",
					"date_created_role":"'.$date_created_role.'",
            		"actions":"'.$actions.'"

            	},';

            }

            $dataJson = substr($dataJson,0,-1); // este substr quita el último caracter de la cadena, que es una coma, para impedir que rompa la tabla

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


