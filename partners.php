<?php include 'header.php'; ?>
<?php 
mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "select * from cmd_partners order by par_id desc";
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
$totalRows_mos_portada = mysql_num_rows($mos_portada); 
/*
mysql_select_db($database_conexion, $conexion);
$query_mos_noticias = "SELECT * FROM ".$tabla." where not_activo=1 order by not_id desc LIMIT 5";
$mos_noticias = mysql_query($query_mos_noticias, $conexion) or die(mysql_error());
$row_mos_noticias = mysql_fetch_assoc($mos_noticias);
$totalRows_mos_noticias = mysql_num_rows($mos_noticias);

mysql_select_db($database_conexion, $conexion);

$query_mos_count = "SELECT not_id FROM ".$tabla." where  not_activo=1 order by not_id desc";

$mos_count = mysql_query($query_mos_count, $conexion) or die(mysql_error());

$row_mos_count = mysql_fetch_assoc($mos_count);

$total_noticias = mysql_num_rows($mos_count);

$resultado = 5;

//

$paginacion = new Zebra_Pagination();

$paginacion->records($total_noticias); // total filas

$paginacion->records_per_page($resultado);// numero por pagina



mysql_select_db($database_conexion, $conexion);

$query_mos_noticia = "select * from ".$tabla." where not_activo=1 order by not_id desc LIMIT ".(($paginacion->get_page() - 1) * $resultado) .",".$resultado."";

$mos_noticia = mysql_query($query_mos_noticia, $conexion) or die(mysql_error());

$row_mos_noticia = mysql_fetch_assoc($mos_noticia);

$totalRows_mos_noticia = mysql_num_rows($mos_noticia);
*/
?>
<!-- Header Lower -->
        <div class="header-lower">
            <div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo"><a href="index.php"><img src="images/logo-2.png" alt="Bulldozer" title="Bulldozer"></a></div>
                
                <!--Right Container-->
                <div class="right-cont clearfix">
                    
                    
                    <!-- Main Menu -->
                    <nav class="main-menu">
                        <div class="navbar-header">
                            <!-- Toggle Button -->      
                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                                <span class="icon-bar"></span>
                            </button>
                        </div>
                        
                        <div class="navbar-collapse collapse clearfix">                                                                                              
                            <ul class="nav navbar-nav navbar-right">
                                <li><a href="index.php"><?php echo $row_mos_url['url_inicio']; ?></a>
                                </li>
                                <li class="dropdown"><a href="empresa.php"><?php echo $row_mos_url['url_nosotros']; ?></a>
                                </li>
                                <li class="dropdown"><a href="lineas.php"><?php echo $row_mos_url['url_servicios']; ?></a>
                                </li>
                                <li class="dropdown"><a href="galeria.php"><?php echo $row_mos_url['url_galeria']; ?></a></li>
                                <li><a href="videos.php"><?php echo $row_mos_url['url_video']; ?></a>
                                </li>
                                 <li class="dropdown current"> <a href="partners.php"><?php echo $row_mos_url['url_paquetes']; ?></a></li>
                                <li><a href="contacto.php"><?php echo $row_mos_url['url_contacto']; ?></a></li>
                                
                            </ul>

                            <div class="clearfix"></div>
        
                        </div>
                    </nav>
                    <!-- Main Menu End-->
                </div>
                
            </div>
            
        </div>
        
        
    </header>
    <!--We Are Best-->
      <section class="page-banner" style="background-image:url(images/background/page-banner-bg-2.jpg);">
    	<div class="auto-container text-center">
        	<h1><?php echo $row_mos_url['url_paquetes']; ?></h1>
            <ul class="bread-crumb"><li><a href="index.html"><?php echo $row_mos_url['url_inicio']; ?></a></li> <li><?php echo $row_mos_url['url_paquetes']; ?></li></ul>
        </div>
    </section>
    
     <!--Services Area Three Column-->
    <section class="services-area">
        <div class="auto-container">
         <!--    
            <div class="sec-title wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="1000ms">
                <h2>Our <span>Services</span></h2>
            </div>
                
           <div class="sec-text wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
                <p>There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in<br>some form, by injected humour, or randomised words which don't look even slightly believable</p>
            </div>
            -->
            
            <!--Service Tabs Style Two / Three Column-->
                <div class="service-tabs style-two three-column">
                
              
                
             
                             <!--Client Logos-->
                    <section class="client-logo wow fadeIn" data-wow-delay="300ms" data-wow-duration="1000ms">
                        <div class="auto-container">
                            <div class="slider-container">
                                
                                <ul class="slider">
                                <?php do { ?>
                                    <li><a href="#">
                                        <img src="images/clients/<?php echo $row_mos_portada['par_imagen'];?>" alt="" title="<?php echo $row_mos_portada['par_descrip']; ?>" height="80px" width="200px"></a>
                                    </li>
                                <?php } while ($row_mos_portada = mysql_fetch_assoc($mos_portada)); ?>
                                </ul>
                                
                            </div>
                        </div>
                    </section>
    
                    
                  
                    
                   
                    
                </div>
                
            </div>
        </div>
    </section>
    
    
<?php include 'footer.php'; ?>