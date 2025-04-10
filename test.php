<div class="card">
              <div class="card-header">
                <h3 class="card-title-home">Servicios</h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <!-- we are adding the accordion ID so Bootstrap's collapse plugin detects it -->
                <div id="accordion">
                  <div class="card card-primary">
                    <div class="card-header">
                      <h4 class="card-title-home w-100">
                        <a class="d-block w-100" data-toggle="collapse" href="#collapseOne">
                          Academia
                        </a>
                      </h4>
                    </div>
                    <div id="collapseOne" class="collapse show" data-parent="#accordion">
                      <div class="card-body">
                          <?php foreach ($ServicesHSlider as $key => $value): ?>

                                <div class="col-xl-2 col-lg-3 col-sm-4 col-6 ">
                                    <div class="ps-block--category">
                                        <a class="ps-block__overlay" href="<?php echo $value->link_service ?>" target="_blank"></a>
                                        <img src="/views/assets/img/services/<?php echo $value->url_category ?>/<?php echo $value->image_service ?>" alt="<?php echo $value->name_service ?>">
                                        <p><?php echo $value->name_service ?></p>
                                    </div>
                                </div>
                              
                          <?php endforeach ?>

                              
                      </div>
                    </div>
                  </div>
                  <div class="card card-danger">
                    <div class="card-header">
                      <h4 class="card-title w-100">
                        <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">
                          Administrativos
                        </a>
                      </h4>
                    </div>
                    <div id="collapseTwo" class="collapse" data-parent="#accordion">
                      <div class="card-body">
                      <?php foreach ($ServicesAdmHSlider as $key => $value): ?>

                            <div class="col-xl-2 col-lg-3 col-sm-4 col-6 ">
                                <div class="ps-block--category">
                                    <a class="ps-block__overlay" href="<?php echo $value->link_service ?>" target="_blank"></a>
                                    <img src="/views/assets/img/services/<?php echo $value->url_category ?>/<?php echo $value->image_service ?>" alt="<?php echo $value->name_service ?>">
                                    <p><?php echo $value->name_service ?></p>
                                </div>
                            </div>

                      <?php endforeach ?>

                      </div>
                    </div>
                  </div>
                  
                </div>
              </div>
              <!-- /.card-body -->
            </div>