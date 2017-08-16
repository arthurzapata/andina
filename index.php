<?php include 'header.php'; ?>
<?php 
mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "select * from cmd_portada where por_estado = 1 and por_idioma='".$_SESSION["idioma"]."' order by por_id desc";
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
$totalRows_mos_portada = mysql_num_rows($mos_portada); 

$query_mos_inicio = "select ini_inicio,ini_imagen from cmd_inicio where ini_idioma='".$_SESSION["idioma"]."'";
$mos_inicio = mysql_query($query_mos_inicio, $conexion) or die(mysql_error());
$row_mos_inicio = mysql_fetch_assoc($mos_inicio);
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
                                <li class="current dropdown"><a href="index.php"><?php echo $row_mos_url['url_inicio']; ?></a></li>
                                <li class="dropdown"><a href="empresa.php"><?php echo $row_mos_url['url_nosotros']; ?></a></li>
                                <li class="dropdown"><a href="lineas.php"><?php echo $row_mos_url['url_servicios']; ?></a></li>
                                <li><a href="galeria.php"><?php echo $row_mos_url['url_galeria']; ?></a></li>
                                
                                <li><a href="videos.php"><?php echo $row_mos_url['url_video']; ?></a></li>
                                <li><a href="partners.php"><?php echo $row_mos_url['url_paquetes']; ?></a></li>
                                <!--<li><a href="partners.php"><?php echo $row_mos_url['url_contacto']; ?></a></li>-->
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
    <!-- Main Slider -->
    <section class="main-slider">
    	
        <div class="tp-banner-container">
            <div class="tp-banner" >
                <ul>
                <?php do { ?>  
                    <li data-transition="fade" data-slotamount="1" data-masterspeed="1000" data-thumb="images/main-slider/<?php echo $row_mos_portada['por_imagen'];?>"  data-saveperformance="off"  data-title="We are Awsome"> <!-- MAIN IMAGE --> 
                    <img src="images/main-slider/<?php echo $row_mos_portada['por_imagen'];?>"  alt=""  data-bgposition="center top" data-bgfit="cover" data-bgrepeat="no-repeat"> 
                    
                    <div class="tp-caption lfb tp-resizeme"
                    data-x="left" data-hoffset="15"
                    data-y="center" data-voffset="-60"
                    data-speed="1500"
                    data-start="500"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn"
                    style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;">
                        <div class="big-title">
                           <!-- <h2>WE <br>MAKE IT <br>HAPPEN</h2>-->
                        </div>
                    </div>
                    
                    <div class="tp-caption lfb tp-resizeme"
                    data-x="left" data-hoffset="15"
                    data-y="center" data-voffset="100"
                    data-speed="1500"
                    data-start="1000"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn"
                    style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;">
                        <div class="slide-text">
                        <!--<p>Lorem Ipsum is simply dummy text of the printing <br>and typesetting industry</p>-->
                        </div>
                    </div>
                    
                    <div class="tp-caption lfb tp-resizeme"
                    data-x="left" data-hoffset="15"
                    data-y="center" data-voffset="170"
                    data-speed="1500"
                    data-start="1500"
                    data-easing="easeOutExpo"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.3"
                    data-endspeed="1200"
                    data-endeasing="Power4.easeIn"
                    style="z-index: 4; max-width: auto; max-height: auto; white-space: nowrap;">
                        <div class="link-btn">
                        <a class="primary-btn hvr-bounce-to-left" href="paquetes.php">
                            <span class="btn-text "><?php echo $row_mos_url['url_leer']; ?></span> 
                            <strong class="icon"><span class="f-icon flaticon-right11"></span></strong>
                        </a>
                        </div>
                    </div>
                    
                    
                    </li>
                    <?php } while ($row_mos_portada = mysql_fetch_assoc($mos_portada)); ?> 
                </ul>
                
            	<div class="tp-bannertimer"></div>
            </div>
        </div>
    </section>
    
    <!--Facts Counter Style Two-->
   
    
    <!--Featured Services-->
   
    
    
    <!--Services Area-->
  
    
    <!--We Are Best-->
    <section class="we-are-best">
    	<div class="auto-container">
        	<div class="row clearfix">
            	
                <div class="col-md-6 col-sm-6 col-xs-12 image-side">
                	<figure class="image">
                        <img class="img-responsive" src="images/main-slider/<?php echo $row_mos_inicio['ini_imagen'];?>" alt="" title="">
                    </figure>
                </div>
                
                <div class="col-md-6 col-sm-6 col-xs-12 text-side">
                	<h2 class="wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1000ms"><?php echo $row_mos_url['url_bienv']; ?></h2>
                    <div class="text wow fadeInRight" data-wow-delay="300ms" data-wow-duration="1000ms">
                    	<p><?php echo $row_mos_inicio['ini_inicio'];?>
</p>
                    </div>
                    <div class="link-btn wow fadeInRight" data-wow-delay="600ms" data-wow-duration="1000ms"><a class="primary-btn light hvr-bounce-to-left" href="contacto.php"><span class="btn-text"><?php echo $row_mos_url['url_contacto']; ?></span> <strong class="icon"><span class="f-icon flaticon-new100"></span></strong></a></div>
                </div>
                
            </div>
        </div>
    </section>
<?php include 'footer.php'; ?>