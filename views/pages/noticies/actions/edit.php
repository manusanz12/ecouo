<?php 
	
	if(isset($routesArray[3])){
		
		$security = explode("~",base64_decode($routesArray[3]));
	
		if($security[1] == $_SESSION["admin"]->token_user){

			$select = "*";

			$url = "relations?rel=noticies,categories&type=noticie,category&select=".$select."&linkTo=id_noticie&equalTo=".$security[0];
			$method = "GET";
			$fields = array();

			$response = CurlController::request($url,$method,$fields);
			
			if($response->status == 200){

				$noticie = $response->results[0];

			}else{

				echo '<script>

				window.location = "/noticies";

				</script>';
			}

		}else{

			echo '<script>

			window.location = "/noticies";

			</script>';
		

		}


	}


?>

<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">

		<input type="hidden" value="<?php echo $noticie->id_noticie ?>" name="idnoticie">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/noticies.controller.php";

				$create = new NoticiesController();
				$create -> edit($noticie->id_noticie);

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Required</label>

				

				<!--=====================================
                Nombre de noticia
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre de Noticia <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}"
					onchange="validateJS(event,'text&number')"
					maxlength="100"
					name="name-noticie"
					value="<?php echo $noticie->name_noticie ?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>


				<!--=====================================
                Url de la noticia
                ======================================-->

				<div class="form-group mt-2">
					
					<label>URL de la Noticia <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					name="url-name_noticie"
					value="<?php echo $noticie->url_noticie ?>"
					required>

				</div>

				<!--=====================================
                Link de la noticia
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Link de la Noticia <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					name="link-name_noticie"
					value="<?php echo $noticie->link_noticie ?>"
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
							<option value="<?php echo $noticie->type_noticie ?>" selected><?php echo $noticie->type_noticie ?></option>
							<option value="Evento">Evento</option>
							<option value="Noticia" >Noticia</option>
		                    
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
		            value="<?php echo $noticie->name_category ?>"  
		            readonly>

		            <input type="hidden"  name="name-category" value="<?php echo $noticie->id_category ?>_<?php echo $noticie->url_category ?>"  >

		        </div>

			

		        <!--=====================================
                Imagen de Noticia
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Imagen de Noticia <sup class="text-danger">*</sup></label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/<?php echo $noticie->url_category ?>/<?php echo $noticie->image_noticie ?>" class="img-fluid changeImage" style="width:150px">

						</figure>

					</label>

					<div class="custom-file">
						
						<input 
						type="file" 
						id="customFile" 
						class="custom-file-input"
						accept="image/*"
						onchange="validateImageJS(event,'changeImage')"
						name="image-noticie"
						>

						<div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

						<label for="customFile" class="custom-file-label">Choose file</label>

					</div>

				</div>


		        <!--=====================================
		        Descripción de noticia
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Descripción de noticia<sup class="text-danger">*</sup></label>

		            <textarea
		            class="summernote"
		            name="description-noticie"
		            required
		            ><?php echo $noticie->description_noticie ?></textarea>

		            <div class="valid-feedback">Valid.</div>
		            <div class="invalid-feedback">Please fill out this field.</div>

		        </div>

		        <!--=====================================
                Palabras Claves
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Tags noticia</label>

					<input 
					type="text" 
					class="form-control tags-input"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="tags-noticie"
					value="<?php echo implode(",",json_decode($noticie->tags_noticie,true)) ?>"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>	

				
		        <!--=====================================
		        Galería de la noticia
		        ======================================-->

		        <div class="form-group mt-2">
		        	
		        	<label>Galeria de noticia: <sup class="text-danger">*</sup></label> 

		        	<div class="dropzone mb-3">

		        		<?php foreach (json_decode($noticie->gallery_noticie,true) as $value): ?>

		            		<div class="dz-preview dz-file-preview"> 

		            			<div class="dz-image">
		            			 	
		            			 	<img class="img-fluid" src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/<?php echo $noticie->url_category ?>/gallery/<?php echo $value ?>">

		            			</div>

		            			<a class="dz-remove" data-dz-remove remove="<?php echo $value?>" onclick="removeGallery(this)">Remove file</a>

		            		</div>   
		            		
            			<?php endforeach ?>
		        	 	
		        		<div class="dz-message">
		        			
		        			Drop your images here, size max 500px * 500px

		        		</div>

		        	</div>

		        	<input type="hidden" name="gallery-noticie-old" value='<?php echo $noticie->gallery_noticie ?>'>

		        	<input type="hidden" name="gallery-noticie">

		        	<input type="hidden" name="delete-gallery-noticie">

		        </div>

		        <!--=====================================
		        Video de la noticia
		        ======================================-->

		        <div class="form-group mt-2">
		        	

		        	<label>noticie Video | Ex: <strong>Type:</strong> YouTube, <strong>Id:</strong> Sl5FaskVpD4</label> 

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
		                        <?php if ($noticie->video_noticie != null): ?>

		                        	<?php if (json_decode($noticie->video_noticie, true)[0] == "youtube"): ?>

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
		                    <?php if ($noticie->video_noticie != null): ?>
	                        value="<?php echo json_decode($noticie->video_noticie, true)[1] ?>"
	                        <?php endif ?>
		                    >

		                    <div class="valid-feedback">Valid.</div>
                    		<div class="invalid-feedback">Please fill out this field.</div>   

		        		</div>

		        	</div>


		        </div>

		          <!--=====================================
		        Banner Top de la noticia
		        ======================================--> 

		        <div class="form-group mt-2">
		            
		            <label>noticie Top Banner<sup class="text-danger">*</sup>, Ex:</label>

		            <figure class="pb-5">
		                
		                <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/default/example-top-banner.png" class="img-fluid">

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
		                    value="<?php echo json_decode($noticie->top_banner_noticie, true)["H3 tag"] ?>"
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
		                    value="<?php echo json_decode($noticie->top_banner_noticie, true)["P1 tag"] ?>" 
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
		                    value="<?php echo json_decode($noticie->top_banner_noticie, true)["H4 tag"] ?>"
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
		                    value="<?php echo json_decode($noticie->top_banner_noticie, true)["P2 tag"] ?>"
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
		                    value="<?php echo json_decode($noticie->top_banner_noticie, true)["Span tag"] ?>"  
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
		                    value="<?php echo json_decode($noticie->top_banner_noticie, true)["Button tag"] ?>"
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
		                           <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/<?php echo $noticie->url_category ?>/top/<?php echo json_decode($noticie->top_banner_noticie, true)["IMG tag"] ?>" class="img-fluid changeTopBanner">
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
		        Banner por defecto de la noticia
		        ======================================--> 

		        <div class="form-group mt-2">

		            <label>noticie Default Banner<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">

		                <label class="pb-5" for="defaultBanner">
		                   <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/<?php echo $noticie->url_category ?>/default/<?php echo $noticie->default_banner_noticie ?>" class="img-fluid changeDefaultBanner" style="width:500px">
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
		        Slide Horizontal de la noticia
		        ======================================--> 

		        <div class="form-group mt-2">
		            
		            <label>noticie Horizontal Slider<sup class="text-danger">*</sup>, Ex:</label>

		            <figure class="pb-5">
		                
		                <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/default/example-horizontal-slider.png" class="img-fluid">

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
		                    value="<?php echo json_decode($noticie->horizontal_slider_noticie, true)["H4 tag"] ?>"
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
		                    value="<?php echo json_decode($noticie->horizontal_slider_noticie, true)["H3-1 tag"] ?>" 
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
		                    value="<?php echo json_decode($noticie->horizontal_slider_noticie, true)["H3-2 tag"] ?>" 
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
		                    value="<?php echo json_decode($noticie->horizontal_slider_noticie, true)["H3-3 tag"] ?>" 
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
		                    value="<?php echo json_decode($noticie->horizontal_slider_noticie, true)["H3-4s tag"] ?>" 
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
		                    value="<?php echo json_decode($noticie->horizontal_slider_noticie, true)["Button tag"] ?>"  
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
		                           <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/<?php echo $noticie->url_category ?>/horizontal/<?php echo json_decode($noticie->horizontal_slider_noticie, true)["IMG tag"] ?>" class="img-fluid changeHSlider">
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
		        Slide Vertical de la noticia
		        ======================================--> 

		        <div class="form-group mt-2">

		            <label>noticie Vertical Slider<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">

		                <label class="pb-5" for="vSlider">

		                    <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/<?php echo $noticie->url_category ?>/vertical/<?php echo $noticie->vertical_slider_noticie ?>" class="img-fluid changeVSlider" style="width:260px">

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
		        Oferta del noticieo
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>noticie Offer Ex: <strong>Type:</strong> Disccount, <strong>Percent %:</strong> 25, <strong>End offer:</strong> 30/06/2020</label>

		            <div class="row mb-3">


		               <!--=====================================
		                Fecha de vencimiento de la noticia
						======================================-->

		                <div class="col-12 col-lg-4 input-group mx-0 pr-0">
		                    
		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            End Offer:
		                        </span>
		                    </div>

		                    <?php if ($noticie->offer_noticie != null): ?>

	                            <input type="date"
	                            class="form-control"
	                            name="date_offer"
	                            value="<?php echo $noticie->offer_noticie ?>">

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

			</div>
		
		</div>

		<div class="card-footer">
			
			<div class="col-md-8 offset-md-2">
	
				<div class="form-group mt-3">

					<a href="/noticies" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right saveBtn">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>