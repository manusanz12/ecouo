<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "relations?rel=services,categories&type=service,category&select=".$select."&linkTo=id_service&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$service = $response->results[0];

			}else{

				echo '<script>

				window.location = "/services";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/services";

			</script>';
		

		}


	}


?>

<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $service->id_service ?>" name="idservice">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/services.controller.php";

				$create = new ServicesController();
				$create -> edit($service->id_service);

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Required</label>

				

				<!--=====================================
                Nombre de servicio
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre de Servicio <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,50}"
					onchange="validateJS(event,'text&number')"
					maxlength="50"
					name="name-service"
					value="<?php echo $service->name_service ?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>


				<!--=====================================
                Url de la servicio
                ======================================-->

				<div class="form-group mt-2">
					
					<label>URL del servicio <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					name="url-name_service"
					value="<?php echo $service->url_service ?>"
					required>

				</div>

				<!--=====================================
                Link de la servicio
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Link del servicio <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					name="link-name_service"
					value="<?php echo $service->link_service ?>"
					required>

				</div>

				<!--=====================================
		        Tipo
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Tipo<sup class="text-danger">*</sup></label>

		           

		            <div class="form-group my-4__content">
		                
		                <select
		                class="form-control select2"
		                name="name-type"
		                style="width:100%"
		                required>
							<option value="">Select Type</option>
							<option value="<?php echo $service->type_service ?>" selected><?php echo $service->type_service ?></option>
							<option value="academia">Académia</option>
							<option value="administrativo" >Administrativo</option>
		                    
		                </select> 

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>

				<!--=====================================
		        Categoría
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Categoría<sup class="text-danger">*</sup></label>

		            <input 
		            type="text" 
		            class="form-control"
		            value="<?php echo $service->name_category ?>"  
		            readonly>

		            <input type="hidden"  name="name-category" value="<?php echo $service->id_category ?>_<?php echo $service->url_category ?>"  >

		        </div>

			

		        <!--=====================================
                Imagen de Servicio
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Imagen de Servicio <sup class="text-danger">*</sup></label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::srcImg() ?>views/assets/img/services/<?php echo $service->url_category ?>/<?php echo $service->image_service ?>" class="img-fluid changeImage" style="width:150px">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changeImage')"
						name="image-service"
						>

						<div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

						<label for="customFile" class="custom-file-label">Choose file</label>

					</div>

				</div>


		        <!--=====================================
		        Descripción de servicio
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Descripción de servicio<sup class="text-danger">*</sup></label>

		            <textarea
		            class="summernote"
		            name="description-service"
		            required
		            ><?php echo $service->description_service ?></textarea>

		            <div class="valid-feedback">Valid.</div>
		            <div class="invalid-feedback">Please fill out this field.</div>

		        </div>

		        <!--=====================================
                Palabras Claves
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Tags servicio</label>

					<input 
					type="text" 
					class="form-control tags-input"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="tags-service"
					value="<?php echo implode(",",json_decode($service->tags_service,true)) ?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>	

				
		        <!--=====================================
		        Galería de la servicio
		        ======================================-->

		        <div class="form-group mt-2">
		        	
		        	<label>Galeria de servicio: <sup class="text-danger">*</sup></label> 

		        	<div class="dropzone mb-3">

		        		<?php foreach (json_decode($service->gallery_service,true) as $value): ?>

		            		<div class="dz-preview dz-file-preview"> 

		            			<div class="dz-image">
		            			 	
		            			 	<img class="img-fluid" src="<?php echo TemplateController::srcImg() ?>views/assets/img/services/<?php echo $service->url_category ?>/gallery/<?php echo $value ?>">

		            			</div>

		            			<a class="dz-remove" data-dz-remove remove="<?php echo $value?>" onclick="removeGallery(this)">Remove file</a>

		            		</div>   
		            		
            			<?php endforeach ?>
		        	 	
		        		<div class="dz-message">
		        			
		        			Drop your images here, size max 500px * 500px

		        		</div>

		        	</div>

		        	<input type="hidden" name="gallery-noticie-old" value='<?php echo $service->gallery_service ?>'>

		        	<input type="hidden" name="gallery-noticie">

		        	<input type="hidden" name="delete-gallery-noticie">

		        </div>

		        <!--=====================================
		        Video de la servicio
		        ======================================-->

		        <div class="form-group mt-2">
		        	

		        	<label>service Video | Ex: <strong>Type:</strong> YouTube, <strong>Id:</strong> Sl5FaskVpD4</label> 

		        	<div class="row mb-3"> 

		        		<div class="col-12 col-lg-6 input-group mx-0 pr-0">

		        			<div class="input-group-append">
		                        <span class="input-group-text">
		                            Type:
		                        </span>
		                    </div>

		                    <select 
		                    class="form-control"                               
		                    name="type_video"
		                    >
		                        <?php if ($service->video_service != null): ?>

		                        	<?php if (json_decode($service->video_service, true)[0] == "youtube"): ?>

		                        		<option value="youtube">YouTube</option>
		                                <option value="vimeo">Vimeo</option>

		                        	<?php else: ?>

		                        		<option value="vimeo">Vimeo</option>
		                                <option value="youtube">YouTube</option>

		                        	<?php endif ?>

		                        <?php else: ?>

		                            <option value="">Select Platform</option>
		                            <option value="youtube">YouTube</option>
		                            <option value="vimeo">Vimeo</option>

		                        <?php endif ?>

		                    </select>

		        		</div>

		        		<div class="col-12 col-lg-6  input-group mx-0">
		        			
		        			<div class="input-group-append">
		                        <span class="input-group-text">
		                            Id:
		                        </span>
		                    </div>

		                    <input
		                    type="text"
		                    class="form-control"                               
		                    name="id_video"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,100}"
		                    maxlength="100"
		                    onchange="validateJS(event,'regex')"
		                    <?php if ($service->video_service != null): ?>
	                        value="<?php echo json_decode($service->video_service, true)[1] ?>"
	                        <?php endif ?>
		                    >

		                    <div class="valid-feedback">Valid.</div>
                    		<div class="invalid-feedback">Please fill out this field.</div>   

		        		</div>

		        	</div>


		        </div>

		          <!--=====================================
		        Banner Top de la servicio
		        ======================================--> 

		        <div class="form-group mt-2">
		            
		            <label>Servicio Top Banner<sup class="text-danger">*</sup>, Ex:</label>

		            <figure class="pb-5">
		                
		                <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/services/default/example-top-banner.png" class="img-fluid">

		            </figure>

		            <div class="row mb-5">
		                
		                <!--=====================================
		                H3 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">
		                     
		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3 Tag:
		                        </span>
		                    </div>

		                    <input 
		                    type="text"
		                    class="form-control"
		                    placeholder="Ex: 20%"
		                    name="topBannerH3Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    value="<?php echo json_decode($service->top_banner_service, true)["H3 tag"] ?>"
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                 </div>

		                <!--=====================================
		                P1 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            P1 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Disccount"
		                    name="topBannerP1Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    value="<?php echo json_decode($service->top_banner_service, true)["P1 tag"] ?>" 
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                <!--=====================================
		                H4 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H4 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: For Books Of March"
		                    name="topBannerH4Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    value="<?php echo json_decode($service->top_banner_service, true)["H4 tag"] ?>"
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                 <!--=====================================
		                P2 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            P2 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Enter Promotion"
		                    name="topBannerP2Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    value="<?php echo json_decode($service->top_banner_service, true)["P2 tag"] ?>"
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                <!--=====================================
		                Span Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Span Tag:
		                        </span>
		                    </div>

		                    <input 
		                    type="text"
		                    class="form-control"
		                    placeholder="Ex: Sale2019"
		                    name="topBannerSpanTag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')"
		                    value="<?php echo json_decode($service->top_banner_service, true)["Span tag"] ?>"  
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                 <!--=====================================
		                Button Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Button Tag:
		                        </span>
		                    </div>

		                    <input 
		                    type="text"
		                    class="form-control"
		                    placeholder="Ex: Shop now"
		                    name="topBannerButtonTag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    value="<?php echo json_decode($service->top_banner_service, true)["Button tag"] ?>"
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                <!--=====================================
		                IMG Tag
		                ======================================-->

		                <div class="col-12">

		                    <label>IMG Tag:</label>

		                    <div class="form-group__content">

		                        <label class="pb-5" for="topBanner">
		                           <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/services/<?php echo $service->url_category ?>/top/<?php echo json_decode($service->top_banner_service, true)["IMG tag"] ?>" class="img-fluid changeTopBanner">
		                        </label> 

		                        <div class="custom-file">

		                            <input type="file"
		                            class="custom-file-input"
		                            id="topBanner"
		                            name="topBanner"
		                            accept="image/*"
		                            maxSize="2000000"
		                            onchange="validateImageJS(event, 'changeTopBanner')"
		                            >

		                            <div class="valid-feedback">Valid.</div>
		                            <div class="invalid-feedback">Please fill out this field.</div>

		                            <label class="custom-file-label" for="topBanner">Choose file</label>   

		                        </div>       

		                    </div>

		                </div>


		            </div>

		        </div>

		        <!--=====================================
		        Banner por defecto de la servicio
		        ======================================--> 

		        <div class="form-group mt-2">

		            <label>Servicio Default Banner<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">

		                <label class="pb-5" for="defaultBanner">
		                   <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/services/<?php echo $service->url_category ?>/default/<?php echo $service->default_banner_service ?>" class="img-fluid changeDefaultBanner" style="width:500px">
		                </label> 

		                <div class="custom-file">

		                    <input type="file"
		                    class="custom-file-input"
		                    id="defaultBanner"
		                    name="defaultBanner"
		                    accept="image/*"
		                    maxSize="2000000"
		                    onchange="validateImageJS(event, 'changeDefaultBanner')"
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                    <label class="custom-file-label" for="defaultBanner">Choose file</label>   

		                </div>         
		                
		            </div>

		        </div>

		         <!--=====================================
		        Slide Horizontal de la servicio
		        ======================================--> 

		        <div class="form-group mt-2">
		            
		            <label>Servicio Horizontal Slider<sup class="text-danger">*</sup>, Ex:</label>

		            <figure class="pb-5">
		                
		                <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/services/default/example-horizontal-slider.png" class="img-fluid">

		            </figure>

		            <div class="row mb-3">
		                
		                <!--=====================================
		                H4 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H4 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Limit Edition"
		                    name="hSliderH4Tag"       
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')" 
		                    value="<?php echo json_decode($service->horizontal_slider_service, true)["H4 tag"] ?>"
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                <!--=====================================
		                H3-1 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3-1 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Happy Summer"
		                    name="hSliderH3_1Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')"
		                    value="<?php echo json_decode($service->horizontal_slider_service, true)["H3-1 tag"] ?>" 
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                <!--=====================================
		                H3-2 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3-2 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Combo Super Cool"
		                    name="hSliderH3_2Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')"
		                    value="<?php echo json_decode($service->horizontal_slider_service, true)["H3-2 tag"] ?>" 
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                <!--=====================================
		                H3-3 Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3-3 Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Up to"
		                    name="hSliderH3_3Tag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')"
		                    value="<?php echo json_decode($service->horizontal_slider_service, true)["H3-3 tag"] ?>" 
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                <!--=====================================
		                H3-4s Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 pr-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            H3-4s Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: 40%"
		                    name="hSliderH3_4sTag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')"
		                    value="<?php echo json_decode($service->horizontal_slider_service, true)["H3-4s tag"] ?>" 
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>


		                <!--=====================================
		                Button Tag
		                ======================================-->

		                <div class="col-12 col-lg-6 input-group mx-0 mb-3">

		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Button Tag:
		                        </span>
		                    </div>

		                    <input type="text"
		                    class="form-control"
		                    placeholder="Ex: Shop now"
		                    name="hSliderButtonTag"
		                    pattern="[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\'\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,50}"
		                    maxlength="50"
		                    onchange="validateJS(event,'regex')"
		                    value="<?php echo json_decode($service->horizontal_slider_service, true)["Button tag"] ?>"  
		                    required
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                </div>

		                <!--=====================================
		                IMG Tag
		                ======================================-->

		                <div class="col-12">

		                    <label>IMG Tag:</label>

		                    <div class="form-group__content">

		                        <label class="pb-5" for="hSlider">
		                           <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/services/<?php echo $service->url_category ?>/horizontal/<?php echo json_decode($service->horizontal_slider_service, true)["IMG tag"] ?>" class="img-fluid changeHSlider">
		                        </label> 

		                        <div class="custom-file">

		                            <input type="file"
		                            class="custom-file-input"
		                            id="hSlider"
		                            name="hSlider"
		                            accept="image/*"
		                            maxSize="2000000"
		                            onchange="validateImageJS(event, 'changeHSlider')"
		                            >

		                            <div class="valid-feedback">Valid.</div>
		                            <div class="invalid-feedback">Please fill out this field.</div>

		                            <label class="custom-file-label" for="hSlider">Choose file</label>   

		                        </div>         
		 
		                        
		                    </div>

		                </div>

		            </div>

		        </div> 

		        <!--=====================================
		        Slide Vertical de la servicio
		        ======================================--> 

		        <div class="form-group mt-2">

		            <label>Servicio Vertical Slider<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">

		                <label class="pb-5" for="vSlider">

		                    <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/services/<?php echo $service->url_category ?>/vertical/<?php echo $service->vertical_slider_service ?>" class="img-fluid changeVSlider" style="width:260px">

		                </label>

		                <div class="custom-file">

		                    <input type="file" 
		                    class="custom-file-input" 
		                    id="vSlider"
		                    name="vSlider"
		                    accept="image/*"
		                    maxSize="2000000"
		                    onchange="validateImageJS(event, 'changeVSlider')"
		                    >

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                    <label class="custom-file-label" for="vSlider">Choose file</label>

		                </div>     
		                
		            </div>

		        </div> 

		         <!--=====================================
		        Oferta del serviceo
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <!--<label>Servicio Offer Ex: <strong>Type:</strong> Disccount, <strong>Percent %:</strong> 25, <strong>End offer:</strong> 30/06/2020</label>-->

		            <div class="row mb-3">


		               <!--=====================================
		                Fecha de vencimiento de la servicio
						======================================-->

		                <div class="col-12 col-lg-4 input-group mx-0 pr-0">
		                    
		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            End Offer:
		                        </span>
		                    </div>

		                    <?php if ($service->offer_service != null): ?>

	                            <input type="date"
	                            class="form-control"
	                            name="date_offer"
	                            value="<?php echo $service->offer_service ?>">

	                        <?php else: ?>

	                            <input type="date"
	                            class="form-control"
	                            name="date_offer">
	                            
	                        <?php endif ?>

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>     

		                </div>
		                  

		            </div>   

		        </div>


				<!--=====================================
		                Planteles
						======================================-->

						<?php 

							$url = "campuses?select=id_campus,name_campus,shortname_campus";
							$method = "GET";
							$fields = array();

							$campuses = CurlController::request($url, $method, $fields)->results;

						?>
					
						<div class="form-group mt-2">
							
							<label>Planteles</label>

							<?php foreach ($campuses as $key => $value): ?>	

								<?php 
								$p_activo = "";
								foreach (json_decode($service->campus_service, true) as $plantel) {
									
									if($plantel == $value->shortname_campus){

										$p_activo = "checked";
									}
								}
								?>	

							<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
							<input type="checkbox" class="custom-control-input" id="<?php echo $value->shortname_campus ?>" name="planteles[]" value="<?php echo $value->shortname_campus ?>" <?php echo $p_activo ?>>
							<label class="custom-control-label" for="<?php echo $value->shortname_campus ?>"><?php echo $value->name_campus ?></label>
							</div>
							
							<?php endforeach ?>

							

						</div>

						<!--=====================================
		                Rol de visualización
						======================================-->

						<?php 

							$url = "roles?select=id_role,name_role,estatus_role&linkTo=estatus_role&equalTo=1";
							$method = "GET";
							$fields = array();

							$roles = CurlController::request($url, $method, $fields)->results;

						?>
					
						<div class="form-group mt-2">
							
							<label>Rol que pueden visualizar</label>

							<?php foreach ($roles as $key => $value2): ?>	
 
								<?php 
								$r_activo = "";
								foreach (json_decode($service->role_service, true) as $roless) {
									
									if($roless == $value2->name_role){

										$r_activo = "checked";
									}

								}
								if ($value2->id_role!=10)
								{
								?>	

									<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
									<input type="checkbox" class="custom-control-input" id="<?php echo $value2->name_role ?>" name="roless[]" value="<?php echo $value2->name_role ?>" <?php echo $r_activo ?>>
									<label class="custom-control-label" for="<?php echo $value2->name_role ?>"><?php echo $value2->name_role ?></label>
									</div>
							
							<?php 
								}
							endforeach ?>

							

						</div>

			</div>
		
		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/services" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right saveBtn">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>