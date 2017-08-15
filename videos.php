<?php include 'header.php'; ?>
<?php 
mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "select * from cmd_servicios where ser_activo = 1 and ser_idioma='".$_SESSION["idioma"]."'";
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
$totalRows_mos_portada = mysql_num_rows($mos_portada); 

$query_mos_video = "select vid_id, vid_nombre, right(vid_url,11) as vid_url, vid_activo from cmd_video where vid_activo = 1";
$mos_video = mysql_query($query_mos_video, $conexion) or die(mysql_error());
$row_mos_video = mysql_fetch_assoc($mos_video);
?>
        <!-- Header Lower -->
        <div class="header-lower">
        	<div class="auto-container clearfix">
                <!--Logo-->
                <div class="logo"><a href="index.html"><img src="images/logo-2.png" alt="Bulldozer" title="Bulldozer"></a></div>
                
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
                                <li><a href="servicios.php"><?php echo $row_mos_url['url_servicios']; ?></a>
                                </li>
                                <li><a href="galeria.php"><?php echo $row_mos_url['url_galeria']; ?></a></li>
                                <li class="current dropdown" ><a href="videos.php"><?php echo $row_mos_url['url_video']; ?></a>
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
    <!--End Main Header -->
    
    <!-- Main Slider -->
   
    
    <!--Facts Counter Style Two-->
   
    
    <!--Featured Services-->
   
    
    
    <!--Services Area-->
  
    
    <!--We Are Best-->
      <section class="page-banner" style="background-image:url(images/background/page-banner-bg-2.jpg);">
    	<div class="auto-container text-center">
            <h1><?php echo $row_mos_url['url_video']; ?></h1>
            <ul class="bread-crumb"><li><a href="index.php"><?php echo $row_mos_url['url_inicio']; ?></a></li> <li><?php echo $row_mos_url['url_video']; ?></li></ul>
        	
        </div>
    </section>
    
    
    
    
    
    
    
    <section class="our-projects with-margin">
    	<!--About Upper-->
        
        
        <div class="about-upper">
        	<div class="auto-container">
            
           
           
           
           
           
            
          <?php do { ?>   
            
            <article >
            	
                <iframe width="100%"  height="450px"  src="https://www.youtube.com/embed/<?php echo $row_mos_video['vid_url'];?>" frameborder="0" allowfullscreen></iframe>

            </article>
                  
             <?php } while ($row_mos_video = mysql_fetch_assoc($mos_video)); ?> 
                      
                
                
            
        
            
            
                
            </div>





        </div>
        







        <!--About Lower-->
       
        
    </section>
    
   <?php include 'footer.php'; ?>