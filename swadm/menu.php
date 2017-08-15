  <section class="sidebar">
                    <!-- Sidebar user panel -->
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="img/anonimo90.png" class="img-circle" alt="User Image" />
                        </div>
                        <div class="pull-left info">
                            <p><?php echo $row_mos_usuario["usu_nombre"];?> </p>

                            <a href="#"><i class="fa fa-circle text-success"></i> Conectado</a>
                        </div>
                    </div>                
                    <ul class="sidebar-menu">
                        <li>
                            <a href="index.php">
                                <i class="fa fa-th"></i> <span>Inicio</span>
                            </a>
                        </li>
                        <li class="treeview active">
                            <a href="#">
                                <i class="fa fa-bar-chart-o"></i>
                                <span>Mantenedores</span>
                                <i class="fa pull-right fa-angle-down"></i>
                            </a>
                            <ul class="treeview-menu" style="display: block;">
                                                            <li><a href="inicio.php" style="margin-left: 10px;">
                                <i class="fa fa-angle-double-right"></i>Inicio</a>
                              </li>                
                              <li>
                                                          <a href="portada.php" style="margin-left: 10px;">
                                <i class="fa fa-angle-double-right"></i>Portada</a>
                              </li>                
                              <li><a href="nosotros.php" style="margin-left: 10px;">
                                <i class="fa fa-angle-double-right"></i>Nosotros</a>
                              </li>                
                              <li><a href="servicios.php" style="margin-left: 10px;">
                                <i class="fa fa-angle-double-right"></i>Servicios</a>
                              </li>                
                              <li><a href="album.php" style="margin-left: 10px;">
                                <i class="fa fa-angle-double-right"></i>Galería de Imágenes</a>
                              </li>                       
                              <li><a href="video.php" style="margin-left: 10px;">
                                <i class="fa fa-angle-double-right"></i>Video</a>
                              </li>         
                              <li><a href="paquetes.php" style="margin-left: 10px;">
                                <i class="fa fa-angle-double-right"></i>Paquetes</a>
                              </li>                  
                            </ul>
                        </li>
                     
                        
                        <li class="treeview active">
                            <a href="#">
                                <i class="fa fa-table"></i> <span>Configuración</span>
                                <i class="fa fa-angle-left pull-right"></i>
                            </a>
                            <ul class="treeview-menu">
                              <li><a href="configcontacto.php">
                                <i class="fa fa-angle-double-right"></i> Contacto</a>
                              </li>     
                                <li><a href="url.php">
                                <i class="fa fa-angle-double-right"></i> Url</a>
                              </li>                 
                            </ul>
                            
                                      
                     
                        </li>
                    </ul>
                </section>