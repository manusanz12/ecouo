<div class="card card-dark card-outline">

	<form method="post" class="needs-validation" novalidate enctype="multipart/form-data">
	
		<div class="card-header">

			<?php

			 	require_once "controllers/noticies.controller.php";

				$create = new NoticiesController();
				$create -> create();

			?>
			
			<div class="col-md-8 offset-md-2">	

				<label class="text-danger float-right"><sup>*</sup> Required</label>

				<!--=====================================
                Nombre de la Noticia
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Nombre de la Noticia <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					pattern="[0-9A-Za-zñÑáéíóúÁÉÍÓÚ ]{1,100}"
					onchange="validateRepeat(event,'text&number','noticies','name_noticie')"
					maxlength="100"
					name="name-noticie"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>


				<!--=====================================
                Url de la Noticia
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Url de la noticia <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					readonly
					name="url-name_noticie"
					required>

				</div>

				<!--=====================================
                Link de la Noticia
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Link de la noticia <sup class="text-danger">*</sup></label>

					<input 
					type="text" 
					class="form-control"
					name="link-name_noticie"
					required>

				</div>

				<!--=====================================
		        Tipo
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Tipo<sup class="text-danger">*</sup></label>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="name-type"
		                style="width:100%"
		                required>

		                    <option value="">Select Type</option>
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

		            <?php 

		            $url = "categories?select=id_category,name_category,url_category";
		            $method = "GET";
		            $fields = array();

		            $categories = CurlController::request($url, $method, $fields)->results;

		            ?>

		            <div class="form-group">
		                
		                <select
		                class="form-control select2"
		                name="name-category"
		                style="width:100%"
		                onchange="changeCategory(event, 'noticies')"
		                required>

		                    <option value="">Select Category</option>

		                    <?php foreach ($categories as $key => $value): ?>	

		                        <option value="<?php echo $value->id_category ?>_<?php echo $value->url_category ?>"><?php echo $value->name_category ?></option>
		                      
		                    <?php endforeach ?>

		                </select>

		                <div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

		            </div>

		        </div>

		        <!--=====================================
                Imagen de la Noticia
                ======================================-->

				<div class="form-group mt-2">
					
					<label>Imagen de la Noticia <sup class="text-danger">*</sup></label>
			
					<label for="customFile" class="d-flex justify-content-center">
						
						<figure class="text-center py-3">
							
							<img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/default/default-image.jpg" class="img-fluid changeImage" style="width:150px">

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
						required>

						<div class="valid-feedback">Valid.</div>
            			<div class="invalid-feedback">Please fill out this field.</div>

						<label for="customFile" class="custom-file-label">Choose file</label>

					</div>

				</div>


		        <!--=====================================
		        Descripción de la Noticia
		        ======================================-->

		        <div class="form-group mt-2">
		            
		            <label>Descripción de la Noticia<sup class="text-danger">*</sup></label>

		            <textarea
		            class="summernote"
		            name="description-noticie"
		            required
		            ></textarea>

		            <div class="valid-feedback">Valid.</div>
		            <div class="invalid-feedback">Please fill out this field.</div>

		        </div>
 
		        <!--=====================================
                Palabras Claves
                ======================================-->
				
				<div class="form-group mt-2">
					
					<label>Tags Noticias</label>

					<input 
					type="text" 
					class="form-control tags-input"
					pattern='[-\\(\\)\\=\\%\\&\\$\\;\\_\\*\\"\\#\\?\\¿\\!\\¡\\:\\,\\.\\0-9a-zA-ZñÑáéíóúÁÉÍÓÚ ]{1,}'
					onchange="validateJS(event,'regex')"
					name="tags-noticie"
					required>

					<div class="valid-feedback">Valid.</div>
            		<div class="invalid-feedback">Please fill out this field.</div>

				</div>	

				<!--=====================================
		        Galería de noticia
		        ======================================-->

		        <div class="form-group mt-2">
		        	
		        	<label>Gallery de Noticia: <sup class="text-danger">*</sup></label> 

		        	<div class="dropzone mb-3">
		        	 	
		        		<div class="dz-message">
		        			
		        			Drop your images here, size max 500px * 500px

		        		</div>

		        	</div>

		        	<input type="hidden" name="gallery-noticie">

		        </div>

				<!--=====================================
		        Video de la noticia
		        ======================================-->

		        <div class="form-group mt-2">
		        	

		        	<label>Video Noticia | Ex: <strong>Type:</strong> YouTube, <strong>Id:</strong> Sl5FaskVpD4</label> 

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
		                        <option value="">Select Platform</option>
		                        <option value="youtube">YouTube</option>
		                        <option value="vimeo">Vimeo</option>

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
		            
		            <label>Noticia Top Banner<sup class="text-danger">*</sup>, Ex:</label>

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
		                           <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/default/default-top-banner.jpg" class="img-fluid changeTopBanner">
		                        </label> 

		                        <div class="custom-file">

		                            <input type="file"
		                            class="custom-file-input"
		                            id="topBanner"
		                            name="topBanner"
		                            accept="image/*"
		                            maxSize="2000000"
		                            onchange="validateImageJS(event, 'changeTopBanner')"
		                            required>

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

		            <label>Noticia Default Banner<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">

		                <label class="pb-5" for="defaultBanner">
		                   <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/default/default-banner.jpg" class="img-fluid changeDefaultBanner" style="width:500px">
		                </label> 

		                <div class="custom-file">

		                    <input type="file"
		                    class="custom-file-input"
		                    id="defaultBanner"
		                    name="defaultBanner"
		                    accept="image/*"
		                    maxSize="2000000"
		                    onchange="validateImageJS(event, 'changeDefaultBanner')"
		                    required>

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
		            
		            <label>Noticia Horizontal Slider<sup class="text-danger">*</sup>, Ex:</label>

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
		                           <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/default/default-horizontal-slider.jpg" class="img-fluid changeHSlider">
		                        </label> 

		                        <div class="custom-file">

		                            <input type="file"
		                            class="custom-file-input"
		                            id="hSlider"
		                            name="hSlider"
		                            accept="image/*"
		                            maxSize="2000000"
		                            onchange="validateImageJS(event, 'changeHSlider')"
		                            required>

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

		            <label>Noticia Vertical Slider<sup class="text-danger">*</sup></label>

		            <div class="form-group__content">

		                <label class="pb-5" for="vSlider">

		                    <img src="<?php echo TemplateController::srcImg() ?>views/assets/img/noticies/default/default-vertical-slider.jpg" class="img-fluid changeVSlider" style="width:260px">

		                </label>

		                <div class="custom-file">

		                    <input type="file" 
		                    class="custom-file-input" 
		                    id="vSlider"
		                    name="vSlider"
		                    accept="image/*"
		                    maxSize="2000000"
		                    onchange="validateImageJS(event, 'changeVSlider')"
		                    required>

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>

		                    <label class="custom-file-label" for="vSlider">Choose file</label>

		                </div>     
		                
		            </div>

		        </div> 

				 <!--=====================================
		                Fecha de vencimiento de la oferta
		                ======================================-->

		                <div class="col-12 col-lg-4 form-group__content input-group mx-0 pr-0">
		                    
		                    <div class="input-group-append">
		                        <span class="input-group-text">
		                            Fecha de vencimiento:
		                        </span>
		                    </div>

		                    <input type="date"
		                    class="form-control"
		                    name="date_offer">

		                    <div class="valid-feedback">Valid.</div>
		                    <div class="invalid-feedback">Please fill out this field.</div>     

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

							<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
								<input type="checkbox" class="custom-control-input" id="<?php echo $value->shortname_campus ?>" name="planteles[]" value="<?php echo $value->shortname_campus ?>">
								<label class="custom-control-label" for="<?php echo $value->shortname_campus ?>"><?php echo $value->name_campus ?></label>
							</div>
							
							<?php endforeach ?>

							

						</div>
			<!--=====================================
                Visualizar Roles
            ======================================-->

						<div class="form-group mt-2">
							<?php 

								$url = "roles?select=id_role,name_role,estatus_role&linkTo=estatus_role&equalTo=1";
								$method = "GET";
								$fields = array();

								$roles = CurlController::request($url, $method, $fields)->results;

							?>
							<label>Roles que pueden visualizar</label>
							

							<?php foreach ($roles as $key => $value2): 
								
							if ($value2->id_role!=10)
								{	
							?>	
							
								<div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
									<input type="checkbox" class="custom-control-input" id="<?php echo $value2->name_role ?>" name="roless[]" value="<?php echo $value2->name_role ?>">
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

					<a href="/noticies" class="btn btn-light border text-left">Regresar</a>
					
					<button type="submit" class="btn bg-dark float-right saveBtn">Guardar</button>

				</div>

			</div>

		</div>


	</form>


</div>