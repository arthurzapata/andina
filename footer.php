<?php
mysql_select_db($database_conexion, $conexion);
$query_mos_nosotros = "SELECT nos_somos FROM cmd_nosotros WHERE nos_idioma = '".$_SESSION["idioma"]."'";
$mos_nosotros = mysql_query($query_mos_nosotros, $conexion) or die(mysql_error());
$row_mos_nosotros = mysql_fetch_assoc($mos_nosotros);


$query_mos_inicios = "select ini_bienvenida from cmd_inicio where ini_idioma='".$_SESSION["idioma"]."'";
$mos_inicios = mysql_query($query_mos_inicios, $conexion) or die(mysql_error());
$row_mos_inicios= mysql_fetch_assoc($mos_inicios);

$query_mos_img = "select f.fot_id,f.fot_nombre,f.fot_activo,f.alb_id from cmd_fotos f inner join cmd_album a on f.alb_id = a.alb_id 
where fot_activo = 1 and a.alb_activo = 1 limit 9";
$mos_img = mysql_query($query_mos_img, $conexion) or die(mysql_error());
$row_mos_img = mysql_fetch_assoc($mos_img);

//$query_mos_ser = "select * from cmd_servicios where ser_activo = 1 and ser_idioma='".$_SESSION["idioma"]."' limit 6";
$idioma = $_SESSION['idioma'];
  switch ($idioma) {
   case 'es':
        $lenguaje = 'Español';
        $tabla = 'cmd_noticia';
        break;
    case 'en':
         $lenguaje = 'Ingles';
         $tabla = 'cmd_noticia_en';
        break;
    case 'de':
         $lenguaje = 'Aleman';
         $tabla = 'cmd_noticia_de';
        break;
         case 'fr':
         $lenguaje = 'Frances';
         $tabla = 'cmd_noticia_fr';
        break;
    case 'it':
         $lenguaje = 'Italiano';
         $tabla = 'cmd_noticia_it';
        break;   
    }
$query_mos_ser = "select * from ".$tabla." where not_activo=1";
$mos_ser = mysql_query($query_mos_ser, $conexion) or die(mysql_error());
$row_mos_ser = mysql_fetch_assoc($mos_ser);
?>
<footer class="main-footer">
        <div class="auto-container">
        	
            <!--Subscribe Area-->
            <div class="subscribe-area">
            	<div align="center">
                <h2><?php echo $row_mos_inicios['ini_bienvenida']; ?></h2>
                       <!-- <h2>Vive una <span>experiencia unica,</span> no te <span>arrepentiras</span></h2>
                        Form Box-->
                </div>
            </div>
            
            <!--Footer Widget Area-->
            <div class="footer-widget-area clearfix">
            
            	<!--Footer Widget-->
                <article class="footer-widget about-widget col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1000ms">
                	<h3><img src="images/footer-text-logo.png" alt=""></h3>
                    <div class="widget-content">
                    	<p><?php echo $row_mos_nosotros['nos_somos'];?></p>
                    </div>
                </article>
                
                <!--Footer Widget-->
                <article class="footer-widget quick-links col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
                	<h3><?php echo $row_mos_url['url_servicios']; ?></h3>
                    <div class="widget-content">
                    	<ul>
                        <?php do { ?>  
                            <li><span class="fa fa-angle-right"></span> 
                                <a href="lineas.php"><?php echo $row_mos_ser['not_titulo']; ?></a>
                            </li>
                        <?php } while ($row_mos_ser = mysql_fetch_assoc($mos_ser)); ?> 
                        </ul>
                    </div>
                </article>
                
                <!--Footer Widget-->
                <article class="footer-widget address col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="600ms" data-wow-duration="1000ms">
                	<h3><?php echo $row_mos_url['url_contacto']; ?></h3>
                    <div class="widget-content">
                    	<ul class="info">
                        	<li><span class="fa fa-map-marker"></span>&ensp;<?php echo $row_mos_config['con_direccion'];?></li>
                            <li><span class="fa fa-phone"></span> &ensp;<?php echo $row_mos_config['con_celular'];?>&ensp;, &ensp;<?php echo $row_mos_config['con_telefono'];?></li>
                            <li><span class="fa fa-envelope"></span> &ensp; <a href="mailto:<?php echo $row_mos_config['con_email'];?>"><?php echo $row_mos_config['con_email'];?></a></li>
                            <li><span class="fa fa-envelope"></span> &ensp; <a href="mailto:info@pozuzonuevoturismo.com">info@pozuzonuevoturismo.com</a></li>
                        </ul>
                        
                        <div class="social">
                            <a class="img-circle fa fa-facebook-f" href="<?php echo $row_mos_config['con_facebook'];?>" target="blank_"></a> 
                            <a class="img-circle fa fa-youtube" href="<?php echo $row_mos_config['con_twiter'];?>" target="blank_"></a> 
                            <a class="img-circle fa fa-google-plus" href="<?php echo $row_mos_config['con_google'];?>" target="blank_"></a> 
                            <a class="img-circle fa fa-linkedin" href="<?php echo $row_mos_config['con_instagram'];?>" target="blank_"></a>
                        </div>
                    </div>
                </article>
                
                <!--Footer Widget-->
                <article class="footer-widget latest-work col-md-3 col-sm-6 col-xs-12 wow fadeInUp" data-wow-delay="900ms" data-wow-duration="1000ms">
                	<h3><?php echo $row_mos_url['url_galeria']; ?></h3>
                    <div class="widget-content">
                    	<div class="clearfix">
                        	<?php do { ?>  
                            <figure class="image">
                                <a class="lightbox-image" href="images/resource/galeri/<?php echo $row_mos_img['fot_nombre'];?>">
                                        <img src="images/resource/galeri/<?php echo $row_mos_img['fot_nombre'];?>" alt=""></a>
                            </figure>
                             <?php } while ($row_mos_img = mysql_fetch_assoc($mos_img)); ?> 
                        </div>
                    </div>
                </article>
                
            </div>
        </div>
        
        <!--Footer Bottom-->
        <div class="footer-bottom">
        	<div class="auto-container text-center">Desarrollado por <a href="http://www.lheowebglobal.com/">LHEOWEB</a></div>
        </div>
        
	</footer><!--Main Footer End-->		
    
</div>
<!--End pagewrapper-->
<script src="js/jquery.js"></script> 
<script src="js/bootstrap.min.js"></script>
<script src="js/revolution.min.js"></script>
<script src="js/bxslider.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.mixitup.min.js"></script>
<script src="js/jquery.fancybox.pack.js"></script>
<script src="js/wow.js"></script>
<script src="js/script.js"></script>
</body>
</html>
