<?php

require_once "../controllers/curl.controller.php";
require_once "../controllers/template.controller.php";

class DatatableController{

	public function data(){

			session_start();	
			/****Validar permisos */
			require "../views/modules/pvalidate.php";
			
			
			/***********************************************
			 Validar permisos
			***********************************************/
            $p_update=Pvalidate::Validatepermit("Update",$_SESSION["validates"]->permit_role);
		    $p_suspend=Pvalidate::Validatepermit("Suspend",$_SESSION["validates"]->permit_role);
            $p_delete=Pvalidate::Validatepermit("Delete",$_SESSION["validates"]->permit_role);

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
            
            $url = "relations?rel=aspirantes,roles,campuses&type=aspirante,role,campus&select=id_aspirante,idcrm_aspirante,name_aspirante,ap_aspirante,am_aspirante,emailpersonal_aspirante,movil_aspirante,program_aspirante,id_role_aspirante,id_campus_aspirante,origen_aspirante,ejecutivo_aspirante,nivel_aspirante,modalidad_aspirante,campana_aspirante,etapacrm_aspirante,beca_aspirante,descuento_aspirante,importe_aspirante,fechareportado_aspirante,matricula_suni_aspirante,dv_suni_aspirante,estatus_aspirante,pipeline_aspirante,sexo_aspirante,date_created_aspirante,date_updated_aspirante,id_role,name_role,id_campus,name_campus&linkTo=date_created_aspirante&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&filterTo=id_role_aspirante&inTo=20";

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

            $select = "id_aspirante,idcrm_aspirante,name_aspirante,ap_aspirante,am_aspirante,emailpersonal_aspirante,movil_aspirante,program_aspirante,id_role_aspirante,id_campus_aspirante,origen_aspirante,ejecutivo_aspirante,nivel_aspirante,modalidad_aspirante,campana_aspirante,etapacrm_aspirante,beca_aspirante,descuento_aspirante,importe_aspirante,fechareportado_aspirante,matricula_suni_aspirante,dv_suni_aspirante,estatus_aspirante,pipeline_aspirante,sexo_aspirante,date_created_aspirante,date_updated_aspirante,id_role,name_role,id_campus,name_campus";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){// Validar que no coloquen caracteres alfanumericos

	            	$linkTo = ["idcrm_aspirante","name_aspirante","ap_aspirante","am_aspirante","emailpersonal_aspirante","movil_aspirante","date_created_aspirante"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);//reemplaza espacio al momento de buscar ajustando un guion bajo

	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "relations?rel=aspirantes,roles,campuses&type=aspirante,role,campus&select=".$select."&linkTo=".$value.",id_role_aspirante&search=".$search.",1&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

	            $url = "relations?rel=aspirantes,roles,campuses&type=aspirante,role,campus&select=".$select."&linkTo=date_created_aspirante&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&filterTo=id_role_aspirante&inTo=20&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

	            $data = CurlController::request($url,$method,$fields)->results;

	            $recordsFiltered = $totalData;

				//echo '<pre>'; print_r($url); echo '</pre>';
				

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
					if($value->estatus_aspirante!=2){	
						
						if (isset($p_suspend)){
							
							$actions ="";
						}
						else{
							$actions ="";
						}
						
									
					}
					else{
						if (isset($p_suspend)){
							$actions ="";
						}
						else{
							$actions ="";
						}
					}	
						 
						if (isset($p_update)){			
							$actions .= "<a href='/aspirantes/edit/".base64_encode($value->id_aspirante."~".$_GET["token"])."' class='btn btn-warning btn-sm mr-1 rounded-circle'>
							
										<i class='fas fa-pencil-alt'></i>

										</a>";
									}
						else{
							$actions .="";
						}
						if (isset($p_delete)){
							$actions .= "<a class='btn btn-danger btn-sm rounded-circle removeItem' idItem='".base64_encode($value->id_aspirante."~".$_GET["token"])."' table='aspirantes' suffix='aspirante' page='aspirantes'>

										<i class='fas fa-trash'></i>

										</a>";
						}
						else{
							$actions .="";
						}
							$actions = TemplateController::htmlClean($actions);
            	}	


            	$idcrm_aspirante = $value->idcrm_aspirante;
            	$name_aspirante = $value->name_aspirante;
				$ap_aspirante = $value->ap_aspirante;	
				$am_aspirante = $value->am_aspirante;	
            	$emailpersonal_aspirante = $value->emailpersonal_aspirante;
				$movil_aspirante = $value->movil_aspirante;
				$name_campus = $value->name_campus;
				$origen_aspirante = $value->origen_aspirante;
				$ejecutivo_aspirante = $value->ejecutivo_aspirante;
				$etapacrm_aspirante = $value->etapacrm_aspirante;
            	$date_created_aspirante = $value->date_created_aspirante;	

            	$dataJson.='{ 

            		"id_aspirante":"'.($start+$key+1).'",
            		"idcrm_aspirante":"'.$idcrm_aspirante.'",
            		"name_aspirante":"'.$name_aspirante.'",
					"ap_aspirante":"'.$ap_aspirante.'",
					"am_aspirante":"'.$am_aspirante.'",
            		"emailpersonal_aspirante":"'.$emailpersonal_aspirante.'",
					"movil_aspirante":"'.$movil_aspirante.'",
					"name_campus":"'.$name_campus.'",
					"origen_aspirante":"'.$origen_aspirante.'",
					"ejecutivo_aspirante":"'.$ejecutivo_aspirante.'",
					"etapacrm_aspirante":"'.$etapacrm_aspirante.'",
            		"date_created_aspirante":"'.$date_created_aspirante.'",
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


