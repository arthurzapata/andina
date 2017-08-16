<?php include 'header.php'; ?>
<?php 
///
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
///
mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "select * from cmd_fotos where fot_activo = 1 order by fot_id desc";
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
$totalRows_mos_portada = mysql_num_rows($mos_portada); 

if (isset($_GET['id']))
{
    $id =$_GET['id'];

    mysql_select_db($database_conexion, $conexion);
    $query_mos_noticia = "select not_id,not_titulo,not_nota,not_imagen,not_precio,
  case when not_tipovideo = 1 then right(not_video,11) when not_tipovideo = 2 then right(not_video,9) else 0 end as not_video,
  not_tipovideo, not_moneda from ".$tabla." where not_id=".$id." and not_activo=1";
    $mos_noticia = mysql_query($query_mos_noticia, $conexion) or die(mysql_error());
    $row_mos_noticia = mysql_fetch_assoc($mos_noticia);
    $total_noticias = mysql_num_rows($mos_noticia);

    $query_mos_imagenes = "SELECT * FROM cmd_imagen where not_id = ".$id."";
    $mos_imagenes = mysql_query($query_mos_imagenes, $conexion) or die(mysql_error());
    $row_mos_imagenes = mysql_fetch_assoc($mos_imagenes);
    $totalRows_mos_imagenes = mysql_num_rows($mos_imagenes);
}

if ((isset($_POST["desde"]))) {
////enviar correo al cliente
//$url = $row_mos_config['con_url'];
$correo = $row_mos_config['con_email'];

require('class.phpmailer.php');
///CLIENTE
$mail = new PHPMailer();
$mail->Host = "localhost";
$mail->From = $row_mos_config['con_email']; // de la empresa
$mail->FromName = $row_mos_config['con_nombrewebsite']; 
$mail->Subject = "Solicitud de Cotizaciòn";
$mail->AddAddress($correo);  //'informes@lacade.com'; correo empresa
//$mail->AddAddress($row_mos_config['con_email']);
$content="<table class='bod'>
<tr> 
    <td>
   Solicitar Cotizaciòn !!
    </td>
</tr>
  <tr> 
    <td>
        Nombres y Apellidos : ".$_POST["name"]."  
    </td>
  </tr>
  
  <tr> 
    <td>
        Email : ".$_POST["email"]." -  Telefono:" .$_POST["url"]. "
  </td>
  </tr>
  <tr> 
    <td>
       Comentario : ".$_POST["comentario"]." 
  </td>
  </tr>
  <tr>
      <td align='center'>
      -- ".$row_mos_config['con_nombrewebsite']." --
      </td>
  </tr>
</table>";
      $mail->MsgHTML($content);
      if(!$mail->Send()) {
      } else {
      }
    
}

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
                                <li class="dropdown  current"><a href="lineas.php"><?php echo $row_mos_url['url_servicios']; ?></a>
                                </li>
                                <li class="dropdown"><a href="galeria.php"><?php echo $row_mos_url['url_galeria']; ?></a></li>
                                <li><a href="videos.php"><?php echo $row_mos_url['url_video']; ?></a>
                                
                                </li>
                                 <li class="dropdown"> <a href="partners.php"><?php echo $row_mos_url['url_paquetes']; ?></a></li>
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
    
    <section class="project-details">
        <div class="auto-container">
            
            <div class="proj-title wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
                <h2><?php echo $row_mos_noticia['not_titulo'];?>  </h2>
            </div>
            
            <div class="row clearfix">
                
                <!--Column-->
                <div class="column col-md-8 col-sm-6 col-xs-12">
                    
                    <!--Post-->
                    <article class="post detail-content wow fadeIn" data-wow-delay="0ms" data-wow-duration="1000ms">
                        <div class="post-inner">
                        
                            <figure class="image">
                                <img class="img-responsive" src="images/resource/<?php echo $row_mos_noticia['not_imagen'];?>" alt="" />
                                <span class="curve"></span>
                            </figure>
                            <div class="content">
                                <div class="inner-box">
                                    
                                    <!--Project Slider-->
                                    <div class="project-slider">
                                        <ul class="slider">
                                            <li><a class="lightbox-image" href="images/resource/<?php echo $row_mos_noticia['not_imagen'];?>">
                                                <img src="images/resource/<?php echo $row_mos_noticia['not_imagen'];?>" alt=""></a>
                                            </li>
                                         <?php if ($totalRows_mos_imagenes !== 0) { ?>
                                         <?php do { ?>
                                            <li><a class="lightbox-image" href="images/resource/<?php echo $row_mos_imagenes['img_nombre'];?>">
                                                <img src="images/resource/<?php echo $row_mos_imagenes['img_nombre'];?>" alt=""></a>
                                            </li>
                                        <?php } while ($row_mos_imagenes = mysql_fetch_assoc($mos_imagenes)); ?>
                                           <!-- <li><a class="lightbox-image" href="images/resource/news-image-2.jpg"><img src="images/resource/slider-thumb-2.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/proj-image-2.jpg"><img src="images/resource/slider-thumb-3.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/post-image-2.jpg"><img src="images/resource/slider-thumb-4.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/proj-image-1.jpg"><img src="images/resource/slider-thumb-5.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/proj-image-3.jpg"><img src="images/resource/slider-thumb-6.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/news-image-1.jpg"><img src="images/resource/slider-thumb-1.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/news-image-2.jpg"><img src="images/resource/slider-thumb-2.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/proj-image-2.jpg"><img src="images/resource/slider-thumb-3.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/post-image-2.jpg"><img src="images/resource/slider-thumb-4.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/proj-image-1.jpg"><img src="images/resource/slider-thumb-5.jpg" alt=""></a></li>
                                            <li><a class="lightbox-image" href="images/resource/proj-image-3.jpg"><img src="images/resource/slider-thumb-6.jpg" alt=""></a></li>-->
                                        </ul>
                                        <?php }?>  
                                    </div>
                                    
                                    <!--<h3>Renovation</h3>-->
                                    <div class="text">
                                        <p> <?php echo $row_mos_noticia['not_nota'];?>            
                                        </p>
                                        <!--<p>essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software.</p>-->
                                    </div>
                                   <!-- <br>
                                    <h3>Project Info</h3>
                                    <div class="project-info">
                                        <ul class="clearfix">
                                            <li><strong>Client:</strong> Bodna Company</li>
                                            <li><strong>Date :</strong> 11/05/14</li>
                                            <li><strong>Location:</strong> Dhanmondi 27, Block c</li>
                                            <li><strong>Surface Area:</strong> 580,000 m2</li>
                                            <li><strong>Value:</strong> $250.000</li>
                                            <li><strong>Architect:</strong> Rashed &amp; Muhibur</li>
                                        </ul>
                                    </div>-->
                                </div>
                            </div>
                        </div>
                    </article>
                    
                </div>
                
                <!--Column-->
                <div class="column col-md-4 col-sm-6 col-xs-12">
                    <!--Post-->
                    <article class="post wow fadeInUp" data-wow-delay="0ms" data-wow-duration="1000ms">
                        <div class="post-inner">
                        
                           <figure class="image">
                                <img class="img-responsive" src="images/loguito.jpg" alt="" />
                                <span class="curve"></span>
                            </figure>
                            <div class="content">
                                <div class="inner-box">
                                    <h3><?php echo $row_mos_noticia['not_titulo'];?></h3>
                                    <div class="text">
                                        <?php  if ($row_mos_noticia['not_tipovideo'] = 1) {?>
                                      
                            <iframe width="100%"  src="https://www.youtube.com/embed/<?php echo $row_mos_noticia['not_video'];?>" frameborder="0"></iframe> 
                                    <?php } else { ?>
                                        <iframe width="100%"  src="https://player.vimeo.com/video/<?php echo $row_mos_noticia['not_video'];?>" width="640" height="360" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
                                        <?php } ?>
                                    </div>
                                    <div class="social">
                                    <h3><?php echo $row_mos_url['url_compartir']; ?></h3>
                                    <!--<a href="#" class="fa fa-facebook-f"></a> &ensp; <a href="#" class="fa fa-twitter"></a> &ensp; <a href="#" class="fa fa-google-plus"></a> &ensp; <a href="#" class="fa fa-linkedin"></a>-->
                                    </div>



                                        <div class="addthis_toolbox addthis_default_style addthis_32x32_style"  align="right">

                                            <a class="addthis_button_preferred_1"></a>

                                            <a class="addthis_button_preferred_2"></a>

                                            <a class="addthis_button_preferred_3"></a>

                                            <a class="addthis_button_preferred_4"></a>

                                            <a class="addthis_button_compact"></a>

                                            <a class="addthis_counter addthis_bubble_style"></a>

                                        </div>

                                        <script type="text/javascript">var addthis_config = {"data_track_addressbar":true};</script>

                                        <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-516c38cf570558e6">
                                            
                                        </script>


                                </div>

                            </div>
                            
                        </div>
                    </article>
                    
                    <!--Goal-->
                    <article class="post goal wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
                        <div class="post-inner">
                              <!--   <h3></h3>
                                  <iframe width="100%"  src="https://www.youtube.com/embed/sOnqjkJTMaA" frameborder="0" allowfullscreen="allowfullscreen"></iframe>            
                              <br>
                                <iframe src="https://player.vimeo.com/video/204776636" width="640" height="360" frameborder="0" webkitallowfullscreen="" mozallowfullscreen="" allowfullscreen=""></iframe>
                                <p>
                                  <a href="https://vimeo.com/204776636">Nachthexen</a> from <a href="https://vimeo.com/theanimationworkshop">The Animation Workshop</a> on <a href="https://vimeo.com">Vimeo</a>.
                                </p>
                            
                            <h3><?php echo $row_mos_url['url_precio']; ?></h3>
                
                            <a class="primary-btn hvr-bounce-to-left">
                            <span class="btn-text" style="font-size:24px;"><?php echo $row_mos_noticia['not_moneda'];?>  <?php echo $row_mos_noticia['not_precio'];?></span> <strong class="icon">
                            <span class="f-icon flaticon-textfile5"></span></strong></a>
-->
                             <br>
                            <h3><?php echo $row_mos_url['url_reservas']; ?></h3>
                            <div class="row form">
                                <div class="col-sm-12">
                                    <form class="comment-area" method="post">
                                     
                                     
                                      <!--  <div class="form-group"><?php echo $row_mos_url['url_desde']; ?>
                                        <input type="date" class="form-control" name="desde" placeholder="dd-mm-yyyy" required>
                                        </div>
                                     
                                     
                                        <div class="form-group"><?php echo $row_mos_url['url_hasta']; ?>
                                        <input type="date" class="form-control" name="hasta" placeholder="dd-mm-yyyy" required>
                                        </div>
                                     -->
                                    <div class="form-group"><?php echo $row_mos_url['url_usuario']; ?>
                                        <input type="text" class="form-control" name="name" placeholder="<?php echo $row_mos_url['url_usuario']; ?>" required>
                                    </div>

                                      
                                    <div class="form-group"><?php echo $row_mos_url['url_email']; ?>
                                        <input type="email" class="form-control" name="email" placeholder="<?php echo $row_mos_url['url_email']; ?>" required>
                                    </div>
                                    <div class="form-group"><?php echo $row_mos_url['url_telefono']; ?>
                                        <input type="text" class="form-control" name="url" placeholder="<?php echo $row_mos_url['url_telefono']; ?>" required>
                                    </div>
                                    <div class="form-group"><?php echo $row_mos_url['url_cantidad']; ?>
                                    <!-- <input type="number" name="quantity" min="1" max="6" value="1" class="form-control" required>-->
                                       <textarea class="form-control" name="comentario" placeholder=""></textarea>
                                    </div>
                                    <div class="">
                                        <button class="full-btn block"><?php echo $row_mos_url['url_reservas']; ?></button>
                                    </div>
                                    </form>
                                </div>
                            </div>
                         </div>
     
                        </article>
                   <!-- </div>-->



                </div>
                
            </div>
        </div>
    </section>
    
<?php include 'footer.php'; ?>