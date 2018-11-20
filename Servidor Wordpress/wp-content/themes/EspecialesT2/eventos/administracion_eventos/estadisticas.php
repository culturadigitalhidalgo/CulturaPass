<?php  
/* 
* Estadisticas
* 
* @category Estadisticas
* @author Centro de Información Cultural del Estado de Hidalgo CECULTAH <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Junio/2017
* @versión 1.0 
*/
require('../../../../../wp-load.php');
wp_head(); 
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Estadisticas</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href="favicon.png" rel="icon" type="image/png"/>	

<style type="text/css">
body{width:100%; margin: 0 auto;
font-family:"Lucida Grande", "Lucida Sans Unicode", "Lucida Sans", "DejaVu Sans", Verdana, sans-serif;
font-size:1em; line-height:1.2em;}
h1, h2, h3{font-weight:bold;}
h1{margin-top:30px;font-size:2em; text-transform:uppercase;}
h2, h3{font-size:1.4em; line-height:2.5em;}

#resultado div{padding:16px;}
#filtro input{
border: 1px solid #AAA;
  color: #555;
  font-size: inherit;
  overflow: hidden;
  padding: 10px;
  text-overflow: ellipsis;
  white-space: nowrap;
  background:none;
  border:none;
  cursor:pointer;
  font-weight:normal !important;
}
#filtro input[type=button]{}
#filtro input[type=date]{}

.chart{width:100%;margin:0 auto;}
.chart_title{display: block; width: 100%; margin: 0 auto;}
.chart_graphic, .chart_table{display:inline-block; width:45%; float:left;}
.chart_table table{ border-spacing:0;border-collapse: collapse;}
.chart_table th{text-transform:uppercase; padding:16px; background:#002F40; color:#6DBD45}
.chart_table td{padding:16px;}
.chart_table tr:nth-child(even){background:#f2f2f2}

.msj_error{background:#6cbe45; font-weight:bold; letter-spacing:.4em; color:#FFF; padding:16px 0px; text-align: center;}

</style>

<script type="text/javascript" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/highcharts/highcharts.js"></script>
<script type="text/javascript" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/highcharts/highcharts-more.js"></script>
<script type="text/javascript" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/highcharts/highcharts-3d.js"></script>
<script type="text/javascript" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/highcharts/exporting.js"></script>
</head>
<h1>Estadisticas de oferta cultural</h1>
<div id="filro"  align="center">	
	<label>Fecha de inicio <input type="date" id="fInicio"></label>
	<label>Fecha de fin <input type="date" id="fFin"></label>
	<input type="button" value="Filtrar" onClick="getEstadisticas();">
</div>
<div id="resultado"></div>
<body>
</body>
<footer>
<script type="text/javascript">
function getEstadisticas () {
	var fInicio = jQuery("#fInicio").val();
	var fFin = jQuery("#fFin").val();
	var parametros = {
			"fInicio" : fInicio,
			"fFin" : fFin
	};
	
	jQuery.ajax({
	        type: "POST",
	        url: "ajax/getEstadisticas.php",
	        data: parametros,
	        beforeSend: function () {
	            jQuery("#resultado").html("<div class='msj_error'>Procesando, espere por favor...</div>");
	    	},
	        success: function(response){
	            jQuery('#resultado').html(response).fadeIn();
	        }
	});
}

</script>
</footer>
</html>
