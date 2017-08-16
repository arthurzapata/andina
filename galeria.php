<?php include 'header.php'; ?>
<?php 
mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "select f.fot_id,f.fot_nombre,f.fot_activo,f.alb_id from cmd_fotos f inner join cmd_album a on f.alb_id = a.alb_id where fot_activo = 1 and a.alb_activo = 1 order by fot_id desc";
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
$totalRows_mos_portada = mysql_num_rows($mos_portada); 

  $query_mos_album = "SELECT * FROM cmd_album  WHERE alb_activo =  1";
  $mos_album = mysql_query($query_mos_album, $conexion) or die(mysql_error());
  $row_mos_album = mysql_fetch_assoc($mos_album);
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
                                <li class="current dropdown"><a href="galeria.php"><?php echo $row_mos_url['url_galeria']; ?></a></li>
                                <li><a href="videos.php"><?php echo $row_mos_url['url_video']; ?></a>
                                
                                </li>
                                 <li><a href="partners.php"><?php echo $row_mos_url['url_paquetes']; ?></a></li>
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
        	<h1><?php echo $row_mos_url['url_galeria']; ?></h1>
            <ul class="bread-crumb"><li><a href="index.html"><?php echo $row_mos_url['url_inicio']; ?></a></li> <li><?php echo $row_mos_url['url_galeria']; ?></li></ul>
        </div>
    </section>
    
    <section class="our-projects with-margin">
    	<!--About Upper-->
        <div class="about-upper">
        	<div class="auto-container">

            <ul class="filter-tabs clearfix anim-3-all">
                <li class="filter" data-role="button" data-filter="all"><span class="btn-txt">Todos</span></li>
                <?php do { ?>      
                <li class="filter" data-role="button" data-filter="<?php echo $row_mos_album['alb_id'];?>">
                    <span class="btn-txt"><?php 
                        if($_SESSION["idioma"] == 'es')
                            echo $row_mos_album['alb_titulo'];
                        elseif ($_SESSION["idioma"] == 'en')
                            echo $row_mos_album['alb_tit_ingles'];
                        else
                            echo $row_mos_album['alb_tit_aleman'];
                        ?></span>
                </li>
                 <?php } while ($row_mos_album = mysql_fetch_assoc($mos_album)); ?> 
            </ul>
      

            <div class="projects-container filter-list clearfix wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
            <?php do { ?>  
            <article class="project-box mix mix_all <?php echo $row_mos_portada['alb_id'];?>">
            	<figure class="image"><img src="images/resource/galeri/<?php echo $row_mos_portada['fot_nombre'];?>" alt=""><a href="images/resource/galeri/<?php echo $row_mos_portada['fot_nombre'];?>" class="lightbox-image zoom-icon"></a></figure>
               <!-- <div class="text-content">
                    <div class="text">
                        <figure> <img src="images/logo-3.png"> </figure>
                </div>
                -->
            </article>
            <?php } while ($row_mos_portada = mysql_fetch_assoc($mos_portada)); ?> 
        </div>
            
        
    </section>
<?php include 'footer.php'; ?>