<?php include 'header.php'; ?>
<?php 
require_once('Zebra_pagination.php');

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
    }
///

mysql_select_db($database_conexion, $conexion);
$query_mos_portada = "select * from cmd_fotos where fot_activo = 1 order by fot_id desc";
$mos_portada = mysql_query($query_mos_portada, $conexion) or die(mysql_error());
$row_mos_portada = mysql_fetch_assoc($mos_portada);
$totalRows_mos_portada = mysql_num_rows($mos_portada); 

mysql_select_db($database_conexion, $conexion);

$query_mos_noticias = "SELECT * FROM ".$tabla." where not_activo=1 order by not_id desc LIMIT 5";

$mos_noticias = mysql_query($query_mos_noticias, $conexion) or die(mysql_error());

$row_mos_noticias = mysql_fetch_assoc($mos_noticias);

$totalRows_mos_noticias = mysql_num_rows($mos_noticias);

////

//paginacion

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
                                <li class="dropdown"><a href="nosotros.php"><?php echo $row_mos_url['url_nosotros']; ?></a>
                                </li>
                                <li class="dropdown"><a href="servicios.php"><?php echo $row_mos_url['url_servicios']; ?></a>
                                </li>
                                <li class="dropdown"><a href="galeria.php"><?php echo $row_mos_url['url_galeria']; ?></a></li>
                                <li><a href="videos.php"><?php echo $row_mos_url['url_video']; ?></a>
                                
                                </li>
                                 <li class="dropdown current"> <a href="paquetes.php"><?php echo $row_mos_url['url_paquetes']; ?></a></li>
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
                
              
                
                <!--Tabs Content-->
                <div class="tab-content wow fadeInUp" data-wow-delay="300ms" data-wow-duration="1000ms">
                    
                    <!--Tab / Active Tab-->
                    <div class="tab active-tab clearfix" id="architecture-tab">
                        
                        <!--Posts Container-->
                        <div class="posts-container clearfix">
                            
                            <!--Post-->
                            <?php if ($totalRows_mos_noticia !== 0) { 
                            do { ?> 
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/<?php echo $row_mos_noticia['not_imagen'];?>" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3><a href="detalle.php?id=<?php echo $row_mos_noticia['not_id'];?>"><?php echo $row_mos_noticia['not_titulo'];?></a></h3>
                                            <div class="text">
                                                <?php 

                      $nota = $row_mos_noticia['not_nota'];

                      if(strlen($nota) > 350)

                        {

                        $texto = substr($nota,0,500)." ... "; 

                          echo $texto; 

                        }

                        else

                        {

                          echo $nota;

                        }?>
                                            </div>
                                            <div class="link">
                                            <a href="detalle.php?id=<?php echo $row_mos_noticia['not_id'];?>" class="read_more"><?php echo $row_mos_url['url_leer']; ?></span> </a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->

                            <?php } while ($row_mos_noticia = mysql_fetch_assoc($mos_noticia)); ?>
            <?php 
                $paginacion->render(); ?>                  
            <?php
          }
          else
          {
            echo '<br>';
            echo '<div class="alert alert-info alert-dismissable">
                    <i class="fa fa-info"></i>
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
             <b>Alerta !</b> Ningun Post disponible !! </div>';
          }
        ?>
                          
                        </div><!--Posts Container End-->
                    </div><!--Tab End-->
                    
                    <!--Tab-->
                    <div class="tab clearfix" id="renovation-tab">
                        <!--Posts Container-->
                        <div class="posts-container clearfix">
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-1.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Renovation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-2.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Renovation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-3.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Renovation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-1.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Renovation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-2.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Renovation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-3.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Renovation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                        </div><!--Posts Container End-->
                        
                    </div><!--Tab End-->
                    
                  
                    
                    <!--Tab-->
                    <div class="tab clearfix" id="isolation-tab">
                        <!--Posts Container-->
                        <div class="posts-container clearfix">
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-1.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Isolation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-2.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Isolation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-3.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Isolation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-1.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Isolation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-2.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Isolation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-3.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Isolation</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                        </div><!--Posts Container End-->
                        
                    </div><!--Tab End-->
                    
                    <!--Tab-->
                    <div class="tab clearfix" id="sanitary-tab">
                        <!--Posts Container-->
                        <div class="posts-container clearfix">
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-1.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Sanitary</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-2.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Sanitary</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-3.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Sanitary</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-1.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Sanitary</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-2.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Sanitary</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                            <!--Post-->
                            <article class="col-md-4 col-sm-6 col-xs-12 featured-box">
                                <div class="box-inner">
                        
                                    <figure class="image">
                                        <img class="img-responsive" src="images/resource/post-image-3.jpg" alt="" />
                                        <span class="curve"></span>
                                    </figure>
                                    <div class="content">
                                        <div class="inner-box">
                                            <h3>Sanitary</h3>
                                            <div class="text">There are many variations of passages of Lorem Ipsum available . . . . . .</div>
                                            <div class="link"><a href="#" class="read_more">Read More</a></div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </article><!--Post End-->
                            
                        </div><!--Posts Container End-->
                        
                    </div><!--Tab End-->
                    
                </div>
                
            </div>
        </div>
    </section>
    
    
<?php include 'footer.php'; ?>