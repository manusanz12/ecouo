<?php

class ServicesController{

	/*=============================================
	Creación de servicio
	=============================================*/	

	public function create(){

		if(isset($_POST["name-service"])){
			

			/*echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';*/

			/*=============================================
			Validamos los planteles
			=============================================*/
			$plantelespermitidos= array();
			if (isset($_POST['planteles'])) {
				$opcionesSeleccionadas = $_POST['planteles'];
			
				// Recorrer las opciones seleccionadas
				foreach ($opcionesSeleccionadas as $opcion) {
					//echo "Has seleccionado: " . htmlspecialchars($opcion) . "<br>";
					array_push($plantelespermitidos, $opcion);
				}
			}

			if(count($plantelespermitidos) > 0){

				$plantelespermitidos = json_encode($plantelespermitidos);
				

			}else{

				$plantelespermitidos = null;

			   
			}


			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		


			if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["name-service"] ) ){



					/*=============================================
					Validación Imagen
					=============================================*/		

					if(isset($_FILES["image-service"]["tmp_name"]) && !empty($_FILES["image-service"]["tmp_name"])){	

						$fields = array(
						
							"file"=>$_FILES["image-service"]["tmp_name"],
							"type"=>$_FILES["image-service"]["type"],
							"folder"=>"services/".explode("_",$_POST["name-category"])[1],
							"name"=>$_POST["url-name_service"],
							"width"=>300,
							"height"=>300
						);

						$saveImageservice = CurlController::requestFile($fields);

					}else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Field Image error");

						</script>';

						return;
					}



				/*=============================================
				Proceso para configurar la galería
				=============================================*/		

				$galleryService = array();
				$countNoticie = 0;


				foreach (json_decode($_POST["gallery-noticie"],true) as $key => $value) {
					
					$countNoticie++;

					$fields = array(
					
						"file"=>$value["file"],
						"type"=>$value["type"],
						"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/gallery",
						"name"=>$_POST["url-name_service"]."_".mt_rand(100000000, 9999999999),
						"width"=>$value["width"],
						"height"=>$value["height"]
					);

					$saveImageGallery = CurlController::requestFile($fields);

					array_push($galleryService, $saveImageGallery);

				}

				if($countNoticie == count($galleryService)){	
				
					/*=============================================
					Agrupamos data del video
					=============================================*/		

					if(!empty($_POST['type_video']) && !empty($_POST['id_video'])){

						$video_service = array();

						if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}$/', $_POST['id_video'])){

							array_push($video_service, $_POST['type_video']);
							array_push($video_service, $_POST['id_video']);

							$video_service = json_encode($video_service);
						
						}else{

							echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Error in the syntax of the fields of Video");

							</script>';

							return;

						}


					}else{

						$video_service = null;
						
					}

					
					/*=============================================
		 			Agrupar información para Top Banner
					=============================================*/

					if(isset($_FILES['topBanner']["tmp_name"]) && !empty($_FILES['topBanner']["tmp_name"])){

						$fields = array(
								
							"file"=>$_FILES['topBanner']["tmp_name"],
							"type"=>$_FILES['topBanner']["type"],
							"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/top",
							"name"=>$_POST["url-name_service"]."_".mt_rand(100000000, 9999999999),
							"width"=>1920,
							"height"=>80
						);

						$saveImageTopBanner = CurlController::requestFile($fields);

						if($saveImageTopBanner != "error"){

							if(isset($_POST['topBannerH3Tag']) && 
				  			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerH3Tag']) &&
				  				isset($_POST['topBannerP1Tag']) && 
				  				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerP1Tag']) &&
				  				isset($_POST['topBannerH4Tag']) &&
				  				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerH4Tag']) &&
				  			    isset($_POST['topBannerP2Tag']) &&
				  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerP2Tag']) &&
				  			    isset($_POST['topBannerSpanTag']) &&
				  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerSpanTag']) &&
				  			    isset($_POST['topBannerButtonTag']) &&
				  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerButtonTag'])
				  			){

								$topBanner = (object)[

									"H3 tag"=>TemplateController::capitalize($_POST['topBannerH3Tag']),
				  					"P1 tag"=>TemplateController::capitalize($_POST['topBannerP1Tag']),
				  					"H4 tag"=>TemplateController::capitalize($_POST['topBannerH4Tag']),
				  					"P2 tag"=>TemplateController::capitalize($_POST['topBannerP2Tag']),
				  					"Span tag"=>TemplateController::capitalize($_POST['topBannerSpanTag']),
				  					"Button tag"=>TemplateController::capitalize($_POST['topBannerButtonTag']),
				  					"IMG tag"=>$saveImageTopBanner

								];

				  			}else{

								echo '<script>

									fncFormatInputs();

									fncNotie(3, "Error in the syntax of the fields of Top Banner");

								</script>';

								return;

							}


						}


					}else{

						echo '<script>

						fncFormatInputs();

						fncNotie(3, "Failed to save service top banner");

						</script>';

						return;

					}

					/*=============================================
		 			Agrupar información para Default Banner
					=============================================*/

					if(isset($_FILES['defaultBanner']["tmp_name"]) && !empty($_FILES['defaultBanner']["tmp_name"])){

						$fields = array(
								
							"file"=>$_FILES['defaultBanner']["tmp_name"],
							"type"=>$_FILES['defaultBanner']["type"],
							"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/default",
							"name"=>$_POST["url-name_service"]."_".mt_rand(100000000, 9999999999),
							"width"=>570,
							"height"=>210
						);

						$saveImageDefaultBanner = CurlController::requestFile($fields);

						if($saveImageDefaultBanner == "error"){

				  			echo '<script>

								fncFormatInputs();

								fncNotie(3, "Error saving default banner image");

							</script>';

							return;
				  		}

					}else{

						echo '<script>

						fncFormatInputs();

						fncNotie(3, "Failed to save service default banner");

						</script>';

						return;

					}

					/*=============================================
		 			Agrupar información para Horizontal Slider
					=============================================*/

					if(isset($_FILES['hSlider']["tmp_name"]) && !empty($_FILES['hSlider']["tmp_name"])){

						$fields = array(
								
							"file"=>$_FILES['hSlider']["tmp_name"],
							"type"=>$_FILES['hSlider']["type"],
							"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/horizontal",
							"name"=>$_POST["url-name_service"]."_".mt_rand(100000000, 9999999999),
							"width"=>1920,
							"height"=>358
						);

						$saveImageHSlider = CurlController::requestFile($fields);

						if($saveImageHSlider != "error"){

								if(isset($_POST['hSliderH4Tag']) && 
					  			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH4Tag']) &&
					  				isset($_POST['hSliderH3_1Tag']) && 
					  				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_1Tag']) &&
					  				isset($_POST['hSliderH3_2Tag']) &&
					  				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_2Tag']) &&
					  			    isset($_POST['hSliderH3_3Tag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_3Tag']) &&
					  			    isset($_POST['hSliderH3_4sTag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_4sTag']) &&
					  			    isset($_POST['hSliderButtonTag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderButtonTag'])
					  			){

								$hSlider = (object)[

				  					"H4 tag"=>TemplateController::capitalize($_POST['hSliderH4Tag']),
				  					"H3-1 tag"=>TemplateController::capitalize($_POST['hSliderH3_1Tag']),
				  					"H3-2 tag"=>TemplateController::capitalize($_POST['hSliderH3_2Tag']),
				  					"H3-3 tag"=>TemplateController::capitalize($_POST['hSliderH3_3Tag']),
				  					"H3-4s tag"=>TemplateController::capitalize($_POST['hSliderH3_4sTag']),
				  					"Button tag"=>TemplateController::capitalize($_POST['hSliderButtonTag']),
				  					"IMG tag"=>$saveImageHSlider

				  				];

				  			}else{

								echo '<script>

									fncFormatInputs();

									fncNotie(3, "Error in the syntax of the fields of Top Banner");

								</script>';

								return;

							}


						}


					}else{

						echo '<script>

						fncFormatInputs();

						fncNotie(3, "Failed to save service horizontal slider");

						</script>';

						return;

					}

					/*=============================================
		 			Agrupar información para Vertical Slider
					=============================================*/

					if(isset($_FILES['vSlider']["tmp_name"]) && !empty($_FILES['vSlider']["tmp_name"])){

						$fields = array(
								
							"file"=>$_FILES['vSlider']["tmp_name"],
							"type"=>$_FILES['vSlider']["type"],
							"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/vertical",
							"name"=>$_POST["url-name_service"]."_".mt_rand(100000000, 9999999999),
							"width"=>263,
							"height"=>629
						);

						$saveImageVSlider = CurlController::requestFile($fields);

						if($saveImageVSlider == "error"){

				  			echo '<script>

								fncFormatInputs();

								fncNotie(3, "Error saving vertical slider image");

							</script>';

							return;
				  		}


					}else{

						echo '<script>

						fncFormatInputs();

						fncNotie(3, "Failed to save service vertical slider");

						</script>';

						return;

					}


				   	/*=============================================
					Agrupamos la información 
					=============================================*/		

					$data = array(
						"state_service" => "show",		
						"name_service" => trim(TemplateController::capitalize($_POST["name-service"])),
						"url_service" => trim($_POST["url-name_service"]),
						"link_service" => trim($_POST["link-name_service"]),
						"type_service" => trim($_POST["name-type"]),
						"id_category_service" => explode("_",$_POST["name-category"])[0],
						"image_service" => $saveImageservice,
						"description_service" => trim(TemplateController::htmlClean(preg_replace('/\r\n|\r|\n/','', $_POST["description-service"]))),
						"tags_service" => json_encode(explode(",",$_POST["tags-service"])),
						"gallery_service" => json_encode($galleryService),
						"video_service" => $video_service,
						"top_banner_service" => json_encode($topBanner),
						"default_banner_service" => $saveImageDefaultBanner,
						"horizontal_slider_service"=>json_encode($hSlider),
						"vertical_slider_service"=>$saveImageVSlider,
						"offer_service" => trim($_POST["date_offer"]),
						"campus_service" => $plantelespermitidos,
						"date_created_service" => date("Y-m-d")

					);
					

					/*=============================================
					Solicitud a la API
					=============================================*/		

					$url = "services?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
					$method = "POST";
					$fields = $data;

					$response = CurlController::request($url,$method,$fields);
					
					
					/*=============================================
					Respuesta de la API
					=============================================*/		
					
					if($response->status == 200){

							echo '<script>

								fncFormatInputs();
								matPreloader("off");
								fncSweetAlert("close", "", "");
								fncSweetAlert("success", "Your records were created successfully", "/services");

							</script>';


					}else{

						echo '<script>

							//fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Error saving service");

						</script>';

					}
				}
			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "Field syntax error");

				</script>';

				
			}
		}

	}

/*=============================================
	Edición Servicio
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idservice"])){



			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idservice"]){

				$select = "*";

				$url = "services?select=".$select."&linkTo=id_service&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);

				if($response->status == 200){

					/*=============================================
					Validamos los planteles
					=============================================*/
					$plantelespermitidos= array();
					if (isset($_POST['planteles'])) {
						$opcionesSeleccionadas = $_POST['planteles'];
					
						// Recorrer las opciones seleccionadas
						foreach ($opcionesSeleccionadas as $opcion) {
							//echo "Has seleccionado: " . htmlspecialchars($opcion) . "<br>";
							array_push($plantelespermitidos, $opcion);
						}
					}

					if(count($plantelespermitidos) > 0){

						$plantelespermitidos = json_encode($plantelespermitidos);
						

					}else{

						$plantelespermitidos = null;

					
					}

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		
					if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["name-service"] )){
						$galleryservice = array();
						$countGallery = 0;
						$countGallery2 = 0;
						$continueEdit = false;

						if(!empty($_POST['gallery-noticie'])){	

							/*=============================================
							Proceso para configurar la galería
							=============================================*/		
							foreach (json_decode($_POST["gallery-noticie"],true) as $key => $value) {
								
								$countGallery++;

								$fields = array(
								
									"file"=>$value["file"],
									"type"=>$value["type"],
									"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/gallery",
									"name"=>$_POST["url-name_service"]."_".mt_rand(100000000, 9999999999),
									"width"=>$value["width"],
									"height"=>$value["height"]
								);

								$saveImageGallery = CurlController::requestFile($fields);

								array_push($galleryservice, $saveImageGallery);

								if($countGallery == count($galleryservice)){

									if(!empty($_POST['gallery-noticie-old'])){

										foreach (json_decode($_POST['gallery-noticie-old'],true) as $key => $value) {

											$countGallery2++;
											array_push($galleryservice, $value);
										}

										if(count(json_decode($_POST['gallery-noticie-old'],true)) == $countGallery2){

						  					$continueEdit = true;

						  				}

									}else{

										$continueEdit = true;

									}


								}

							}

						}else{

							if(!empty($_POST['gallery-noticie-old'])){

								$countGallery2 = 0;

								foreach (json_decode($_POST['gallery-noticie-old'],true) as $key => $value) {

									$countGallery2++;
									array_push($galleryservice, $value);
								}

								if(count(json_decode($_POST['gallery-noticie-old'],true)) == $countGallery2){

				  					$continueEdit = true;

				  				}

							}

						}

						/*=============================================
			 			Eliminamos archivos basura del servidor
						=============================================*/

						if(!empty($_POST['delete-gallery-noticie'])){

							foreach (json_decode($_POST['delete-gallery-noticie'],true) as $key => $value) {

								$fields = array(
								
								 "deleteFile"=> "services/".explode("_",$_POST["name-category"])[1]."/gallery/".$value

								);

								$picture = CurlController::requestFile($fields);

							}

						}

						/*=============================================
			 			Validamos que no venga la galería vacía
						=============================================*/

						if(count($galleryservice) == 0){

			  				echo '<script>

								fncFormatInputs();

								fncNotie(3, "The gallery cannot be empty");

							</script>';

							return;

			  			}

						if($continueEdit){

							/*=============================================
							Validación Imagen
							=============================================*/		

							if(isset($_FILES["image-service"]["tmp_name"]) && !empty($_FILES["image-service"]["tmp_name"])){	

								$fields = array(
								
									"file"=>$_FILES["image-service"]["tmp_name"],
									"type"=>$_FILES["image-service"]["type"],
									"folder"=>"services/".explode("_",$_POST["name-category"])[1],
									"name"=>$_POST["url-name_service"],
									"width"=>300,
									"height"=>300
								);

								$saveImageservice = CurlController::requestFile($fields);

							}else{

								$saveImageservice = $response->results[0]->image_service;
							}

							
							
							/*=============================================
							Agrupamos data del video
							=============================================*/		

							if(!empty($_POST['type_video']) && !empty($_POST['id_video'])){

								$video_service = array();

								if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}$/', $_POST['id_video'])){

									array_push($video_service, $_POST['type_video']);
									array_push($video_service, $_POST['id_video']);

									$video_service = json_encode($video_service);
								
								}else{

									echo '<script>

									fncFormatInputs();
									matPreloader("off");
									fncSweetAlert("close", "", "");
									fncNotie(3, "Error in the syntax of the fields of Video");

									</script>';

									return;

								}


							}else{

								$video_service = $response->results[0]->video_service;
								
							}

							/*=============================================
				 			Fecha de vencimiento
							=============================================*/
							$offer_service = $_POST['date_offer'];

							/*=============================================
				 			Agrupar información para Top Banner
							=============================================*/

							if(isset($_FILES['topBanner']["tmp_name"]) && !empty($_FILES['topBanner']["tmp_name"])){

								$fields = array(
										
									"file"=>$_FILES['topBanner']["tmp_name"],
									"type"=>$_FILES['topBanner']["type"],
									"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/top",
									"name"=>json_decode($response->results[0]->top_banner_service, true)["IMG tag"],
									"width"=>1920,
									"height"=>80
								);

								$saveImageTopBanner = CurlController::requestFile($fields);

							}else{

								$saveImageTopBanner = json_decode($response->results[0]->top_banner_service, true)["IMG tag"];

							}

							if($saveImageTopBanner != "error"){

								if(isset($_POST['topBannerH3Tag']) && 
					  			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerH3Tag']) &&
					  				isset($_POST['topBannerP1Tag']) && 
					  				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerP1Tag']) &&
					  				isset($_POST['topBannerH4Tag']) &&
					  				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerH4Tag']) &&
					  			    isset($_POST['topBannerP2Tag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerP2Tag']) &&
					  			    isset($_POST['topBannerSpanTag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerSpanTag']) &&
					  			    isset($_POST['topBannerButtonTag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['topBannerButtonTag'])
					  			){

									$topBanner = (object)[

										"H3 tag"=>TemplateController::capitalize($_POST['topBannerH3Tag']),
					  					"P1 tag"=>TemplateController::capitalize($_POST['topBannerP1Tag']),
					  					"H4 tag"=>TemplateController::capitalize($_POST['topBannerH4Tag']),
					  					"P2 tag"=>TemplateController::capitalize($_POST['topBannerP2Tag']),
					  					"Span tag"=>TemplateController::capitalize($_POST['topBannerSpanTag']),
					  					"Button tag"=>TemplateController::capitalize($_POST['topBannerButtonTag']),
					  					"IMG tag"=>$saveImageTopBanner

									];

					  			}else{

									echo '<script>

										fncFormatInputs();

										fncNotie(3, "Error in the syntax of the fields of Top Banner");

									</script>';

									return;

								}


							}

							/*=============================================
				 			Agrupar información para Default Banner
							=============================================*/

							if(isset($_FILES['defaultBanner']["tmp_name"]) && !empty($_FILES['defaultBanner']["tmp_name"])){

								$fields = array(
										
									"file"=>$_FILES['defaultBanner']["tmp_name"],
									"type"=>$_FILES['defaultBanner']["type"],
									"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/default",
									"name"=>$response->results[0]->default_banner_service,
									"width"=>570,
									"height"=>210
								);

								$saveImageDefaultBanner = CurlController::requestFile($fields);

								if($saveImageDefaultBanner == "error"){

						  			echo '<script>

										fncFormatInputs();

										fncNotie(3, "Error saving default banner image");

									</script>';

									return;
						  		}

							}else{

								$saveImageDefaultBanner = $response->results[0]->default_banner_service;

							}

							/*=============================================
				 			Agrupar información para Horizontal Slider
							=============================================*/

							if(isset($_FILES['hSlider']["tmp_name"]) && !empty($_FILES['hSlider']["tmp_name"])){

								$fields = array(
										
									"file"=>$_FILES['hSlider']["tmp_name"],
									"type"=>$_FILES['hSlider']["type"],
									"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/horizontal",
									"name"=>json_decode($response->results[0]->horizontal_slider_service, true)["IMG tag"],
									"width"=>1920,
									"height"=>358
								);

								$saveImageHSlider = CurlController::requestFile($fields);

							}else{

								$saveImageHSlider = json_decode($response->results[0]->horizontal_slider_service, true)["IMG tag"];

							}

							if($saveImageHSlider != "error"){

								if(isset($_POST['hSliderH4Tag']) && 
					  			   preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH4Tag']) &&
					  				isset($_POST['hSliderH3_1Tag']) && 
					  				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_1Tag']) &&
					  				isset($_POST['hSliderH3_2Tag']) &&
					  				preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_2Tag']) &&
					  			    isset($_POST['hSliderH3_3Tag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_3Tag']) &&
					  			    isset($_POST['hSliderH3_4sTag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderH3_4sTag']) &&
					  			    isset($_POST['hSliderButtonTag']) &&
					  			    preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST['hSliderButtonTag'])
					  			){

									$hSlider = (object)[

					  					"H4 tag"=>TemplateController::capitalize($_POST['hSliderH4Tag']),
					  					"H3-1 tag"=>TemplateController::capitalize($_POST['hSliderH3_1Tag']),
					  					"H3-2 tag"=>TemplateController::capitalize($_POST['hSliderH3_2Tag']),
					  					"H3-3 tag"=>TemplateController::capitalize($_POST['hSliderH3_3Tag']),
					  					"H3-4s tag"=>TemplateController::capitalize($_POST['hSliderH3_4sTag']),
					  					"Button tag"=>TemplateController::capitalize($_POST['hSliderButtonTag']),
					  					"IMG tag"=>$saveImageHSlider

					  				];

					  			}else{

									echo '<script>

										fncFormatInputs();

										fncNotie(3, "Error in the syntax of the fields of Top Banner");

									</script>';

									return;

								}


							}


							/*=============================================
				 			Agrupar información para Vertical Slider
							=============================================*/

							if(isset($_FILES['vSlider']["tmp_name"]) && !empty($_FILES['vSlider']["tmp_name"])){

								$fields = array(
										
									"file"=>$_FILES['vSlider']["tmp_name"],
									"type"=>$_FILES['vSlider']["type"],
									"folder"=>"services/".explode("_",$_POST["name-category"])[1]."/vertical",
									"name"=>$response->results[0]->vertical_slider_service,
									"width"=>263,
									"height"=>629
								);

								$saveImageVSlider = CurlController::requestFile($fields);

								if($saveImageVSlider == "error"){

						  			echo '<script>

										fncFormatInputs();

										fncNotie(3, "Error saving vertical slider image");

									</script>';

									return;
						  		}


							}else{

								$saveImageVSlider = $response->results[0]->vertical_slider_service;

							}

							/*=============================================
							Agrupar información de oferta
							=============================================*/

							if(!empty($_POST["date_offer"])){

								
								$offer_service = $_POST["date_offer"];

											

							}else{

								$offer_service = null;
								

							}

						   	/*=============================================
							Agrupamos la información 
							=============================================*/		

							$data = "name_service=".trim(TemplateController::capitalize($_POST["name-service"]))."&url_service=".trim($_POST["url-name_service"])."&link_service=".trim($_POST["link-name_service"])."&type_service=".trim($_POST["name-type"])."&id_category_service=".explode("_",$_POST["name-category"])[0]."&image_service=".$saveImageservice."&description_service=".urlencode(trim(TemplateController::htmlClean(preg_replace('/\r\n|\r|\n/','', $_POST["description-service"]))))."&tags_service=".json_encode(explode(",",$_POST["tags-service"]))."&gallery_service=".json_encode($galleryservice)."&video_service=".$video_service."&top_banner_service=".json_encode($topBanner)."&default_banner_service=".$saveImageDefaultBanner."&horizontal_slider_service=".json_encode($hSlider)."&vertical_slider_service=".$saveImageVSlider."&offer_service=".$offer_service."&campus_service=".$plantelespermitidos;
							//$data = "name_service=".trim(TemplateController::capitalize($_POST["name-service"]))."&gallery_service=".json_encode($galleryservice)."&offer_service=".$offer_service;
							//echo '<pre>'; print_r($data); echo '</pre>';
							//return;


							/*=============================================
							Solicitud a la API
							=============================================*/		

							$url = "services?id=".$id."&nameId=id_service&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
							$method = "PUT";
							$fields = $data;

							$response = CurlController::request($url,$method,$fields);
							
							/*=============================================
							Respuesta de la API
							=============================================*/		
							
							if($response->status == 200){

									echo '<script>

										fncFormatInputs();
										matPreloader("off");
										fncSweetAlert("close", "", "");
										fncSweetAlert("success", "Your records were created successfully", "/services");

									</script>';


							}else{

								echo '<script>

									//fncFormatInputs();
									matPreloader("off");
									fncSweetAlert("close", "", "");
									fncNotie(3, "Error saving service");

								</script>';

							}

						}
				

					}else{

						echo '<script>

							fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Field syntax error");

						</script>';

						
					}

				}else{

					echo '<script>

						fncFormatInputs();
						matPreloader("off");
						fncSweetAlert("close", "", "");
						fncNotie(3, "Error editing the registry");

					</script>';

					
				}

			}else{

				echo '<script>

					fncFormatInputs();
					matPreloader("off");
					fncSweetAlert("close", "", "");
					fncNotie(3, "Error editing the registry");

				</script>';

				
			}
		}

	}




}


