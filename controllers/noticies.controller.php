<?php

class NoticiesController{

	/*=============================================
	Creación de noticia
	=============================================*/	

	public function create(){

		if(isset($_POST["name-noticie"])){

			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			/*=============================================
			Validamos la sintaxis de los campos
			=============================================*/		

			if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["name-noticie"] ) ){


				/*=============================================
				Proceso para configurar la galería
				=============================================*/		

				$galleryNoticie = array();
				$countNoticie = 0;

				foreach (json_decode($_POST["gallery-noticie"],true) as $key => $value) {
					
					$countNoticie++;

					$fields = array(
					
						"file"=>$value["file"],
						"type"=>$value["type"],
						"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/gallery",
						"name"=>$_POST["url-name_noticie"]."_".mt_rand(100000000, 9999999999),
						"width"=>$value["width"],
						"height"=>$value["height"]
					);

					$saveImageGallery = CurlController::requestFile($fields);

					array_push($galleryNoticie, $saveImageGallery);

				}

				if($countNoticie == count($galleryNoticie)){	
					/*=============================================
					Validación Imagen
					=============================================*/		

					if(isset($_FILES["image-noticie"]["tmp_name"]) && !empty($_FILES["image-noticie"]["tmp_name"])){	

						$fields = array(
						
							"file"=>$_FILES["image-noticie"]["tmp_name"],
							"type"=>$_FILES["image-noticie"]["type"],
							"folder"=>"noticies/".explode("_",$_POST["name-category"])[1],
							"name"=>$_POST["url-name_noticie"],
							"width"=>300,
							"height"=>300
						);

						$saveImagenoticie = CurlController::requestFile($fields);

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
					Agrupamos data del video
					=============================================*/		

					if(!empty($_POST['type_video']) && !empty($_POST['id_video'])){

						$video_noticie = array();

						if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}$/', $_POST['id_video'])){

							array_push($video_noticie, $_POST['type_video']);
							array_push($video_noticie, $_POST['id_video']);

							$video_noticie = json_encode($video_noticie);
						
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

						$video_noticie = null;
						
					}

					
					/*=============================================
		 			Agrupar información para Top Banner
					=============================================*/

					if(isset($_FILES['topBanner']["tmp_name"]) && !empty($_FILES['topBanner']["tmp_name"])){

						$fields = array(
								
							"file"=>$_FILES['topBanner']["tmp_name"],
							"type"=>$_FILES['topBanner']["type"],
							"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/top",
							"name"=>$_POST["url-name_noticie"]."_".mt_rand(100000000, 9999999999),
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

						fncNotie(3, "Failed to save noticie top banner");

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
							"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/default",
							"name"=>$_POST["url-name_noticie"]."_".mt_rand(100000000, 9999999999),
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

						fncNotie(3, "Failed to save noticie default banner");

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
							"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/horizontal",
							"name"=>$_POST["url-name_noticie"]."_".mt_rand(100000000, 9999999999),
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

						fncNotie(3, "Failed to save noticie horizontal slider");

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
							"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/vertical",
							"name"=>$_POST["url-name_noticie"]."_".mt_rand(100000000, 9999999999),
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

						fncNotie(3, "Failed to save noticie vertical slider");

						</script>';

						return;

					}


				   	/*=============================================
					Agrupamos la información 
					=============================================*/		

					$data = array(
						"state_noticie" => "show",		
						"name_noticie" => trim(TemplateController::capitalize($_POST["name-noticie"])),
						"url_noticie" => trim($_POST["url-name_noticie"]),
						"link_noticie" => trim($_POST["link-name_noticie"]),
						"type_noticie" => trim($_POST["name-type"]),
						"id_category_noticie" => explode("_",$_POST["name-category"])[0],
						"image_noticie" => $saveImagenoticie,
						"description_noticie" => trim(TemplateController::htmlClean($_POST["description-noticie"])),
						"tags_noticie" => json_encode(explode(",",$_POST["tags-noticie"])),
						"gallery_noticie" => json_encode($galleryNoticie),
						"video_noticie" => $video_noticie,
						"top_banner_noticie" => json_encode($topBanner),
						"default_banner_noticie" => $saveImageDefaultBanner,
						"horizontal_slider_noticie"=>json_encode($hSlider),
						"vertical_slider_noticie"=>$saveImageVSlider,
						"offer_noticie" => trim($_POST["date_offer"]),
						"date_created_noticie" => date("Y-m-d")

					);
					
					


					/*=============================================
					Solicitud a la API
					=============================================*/		

					$url = "noticies?token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
								fncSweetAlert("success", "Your records were created successfully", "/noticies");

							</script>';


					}else{

						echo '<script>

							//fncFormatInputs();
							matPreloader("off");
							fncSweetAlert("close", "", "");
							fncNotie(3, "Error saving noticie");

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
	Edición Noticia
	=============================================*/	

	public function edit($id){

		if(isset($_POST["idnoticie"])){



			echo '<script>

				matPreloader("on");
				fncSweetAlert("loading", "Loading...", "");

			</script>';

			if($id == $_POST["idnoticie"]){

				$select = "*";

				$url = "noticies?select=".$select."&linkTo=id_noticie&equalTo=".$id;
				$method = "GET";
				$fields = array();

				$response = CurlController::request($url,$method,$fields);

				if($response->status == 200){

					/*=============================================
					Validamos la sintaxis de los campos
					=============================================*/		
					if(preg_match('/^[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}$/', $_POST["name-noticie"] )){
						$gallerynoticie = array();
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
									"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/gallery",
									"name"=>$_POST["url-name_noticie"]."_".mt_rand(100000000, 9999999999),
									"width"=>$value["width"],
									"height"=>$value["height"]
								);

								$saveImageGallery = CurlController::requestFile($fields);

								array_push($gallerynoticie, $saveImageGallery);

								if($countGallery == count($gallerynoticie)){

									if(!empty($_POST['gallery-noticie-old'])){

										foreach (json_decode($_POST['gallery-noticie-old'],true) as $key => $value) {

											$countGallery2++;
											array_push($gallerynoticie, $value);
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
									array_push($gallerynoticie, $value);
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
								
								 "deleteFile"=> "noticies/".explode("_",$_POST["name-category"])[1]."/gallery/".$value

								);

								$picture = CurlController::requestFile($fields);

							}

						}

						/*=============================================
			 			Validamos que no venga la galería vacía
						=============================================*/

						if(count($gallerynoticie) == 0){

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

							if(isset($_FILES["image-noticie"]["tmp_name"]) && !empty($_FILES["image-noticie"]["tmp_name"])){	

								$fields = array(
								
									"file"=>$_FILES["image-noticie"]["tmp_name"],
									"type"=>$_FILES["image-noticie"]["type"],
									"folder"=>"noticies/".explode("_",$_POST["name-category"])[1],
									"name"=>$_POST["url-name_noticie"],
									"width"=>300,
									"height"=>300
								);

								$saveImagenoticie = CurlController::requestFile($fields);

							}else{

								$saveImagenoticie = $response->results[0]->image_noticie;
							}

							
							
							/*=============================================
							Agrupamos data del video
							=============================================*/		

							if(!empty($_POST['type_video']) && !empty($_POST['id_video'])){

								$video_noticie = array();

								if(preg_match('/^[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}$/', $_POST['id_video'])){

									array_push($video_noticie, $_POST['type_video']);
									array_push($video_noticie, $_POST['id_video']);

									$video_noticie = json_encode($video_noticie);
								
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

								$video_noticie = $response->results[0]->video_noticie;
								
							}

							/*=============================================
				 			Fecha de vencimiento
							=============================================*/
							$offer_noticie = $_POST['date_offer'];

							/*=============================================
				 			Agrupar información para Top Banner
							=============================================*/

							if(isset($_FILES['topBanner']["tmp_name"]) && !empty($_FILES['topBanner']["tmp_name"])){

								$fields = array(
										
									"file"=>$_FILES['topBanner']["tmp_name"],
									"type"=>$_FILES['topBanner']["type"],
									"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/top",
									"name"=>json_decode($response->results[0]->top_banner_noticie, true)["IMG tag"],
									"width"=>1920,
									"height"=>80
								);

								$saveImageTopBanner = CurlController::requestFile($fields);

							}else{

								$saveImageTopBanner = json_decode($response->results[0]->top_banner_noticie, true)["IMG tag"];

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
									"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/default",
									"name"=>$response->results[0]->default_banner_noticie,
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

								$saveImageDefaultBanner = $response->results[0]->default_banner_noticie;

							}

							/*=============================================
				 			Agrupar información para Horizontal Slider
							=============================================*/

							if(isset($_FILES['hSlider']["tmp_name"]) && !empty($_FILES['hSlider']["tmp_name"])){

								$fields = array(
										
									"file"=>$_FILES['hSlider']["tmp_name"],
									"type"=>$_FILES['hSlider']["type"],
									"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/horizontal",
									"name"=>json_decode($response->results[0]->horizontal_slider_noticie, true)["IMG tag"],
									"width"=>1920,
									"height"=>358
								);

								$saveImageHSlider = CurlController::requestFile($fields);

							}else{

								$saveImageHSlider = json_decode($response->results[0]->horizontal_slider_noticie, true)["IMG tag"];

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
									"folder"=>"noticies/".explode("_",$_POST["name-category"])[1]."/vertical",
									"name"=>$response->results[0]->vertical_slider_noticie,
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

								$saveImageVSlider = $response->results[0]->vertical_slider_noticie;

							}

							/*=============================================
							Agrupar información de oferta
							=============================================*/

							if(!empty($_POST["date_offer"])){

								
								$offer_noticie = $_POST["date_offer"];

											

							}else{

								$offer_noticie = null;
								

							}

						   	/*=============================================
							Agrupamos la información 
							=============================================*/		

							$data = "name_noticie=".trim(TemplateController::capitalize($_POST["name-noticie"]))."&url_noticie=".trim($_POST["url-name_noticie"])."&link_noticie=".trim($_POST["link-name_noticie"])."&type_noticie=".trim($_POST["name-type"])."&id_category_noticie=".explode("_",$_POST["name-category"])[0]."&image_noticie=".$saveImagenoticie."&description_noticie=".urlencode(trim(TemplateController::htmlClean($_POST["description-noticie"])))."&tags_noticie=".json_encode(explode(",",$_POST["tags-noticie"]))."&gallery_noticie=".json_encode($gallerynoticie)."&video_noticie=".$video_noticie."&top_banner_noticie=".json_encode($topBanner)."&default_banner_noticie=".$saveImageDefaultBanner."&horizontal_slider_noticie=".json_encode($hSlider)."&vertical_slider_noticie=".$saveImageVSlider."&offer_noticie=".$offer_noticie;
							//$data = "name_noticie=".trim(TemplateController::capitalize($_POST["name-noticie"]))."&gallery_noticie=".json_encode($gallerynoticie)."&offer_noticie=".$offer_noticie;
							//echo '<pre>'; print_r($data); echo '</pre>';
							//return;


							/*=============================================
							Solicitud a la API
							=============================================*/		

							$url = "noticies?id=".$id."&nameId=id_noticie&token=".$_SESSION["admin"]->token_user."&table=users&suffix=user";
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
										fncSweetAlert("success", "Your records were created successfully", "/noticies");

									</script>';


							}else{

								echo '<script>

									//fncFormatInputs();
									matPreloader("off");
									fncSweetAlert("close", "", "");
									fncNotie(3, "Error saving noticie");

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


