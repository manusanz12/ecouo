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
            
            $url = "relations?rel=users,roles,campuses&type=user,role,campus&select=id_user,matricula_user,name_user,email_user,id_role_user,id_campus_user,id_role,name_role,id_campus,name_campus&linkTo=date_created_user&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&filterTo=id_role_user&inTo=10";

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

            $select = "id_user,matricula_user,name_user,ap_user,am_user,email_user,id_role_user,id_campus_user,estatus_user,method_user,date_created_user,picture_user,id_role,name_role,id_campus,name_campus";

            if(!empty($_POST['search']['value'])){

            	if(preg_match('/^[0-9A-Za-zñÑáéíóú ]{1,}$/',$_POST['search']['value'])){// Validar que no coloquen caracteres alfanumericos

	            	$linkTo = ["matricula_user","name_user","ap_user","am_user","email_user","date_created_user","name_campus"];

	            	$search = str_replace(" ","_",$_POST['search']['value']);//reemplaza espacio al momento de buscar ajustando un guion bajo

	            	foreach ($linkTo as $key => $value) {
	            		
	            		$url = "relations?rel=users,roles,campuses&type=user,role,campus&select=".$select."&linkTo=".$value.",id_role_user&search=".$search.",10&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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

	            $url = "relations?rel=users,roles,campuses&type=user,role,campus&select=".$select."&linkTo=date_created_user&between1=".$_GET["between1"]."&between2=".$_GET["between2"]."&filterTo=id_role_user&inTo=10&orderBy=".$orderBy."&orderMode=".$orderType."&startAt=".$start."&endAt=".$length;

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
	            	
	            	$picture_user = $value->picture_user;
	            	$actions = "";
	            	
            	}else{
					$picture_user = "<img src='".TemplateController::returnImg($value->id_user,$value->picture_user,$value->method_user)."' class='img-circle' style='width:70px'>";
					if($value->estatus_user!=2){
						
						if (isset($p_suspend)){
							
							$actions ="<a class='btn btn-success btn-sm rounded-circle stopItem' idstopItem='".base64_encode($value->id_user."~".$_GET["token"])."' table='users' suffix='user' page='admins'>

										<i class='fas fa-eye'></i>

										</a>
										";
						}
						else{
							$actions ="";
						}
									
					}
					else{
						if (isset($p_suspend)){
							$actions ="<a class='btn btn-secondary btn-sm rounded-circle activeItem' idactiveItem='".base64_encode($value->id_user."~".$_GET["token"])."' table='users' suffix='user' page='admins'>

										<i class='fas fa-eye-slash'></i>

										</a>
										";
						}
						else{
							$actions ="";
						}
					}					

						if (isset($p_update)){
							$actions .= "<a href='/admins/edit/".base64_encode($value->id_user."~".$_GET["token"])."' class='btn btn-warning btn-sm mr-1 rounded-circle'>
							
										<i class='fas fa-pencil-alt'></i>

										</a>";
						}
						else{
							$actions ="";
						}
						if (isset($p_delete)){
							$actions .= "<a class='btn btn-danger btn-sm rounded-circle removeItem' idItem='".base64_encode($value->id_user."~".$_GET["token"])."' table='users' suffix='user' deleteFile='users/".$value->id_user."/".$value->picture_user."' page='admins'>

										<i class='fas fa-trash'></i>

										</a>";
						}
						else{
							$actions ="";
						}
							

							$actions = TemplateController::htmlClean($actions);
            	}	


            	$matricula_user = $value->matricula_user;
            	$name_user = $value->name_user;
				$ap_user = $value->ap_user;	
				$am_user = $value->am_user;	
            	$email_user = $value->email_user;
				$name_campus = $value->name_campus;
            	$date_created_user = $value->date_created_user;	

            	$dataJson.='{ 

            		"id_user":"'.($start+$key+1).'",
            		"picture_user":"'.$picture_user.'",
            		"matricula_user":"'.$matricula_user.'",
            		"name_user":"'.$name_user.'",
					"ap_user":"'.$ap_user.'",
					"am_user":"'.$am_user.'",
            		"email_user":"'.$email_user.'",
					"name_campus":"'.$name_campus.'",
            		"date_created_user":"'.$date_created_user.'",
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


