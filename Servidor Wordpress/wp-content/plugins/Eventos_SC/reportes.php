<?php 
/*
	Módulo de reportes 
	* 
	* Arre glar CSS para mostrar en imagen completa
*/
?>
<style type="text/css"><?php include'reportes.css'; ?></style>


<h1>Reportes</h1>


<input id="tab1" type="radio" name="tabs" checked>
<label for="tab1">Calendario de eventos</label>
    
<input id="tab2" type="radio" name="tabs">
<label for="tab2">Evaluación del desempeño</label>
   
<input id="tab3" type="radio" name="tabs">
<label for="tab3">Estadisticas</label>

<input id="tab4" type="radio" name="tabs">
<label for="tab4">Incidencias de la Cartelera</label>


<section id="content1">
	<iframe style="width: 100%; height: 900px; border: none; " src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/calendario.php"></iframe>
</section>

<section id="content2">
	<iframe style="width: 100%; height: 900px; border: none; " src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/carteles.php"></iframe>
</section>

<section id="content3">
    <iframe style="width: 100%; height: 900px; border: none; " src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/estadisticas.php"></iframe>
</section>

<section id="content4">
	<iframe style="width: 100%; height: 900px; border: none; " src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/eventos/administracion_eventos/cartelera.php"></iframe>
</section>
