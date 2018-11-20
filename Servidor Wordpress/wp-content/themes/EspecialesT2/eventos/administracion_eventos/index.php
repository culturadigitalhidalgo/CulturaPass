<?php  
/* 
* Index
* 
* @category Index
* @author Centro de Información Cultural del Estado de Hidalgo CECULTAH <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Marzo/2017
* @versión 1.0 
*/
wp_head();

$usuario = $_POST['usuario'];
if(!isset($usuario)){
		echo '<script src="/wp-content/themes/EspecialesT2/eventos/administracion_eventos/sweetalert-master/dist/sweetalert.min.js"></script>';
		echo '<link rel="stylesheet" type="text/css" href="/wp-content/themes/EspecialesT2/eventos/administracion_eventos/sweetalert-master/dist/sweetalert.css">';
	    echo '<script languaje="javascript">
		 jQuery(document).ready(function() {
		 swal({
			title: "Es necesario que ingreses a la administración del manejador de contenidos.",
			type: "error",
			timer: 2000,
			showConfirmButton: false,
			},
			function(){
			location.href="http://cultura.hidalgo.gob.mx/cartelera-digital/";
			});
			});                
		</script>';
  
		}else{
			





$user = new WP_User( $usuario );

if ( !empty( $user->roles ) && is_array( $user->roles ) ) {
     foreach ( $user->roles as $role )
        $roles[] = $role;
}
?>

<script type="text/javascript" src="/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/skel.min.js"></script>
<script type="text/javascript" src="/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/init.js"></script>		
<link rel="stylesheet" type="text/css" href="/wp-content/themes/EspecialesT2/eventos/administracion_eventos/css/style.css" media="screen" />
<script type="text/javascript" src="/wp-content/themes/EspecialesT2/eventos/administracion_eventos/fancybox/jquery.fancybox.js?v=2.1.5"></script>
<link rel="stylesheet" type="text/css" href="/wp-content/themes/EspecialesT2/eventos/administracion_eventos/fancybox/jquery.fancybox.css?v=2.1.5" media="screen" />

<script type="text/javascript">
              jQuery(".fancybox").fancybox({
			   helpers : { 
				overlay : {closeClick: false}
			   },
               width : 1000,
               height : 800,
               openEffect  : 'elastic',
   			   closeEffect : 'elastic',
   			   iframe : {
               preload: false
               }
			   });
</script>


<body>
	
<div id="header-wrapper">
<!-- Header -->	
	<div id="header" class="container">
		<div class="home-link">
			<!--<h2 class="site-title">CICLO DE CONFERENCIAS SOBRE ALIMENTACIÓN Y GASTRONOMÍA EN HIDALGO</h2>-->
			<!--<h3 style="float:left; margin-left: 1cm; margin-top: 0.5cm;">Espacios Colectivos Culturales</h3>-->
			<img class="" src="/wp-content/themes/EspecialesT2/eventos/administracion_eventos/images/fondos_claros.png" width="300" height="100">
			<!--<img class="logob" src="images/SEC01.png"/>
			<img class="escudo" src="images/escudo.png"/>-->
		
	<!-- Header -->		

<?php
if (in_array("administrator", $roles)) {
?>
					
			<!-- Nav -->
			<nav id="nav">
				<ul>
					<!--<li><a class="icon fa-file-pdf-o fancybox" data-fancybox-type="iframe" href='/wp-content/themes/EspecialesT2/eventos/administracion_eventos/pdf.php'><span>Reporte PDF</span></a></li>-->
					<!--<li><a class="icon fa-bar-chart-o fancybox4" data-fancybox-type="iframe" href='datatables/encuestas_l.php'><span>Registros</span></a></li>
					<li><a class="icon fa-group fancybox2" data-fancybox-type="iframe" href='datatables/usuarios.php'><span>Usuarios</span></a></li>
					<li><a class="icon fa-user fancybox5" data-fancybox-type="iframe" href='cam_contra.php?usuario=<?php echo $usuario;?>'><span><?php echo $nombre;?></span></a></li>
					<li><a class="icon fa-file-text fancybox4" data-fancybox-type="iframe" href='encuesta/'><span>Encuesta</span></a></li>
					<li><a class="icon fa-print" href="todos_boletos.php" target="_blank"><span>Boletos</span></a></li>-->
					<li><a class="icon fa-share" href="http://cultura.hidalgo.gob.mx/cartelera-digital/"><span>Salir</span></a></li>
				</ul>
			</nav>
		</div>
	</div>
	



	<section class="container">
		<div class="row">
			<div class="4u">
				<!-- Feature -->
				<section>
					<h2 class="subtitulo"><a class="button icon fa-calendar fancybox" data-fancybox-type="iframe" href='/wp-content/themes/EspecialesT2/eventos/administracion_eventos/calendario.php'>Calendario de eventos</a></h2>
				</section>
			</div>
			<div class="4u">
				<!-- Feature -->
				<section>
					<h2 class="subtitulo"><a class="button icon fa-check fancybox" data-fancybox-type="iframe" href='/wp-content/themes/EspecialesT2/eventos/administracion_eventos/carteles.php'>Evaluación del desempeño</a></h2>
					<h2 class="subtitulo"><a class="button icon fa-bar-chart-o fancybox" data-fancybox-type="iframe" href='/wp-content/themes/EspecialesT2/eventos/administracion_eventos/estadisticas.php'>Estadisticas</a></h2>
				</section>
			</div>
			<div class="4u">
				<!-- Feature -->
				<section>
					<h2 class="subtitulo"><a class="button icon fa-thumbs-o-up fancybox" data-fancybox-type="iframe" href='/wp-content/themes/EspecialesT2/eventos/administracion_eventos/cartelera.php'>Incidencias de la Cartelera</a></h2>
				</section>
			</div>
			
		</div>
	</section>		
<?php  
}else if (in_array("editor", $roles)) {
?>					
			<!-- Nav -->
			<nav id="nav">
				<ul>
					<li><a class="icon fa-pencil fancybox" data-fancybox-type="iframe" href='formularioPersona.php'><span>Nuevo Registro</span></a></li>
					<li><a class="icon fa-bar-chart-o fancybox4" data-fancybox-type="iframe" href='datatables/encuestas_l.php'><span>Registros</span></a></li>
					<li><a class="icon fa-user fancybox5" data-fancybox-type="iframe" href='cam_contra.php?usuario=<?php echo $usuario;?>'><span><?php echo $nombre;?></span></a></li>
					<li><a class="icon fa-share" href="http://cultura.hidalgo.gob.mx/cartelera-digital/"><span>Salir</span></a></li>
				</ul>
			</nav>
		</div>
	</div>
<br><br>
	<section class="container">
		<div class="row">
			<div class="4u">
				<!-- Feature -->
				<section>
					<h2 class="subtitulo"><a class="button icon fa-edit fancybox" data-fancybox-type="iframe" href='asistio_web.php'>Carteles</a></h2>
				</section>
			</div>
			<div class="4u">
				<!-- Feature -->
				<section>
					<h2 class="subtitulo"><a class="button icon fa-book fancybox" data-fancybox-type="iframe" href='recupera.php'>Cartelera</a></h2>
				</section>
			</div>
			<div class="4u">
				<!-- Feature -->
				<section>
					<h2 class="subtitulo"><a class="button icon fa-book fancybox" data-fancybox-type="iframe" href='recupera.php'>Estadisticas</a></h2>
					<?php //include_once('donuts.php');?>
					<!--<a class="image"><img src="images/pic01.jpg" alt="" /></a>-->
				</section>
			</div>
		</div>
	</section>	
<?php  
}else if (in_array("otro", $roles)) {
?>					
			<!-- Nav -->
			<nav id="nav">
				<ul>
					<li><a class="icon fa-pencil fancybox" data-fancybox-type="iframe" href='formularioPersona.php'><span>Nuevo Registro</span></a></li>
					<li><a class="icon fa-user fancybox5" data-fancybox-type="iframe" href='cam_contra.php?usuario=<?php echo $usuario;?>'><span><?php echo $nombre;?></span></a></li>
					<li><a class="icon fa-share" href="http://cultura.hidalgo.gob.mx/cartelera-digital/"><span>Salir</span></a></li>
				</ul>
			</nav>
		</div>
	</div>
<br><br>
	<section class="container">
		<div class="row">
			<div class="4u">
				<!-- Feature -->
				<section>
					<h2 class="subtitulo"><a class="button icon fa-edit fancybox" data-fancybox-type="iframe" href='asistio_web.php'>Registrar asistencia al evento</a></h2>
				</section>
			</div>
			<div class="4u">
				<!-- Feature -->
				<section>
					<h2 class="subtitulo"><a class="button icon fa-book fancybox" data-fancybox-type="iframe" href='recupera.php'>Recuperar registro al evento</a></h2>
				</section>
			</div>
			<div class="4u">
				<!-- Feature -->
				<section>
					<?php include_once('donuts.php');?>
					<!--<a class="image"><img src="images/pic01.jpg" alt="" /></a>-->
				</section>
			</div>
		</div>
	</section>	
	
<?php
}
?>

				



					

</body>
<div id="footer" align="center">
	<footer>
		<a href="http://cichidalgo.ddns.net/page/innovacion/" target="_blank"><b>Centro de Información Cultural del Estado de Hidalgo</b></a>
		<br>
		Río de las Avenidas No. 200, Col. Periodistas. Pachuca, Hgo. C.P. 42060
		<br>
		Horario: Lunes a Viernes de 8:30 a 16:00 hrs.
		<br>
		Cualquier duda o comentario sobre el funcionamiento y operación del sistema favor de comunicarse:
		<br>
		Innovación Tecnológica y Sistemas CIC, Secretaría de Cultura (771) 7 78 0538 y (771) 7 78 0921 Ext. 106 cic.innovacion@hidalgo.gob.mx
	</footer>

</div>
<?php
}//isset
?>
</html>
