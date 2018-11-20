<?php  
/* 
* Calendario
* 
* @category Calendario
* @author Centro de Información Cultural del Estado de Hidalgo SC <cic.innovacion@gmail.com>
* @copyleft Algunos derechos reservados Centro de Información Cultural del Estado de Hidalgo SC
* @since Versión 1.0, revisión 1. Noviembre/2017
* @versión 1.0 
*/
require('../../../../../wp-load.php');
wp_head(); 
?>

<!DOCTYPE HTML>
<html>
<head>
	<title>Calendario</title>
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




  #calendar {
    max-width: 900px;
    margin: 0 auto;
  }
/*muestra todo el texto de los title en el calendario*/
 .fc-month-view span.fc-title{
         white-space: normal;
   }
.fc-event {
    top: 10px;
    background: transparent;
    border: 0px solid #3a87ad;
    color: #000;
}
.fc-event-icons {
    float: left;
    margin-right: 5px;
}
.fc-event-inner {
    width: 20px;
}

.circle {
    border-radius: 50%;
    float: left;
    display: inline-block;
    margin-right: 20px;
    /* text styling */
    font-size: 12px;
    width: 55px;
    height: 55px;
    color: #FFF;  border: 2px solid #fff;
    line-height: 55px;
    text-align: center;
    font-family: Arial;
}
.color-1 { background: #71B631;}
.color-2 { background: #ffbb3f; }
.color-3 { background: #E73C4E; }
.color1-box-shadow { box-shadow: 0px 0px 1px 1px #AEA79F }
.color2-box-shadow { box-shadow: 0px 0px 1px 1px #AEA79F }
.color3-box-shadow { box-shadow: 0px 0px 1px 1px #AEA79F }
.text { line-height: 45px; padding-top: 50px; height: 200px }
</style>

<script type="text/javascript" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/highcharts/highcharts.js"></script>
<script type="text/javascript" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/highcharts/highcharts-more.js"></script>
<script type="text/javascript" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/highcharts/highcharts-3d.js"></script>
<script type="text/javascript" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/js/highcharts/exporting.js"></script>

<link href='fullcalendar/fullcalendar.min.css' rel='stylesheet'/>
<link href='fullcalendar/fullcalendar.print.min.css' rel='stylesheet' media='print'/>
<script src='fullcalendar/lib/moment.min.js'></script>
<script src='fullcalendar/lib/jquery.min.js'></script>
<script src='fullcalendar/fullcalendar.min.js'></script>
<script src='fullcalendar/locale/es.js'></script>
</head>
<body>
<h1>Calendario de eventos</h1>
<div id="filro"  align="center">	
	<label>Fecha de inicio <input type="date" id="fInicio"></label>
	<label>Fecha de fin <input type="date" id="fFin"></label>
	<input type="button" value="Filtrar" onClick="getCalendario();">
</div>
<br>

<div class="circle color-1 color1-box-shadow">
    Publicado
</div>
<div class="circle color-2 color2-box-shadow">
    Pendiente
</div>
<div class="circle color-3 color3-box-shadow">
    Borrador
</div>


<br>
<div id='calendar'></div>
<br><br>
<div id="resultado"></div>

</body>
<footer>




	
<script>
	/*
var calendarData = [];
  $(document).ready(function() {
    $.ajax({
        url:   'ajax/ajax_getCalendarioFull.php',
        type:"POST",
        dataType:"json",
        success:  function (data) {
          calendarData=data;
          printCalendar();
        }
    });    


    function printCalendar () {
      $('#calendar').fullCalendar({
      header: {

        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      defaultDate: moment(),
      lang:'es',
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: true, // allow "more" link when too many events
      events: calendarData,
      eventClick: function(calEvent, jsEvent, view) {
        window.open(calEvent.link);
      }
      });
    }

  });
*/
</script>




	
<script type="text/javascript">
function getCalendario () {
	var fInicio = jQuery("#fInicio").val();
	var fFin = jQuery("#fFin").val();
	
	if(fInicio !='' && fFin != ''){
			var parametros = {
			"fInicio" : fInicio,
			"fFin" : fFin
	};
	
	///////////////////////////////////
	
	    $.ajax({
        url:   'ajax/getCalendarioFull.php',
        data: parametros,
        type:"POST",
        dataType:"json",
        beforeSend: function () {
			jQuery("#calendar").html("<div class='msj_error'>Procesando, espere por favor...</div>");
	    },
        success:  function (data) {
          jQuery('#calendar').html(data).fadeIn();
          calendarData=data;
          printCalendar();
        }
    });    


    function printCalendar () {
      $('#calendar').fullCalendar({
      header: {

        left: 'prev,next today',
        center: 'title',
        right: 'month,agendaWeek,agendaDay,listWeek'
      },
      defaultDate: moment(),
      lang:'es',
      timeFormat: 'h:mm a',
      navLinks: true, // can click day/week names to navigate views
      editable: false,
      eventLimit: false, // allow "more" link when too many events
      events: calendarData,
      eventClick: function(calEvent, jsEvent, view) {
         $(this).css('border-color', 'black');
        window.open(calEvent.link);
      }
      });
    }
    
    ///////////////////////////////////
	jQuery.ajax({
	        type: "POST",
	        url: "ajax/getCalendario.php",
	        data: parametros,
	        beforeSend: function () {
	            jQuery("#resultado").html("<div class='msj_error'>Procesando, espere por favor...</div>");
	    	},
	        success: function(response){
	            jQuery('#resultado').html(response).fadeIn();
	        }
	});
	}else{
		alert('Necesitas escoger las fechas.');	
		}
}

</script>
</footer>
</html>
