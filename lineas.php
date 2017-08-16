<?php include 'header.php'; ?>
<?php 
mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "select * from cmd_servicios where ser_activo = 1 and ser_idioma='".$_SESSION["idioma"]."'";
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
$totalRows_mos_portada = mysql_num_rows($mos_portada); 
/*
$query_mos_inicio = "select ini_inicio,ini_imagen from cmd_inicio where ini_idioma='".$_SESSION["idioma"]."'";
$mos_inicio = mysql_query($query_mos_inicio, $conexion) or die(mysql_error());
$row_mos_inicio = mysql_fetch_assoc($mos_inicio);*/
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
                                <li ><a href="index.php"><?php echo $row_mos_url['url_inicio']; ?></a>
                                </li>
                                <li class="dropdown"><a href="nosotros.php"><?php echo $row_mos_url['url_nosotros']; ?></a>
                                </li>
                                <li class="current dropdown" ><a href="servicios.php"><?php echo $row_mos_url['url_servicios']; ?></a>
                                </li>
                                <li><a href="galeria.php"><?php echo $row_mos_url['url_galeria']; ?></a></li>
                                <li><a href="videos.php"><?php echo $row_mos_url['url_video']; ?></a>
                                
                                </li> <li><a href="paquetes.php"><?php echo $row_mos_url['url_paquetes']; ?></a></li>
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
        	<h1><?php echo $row_mos_url['url_servicios']; ?></h1>
            <ul class="bread-crumb"><li><a href="index.html"><?php echo $row_mos_url['url_inicio']; ?></a></li> <li><?php echo $row_mos_url['url_servicios']; ?></li></ul>
        </div>
    </section>
    
    <section class="about-us-area">
    	<!--About Upper-->
        <div class="about-upper">
        	<div class="auto-container">
            
            	 <div class="sec-title wow fadeInLeft" data-wow-delay="300ms" data-wow-duration="1000ms">
                    <h2><?php echo $row_mos_url['url_servicios'];?></h2>
                </div>
                    
                <div class="sec-text wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
                    
                    
                    <ul>
                  <?php do { ?>  
                                       
               <li><span class="fa   fa-circle">  </span> <?php echo  $row_mos_portada['ser_descripcion']; ?>                </li>
                           <?php } while ($row_mos_portada = mysql_fetch_assoc($mos_portada)); ?>                
                    </ul>
                    
                </div>
                

                
                <figure class="image wow zoomIn" data-wow-delay="300ms" data-wow-duration="1000ms"><img src="images/resource/servicios.jpg" alt="" width="100%" height="100%"></figure>

  <div class="about-lower">
        
        </div>
            </div>

        </div>
        
    </section>
    
   <?php include 'footer.php'; ?>