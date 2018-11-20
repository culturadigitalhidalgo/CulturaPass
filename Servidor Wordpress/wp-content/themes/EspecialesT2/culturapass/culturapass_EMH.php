<?php
require_once ('siscp/DBClass.php');
$consultasloc=new DBClass(); 
$consultasloc->to_query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';");
//
require_once ('siscp/DBClass_thinkcloud.php');
$consultastc=new DBClass_thinkcloud(); 
$consultastc->to_query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';");


?>
    <link href="../wp-content/libccd/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
    <script src="../wp-content/libccd/jquery-confirm.min.js" ></script>
        <script>
        jQuery(document).ready(function(){
            jQuery(function ($) {
                var paginaact="http://cultura.hidalgo.gob.mx/wp-content/libccd/ccdclass.php";
               
                var widthjc="50%";   
                
                var nclicks=0;
                
                $('div.boxevento').click(function(e){
//                    e.preventDefault();
                    
                    nclicks++;
//                    console.log("Previniendo evento: "+nclicks);
                    if(nclicks>1){
//                        console.log("Previniendo evento: "+nclicks);
                        return false;
                    }
                    
                    var width = $(window).width();
                    if(width<=360){
                        widthjc="99%";
                    }else if(width>360 && width<=750){
                        widthjc="70%";
                    }
                    
                    var idevento=$(this).attr('id-evento');
                    var cupo=parseInt($(this).attr('cupo'));
                    var registrado=parseInt($(this).attr('registrado'));
                    var idusuario=$(this).attr('userid');
                    var diaeventoq=$(this).attr('fecha');
                    var horaeventoq=$(this).attr('hora');
                    var diaevento=$(this).attr('fechamostrar');
                    var horaevento=$(this).attr('horamostrar');
                    
                    var nregistrados=0;
                    var infoData = new FormData();
                    infoData.append('obtener_info_tc',"single");
                    infoData.append('campos','count(*) as registrados');
                    infoData.append('tabla','preregistros');
                    infoData.append('where',"idevento="+idevento+" and fechaevento ='"+diaeventoq+"' and horaevento='"+horaeventoq+"'");
                    //Vaciado de la información actual
                    $.each(obtener_info(infoData,true), function(key, value){ 
                        nregistrados=parseInt(this.registrados);
                    });
                    
                    if(nregistrados>=cupo){
                        $.dialog({
                            title: "<b><?php echo utf8_encode('Atención!'); ?></b>",
                            content: '<span style="font-size:20px;"><?php echo utf8_encode('Lo sentimos, ya no contamos con lugares disponibles!<br>'); ?></span><br><span style="font-size:16px;"><?php echo utf8_encode('Sin embargo, sujeto a disponibilidad, puedes presentarte al evento en el lugar y hora señalada con el objetivo de tener acceso si es que uno de los asistentes no se presentó o se desocupa un lugar.'); ?></span>',
                            type: 'red',
                            typeAnimated: true,
                            backgroundDismissAnimation: 'glow',
                            boxWidth: widthjc,
                            useBootstrap: false,
                            buttons: {
                                close: function () {
                                }
                            },
                            onContentReady: function () {                               
                                nclicks=0;
                            }
                        });
                        return false;
                    }
                    if(registrado>0){
                       //$.dialog({
                       //    title: "<b><?php echo utf8_encode('Atención!'); ?></b>",
                       //    content: '<span style="font-size:20px;"><?php echo utf8_encode('Ya estas registrado para este evento.<br>Te esperamos!!!'); ?></span>',
                       //    type: 'green',
                       //    typeAnimated: true,
                       //    backgroundDismissAnimation: 'glow',
                       //    boxWidth: widthjc,
                       //    useBootstrap: false,
                       //    buttons: {
                       //        close: function () {
                       //            
                       //        }
                       //    },
                       //    onContentReady: function () {                               
                       //        nclicks=0;
                       //    }
                       //});                       
                       //return false;
                    }
                    
                    var eventoname="";
                    
                    var infoData = new FormData();
                    infoData.append('obtener_info',"single");
                    infoData.append('campos','post_title');
                    infoData.append('tabla','wp_posts');
                    infoData.append('where',"wp_posts.ID="+idevento+"");
                    //Vaciado de la información actual
                    $.each(obtener_info(infoData,true), function(key, value){ 
                        eventoname=this.post_title;
                    });
                    
                                        
                    $.confirm({
                        title: '<b>Confirmar Pre-Registro</b>',
                        type: 'green',
                        content: '<span style="font-size:20px;"><?php echo utf8_encode('¿'); ?>Desea Registrarse al evento <b style="color:red">"'+eventoname
                                +'"</b> el d<?php echo utf8_encode('í'); ?>a <b style="color:red">'+diaevento+'</b> a las <b style="color:red">'+horaevento+'</b> hrs.?</span>',
                        typeAnimated: true,
                        backgroundDismissAnimation: 'glow',
                        boxWidth: widthjc,
                        useBootstrap: false,
                        escapeKey: 'cancel',
                        buttons: {
                            formSubmit: {
                                text: 'Aceptar',
                                btnClass: 'btn-green',
                                action: function () {
                                    $('#precargadiv').fadeIn('fast');
                                    //formato de la información a enviar por POST con isntrucción SAVE
                                    var formData = new FormData();
                                    formData.append('savepreregistro_flibro','true');
                                    formData.append('idevento',idevento);
                                    formData.append('idusuario',idusuario);
                                    formData.append('fechaevento',diaeventoq);
                                    formData.append('horaevento',horaeventoq);


                                    //bloquear boton para evitar multiples envios de información
                                    this.$$formSubmit.prop('disabled', 'disabled');

                                    //procesar petición
                                    senddata(formData,true);  
                                                                               
                                }
                            },
                            cancel: {
                                text: 'Cancelar',
                                btnClass: 'btn-red',
                                action: function () {
                                //close
                                }
                            }
                        },
                        onContentReady: function () {
                            // bind to events
                            var jc = this;
                            this.$content.find('form').on('submit', function (e) {
                                // if the user submits the form by pressing enter in the field.
                                e.preventDefault();
                                jc.$$formSubmit.trigger('click'); // reference the button and click it
                            });
                            nclicks=0;
                        }
                    });  
                    
                });
                
                //Función para obtener informacion por medio de ajax 
                function obtener_info(datainfo,evaluar){
                    var informacion=null;
                    
                    $.ajax({
                        url: paginaact,  
                        type: 'POST',
                        data: datainfo,
                        cache: false,
                        contentType: false,
                        processData: false,
                        async: false,
                        //mientras enviamos el archivo
                        beforeSend: function(){  
                        },
                        //una vez finalizado correctamente
                        success: function(data){ 
                              informacion=data;                
                        },
                        //si ha ocurrido un error se notifica al usuario
                        error: function (xhr, ajaxOptions, thrownError) {
//                            $('#carga').fadeOut('fast'); 
                            alert(xhr.status+'\n'+thrownError+'\n'+xhr.responseText);
                        }
                    }); 
                    
                    if(evaluar){
                        //return de la información en formato JSON evaluado en forma de ARRAY
                        return eval("(" + informacion + ")");
                    }else{
                        //retorna informacion sin evaluar, obetenida directamente de la peticion ajax
                        return informacion;
                    }
                }
                
                //********************Ejecutar Acciones Ajax********************//
                function senddata(formData,reload){
                    $.ajax({
                        url: paginaact,  
                        type: 'POST',
                        data: formData,
                        cache: false,
                        contentType: false,
                        processData: false,
                        async: false,
                        //mientras enviamos el archivo
                        beforeSend: function(){   
                            $('#precargadiv').fadeIn('fast');
                        },
                        //una vez finalizado correctamente
                        success: function(data){ 
                            if(data.toString().indexOf("Error")!=-1 || data.toString().indexOf("error")!=-1 || data.toString().indexOf("rollback")!=-1){
                                $('#precargadiv').fadeOut('fast'); 
                                $.dialog({
                                    title: '<?php echo utf8_encode('Atención!'); ?>',
                                    content: 'Error al Realizar la <?php echo utf8_encode('Operación'); ?><BR>'+data,
                                    type: 'red',
                                    typeAnimated: true,
                                    backgroundDismissAnimation: 'glow',
                                    boxWidth: '600px',
                                    useBootstrap: false,
                                    buttons: {
                                        close: function () {
                                        }
                                    }
                                });
                            }else{
                                $('#precargadiv').fadeOut('fast');                                 
                                var confirm=$.confirm({
                                    title: 'PreRegistro Realizado Correctamente!',
                                    content: 'Actualizando Contenido...',
                                    type: 'green',
                                    typeAnimated: true,
                                    backgroundDismissAnimation: 'glow',
                                    boxWidth: '600px',
                                    useBootstrap: false,
                                    autoClose: 'aceptar|1500',
                                    lazyOpen: true,
                                    buttons: {
                                        aceptar: {
                                            text: 'Actualizar',
                                            btnClass: 'btn-green',
                                            action: function () {
                                                if(reload){
                                                    location.reload(true);
                                                }
                                            }
                                        }
                                    },
                                    onContentReady: function () {                                        
                                        // bind to events
                                        var jc = this;
                                        this.$content.find('form').on('submit', function (e) {
                                            // if the user submits the form by pressing enter in the field.
                                            e.preventDefault();
                                            jc.$$formSubmit.trigger('click'); // reference the button and click it
                                        });                                       
                                    }                                    
                                });        
                                
                                
                                confirm.open();
                                confirm.buttons.aceptar.hide();
                            }                          
                        },
                        //si ha ocurrido un error se notifica al usuario
                        error: function (xhr, ajaxOptions, thrownError) {
                            $('#precargadiv').fadeOut('fast'); 
                            alert(xhr.status+'\n'+thrownError+'\n'+xhr.responseText);
                        }
                    }); 
                }
                
                $('#precargadiv').fadeOut('fast');
            });
        });
        </script>
        
        <style>
		@import url('https://fonts.googleapis.com/css?family=Open+Sans:300,400,700,800|Roboto+Mono:300,400,500,700|Roboto:300,400,500,700,900');
		
		
            #precarga{
                z-index: 1001;
                position: absolute;
                width: 100px;
                height: 100px;
                top: 50%;
                margin-top: -50px;
                left: 50%;
                margin-left: -50px;
                text-align: center;
                color: white;
            }

            #precargadiv{
                z-index: 100000000;
                position: fixed;
                width: 100%;
                height: 100%;
                top: 0px;
                left: 0px;
                background: rgba(0,0,0,.8);
            }
            
            /*.boxevento{
                width:150px;
                float:left;
                margin:10px;
                cursor:pointer;
            }*/
			
			/* scTheme */
			
			.headUser {display:block; width:100%; margin: 0 auto; padding:16px;}
			.headUser h2 {display:inline-block; float:left; font-family: 'Roboto', sans-serif; font-weight:700; font-size:2em; line-height:1em;}
			.headUser .salir {display:inline-block; float:right;}
			.headUser .salir h2 a { background:#6dbd45; color:#FFF; padding:16px;}
			
			.cpContent {display:block; width:100%; font-family: 'Open Sans', sans-serif; margin-top:60px;} 
			.cpContent h2 {font-size:2em; line-height:1em; font-weight:700;}
			.boxevento { display: inline-block; width:300px;
                float:left; margin:10px; cursor:pointer;background:#DDDDDD;}
			.boxevento .title {display:block; font-weight:400;}
			.boxevento .fecha {display:block;}
			.boxevento .cupo, .boxevento .registrado {display:block;padding:16px; background:#A32F31; color:#FFF;}
			
			/*
			#precargadiv
			#precargadiv #precarga*/
			
        </style>
        
        <?php

	global $current_user;
	get_currentuserinfo();
       
	//echo 'Username: ' . $current_user->user_login . "<br>";
	//echo 'User email: ' . $current_user->user_email . "<br>";
	//echo 'User level: ' . $current_user->user_level . "<br>";
	//echo 'User first name: ' . $current_user->user_firstname . "<br>";
	//echo 'User last name: ' . $current_user->user_lastname . "<br>";
//	echo 'User ID: ' . $current_user->ID . "<br>";


// EMH - Estructura?>
<div class="headUser">
	<h2>&iexcl;Bienvenido, <?php echo $current_user->user_firstname .' '.$current_user->user_lastname.'!'; ?></h2>
    <div class="salir">
        <h2><a href="http://192.168.100.92/worpress/wp-login.php?action=logout">Salir</a></h2>
    </div>
</div>

<?php
	//$all_meta_for_user = get_user_meta( $current_user->ID );
	//print_r( $all_meta_for_user );

	$all_meta_for_user = array_map( function( $a ){ return $a[0]; }, get_user_meta( $current_user->ID ) );
	//print_r( $all_meta_for_user );
	//echo 'ID culturapass: '.$all_meta_for_user['cp_id_culturapass'].'<br><br>';
//	if( !empty($all_meta_for_user['cp_id_culturapass']) ){
//		//echo "Genero: ".$all_meta_for_user['cp_gen'];
//		//echo ':)';
//		echo 'Puedes hacer reservaciones :)';
//	}else{
//		echo '<br>:(  Debes acudir acudir aun recinto certificado por las SecretarÃ­a de Cultura del Estado de Hidalgo; donde al presentar una identificaciÃ³n oficial se te activara y entregara tu CulturaPass';
//	}
?>

<div class="cpContent">
	<h2>Reservaciones</h2>
	<?php
        $eventos=$consultasloc->to_query("SELECT ID,post_title, a.meta_key, a.meta_value as fecha,b.meta_key, "
                . "b.meta_value as tipo,c.meta_key, c.meta_value as cupo,d.meta_key, d.meta_value as hora "
                . "FROM wp_posts join wp_postmeta a on wp_posts.ID=a.post_id "
                . "join wp_postmeta b on wp_posts.ID=b.post_id "
                . "join wp_postmeta c on wp_posts.ID=c.post_id "
                . "join wp_postmeta d on wp_posts.ID=d.post_id "
                . "WHERE wp_posts.post_type='eventos' and wp_posts.post_status='publish' and (a.meta_key like 'fechas_%' and a.meta_value>='".date('Y-m-d')."') "
                . "and (b.meta_key like '%tipo_entrada%' and b.meta_value='Pre Registro' ) and (c.meta_key like '%cch_cupo%' and c.meta_value<>'' ) "
                . "and (d.meta_key like concat( replace(a.meta_key, '_fecha', ''),'_horarios_%')) group by wp_posts.ID,fecha,hora");
        
        while($evento=mysqli_fetch_array($eventos)){
            $nregistros=0;
            $registrado=0;
            $validacupoq=$consultastc->to_query(" select count(*) as registrados from preregistros where "
                    . "idevento=".$evento['ID']." and fechaevento ='".$evento['fecha']."' and horaevento='".$evento['hora']."'");
            while($validacupo=mysqli_fetch_array($validacupoq)){
                $nregistros= floatval($validacupo['registrados']);
            }
            
            $validaregistro=$consultastc->to_query(" select count(*) as registrado from preregistros where "
                    . "idevento=".$evento['ID']." and fechaevento ='".$evento['fecha']."' and horaevento='".$evento['hora']."' and idusuario='".$current_user->ID."'");
            while($validregistro=mysqli_fetch_array($validaregistro)){
                $registrado= floatval($validregistro['registrado']);
            }
            
            /*echo '<div class="boxevento" registrado="'.$registrado.'" cupo="'.$evento['cupo'].'" id-evento="'.$evento['ID'].'" userid="'.$current_user->ID.'" hora="'.$evento['hora'].'" horamostrar="'.substr($evento['hora'],0,5).'" fecha="'.$evento['fecha'].'" fechamostrar="'.substr($evento['fecha'],6,2).'/'.substr($evento['fecha'],4,2).'/'.substr($evento['fecha'],0,4).'">' ;
                echo "<b>".$evento['post_title'].'</b><br>';
                echo "Fecha: <b>".substr($evento['fecha'],6,2).'/'.substr($evento['fecha'],4,2).'/'.substr($evento['fecha'],0,4).'</b><br>';
                echo "Hora: <b>".substr($evento['hora'],0,5).'</b>';
                if($nregistros>=$evento['cupo']){
                    echo '<br><br><span  style="background-color:red; color:white; padding: 5px;border-radius: 5px;">Evento Lleno!</span>';
                }
                if($registrado>0){
                    echo '<br><br><span  style="background-color:green; color:white; padding: 5px;border-radius: 5px;">Estas Registrado!</span>';
                }
            echo'</div>';*/
        }    
    ?>
    
    <div class="boxevento" <?php echo 'registrado="'.$registrado.'" cupo="'.$evento['cupo'].'" id-evento="'.$evento['ID'].'" userid="'.$current_user->ID.'" hora="'.$evento['hora'].'" horamostrar="'.substr($evento['hora'],0,5).'" fecha="'.$evento['fecha'].'" fechamostrar="'.substr($evento['fecha'],6,2).'/'.substr($evento['fecha'],4,2).'/'.substr($evento['fecha'],0,4);?> >
    
    	<span class="title"><?php echo $evento['post_title'] ?></span>
        <span class="fecha">Fecha: <?php echo substr($evento['fecha'],6,2).'/'.substr($evento['fecha'],4,2).'/'.substr($evento['fecha'],0,4); ?></span>
        <span class="hora">Hora: <?php echo substr($evento['hora'],0,5)?></span>
        <?php
        if($nregistros>=$evento['cupo']){?>
                    <span class="cupo">&iexcl;Evento lleno!</span><?php
                }
                if($registrado>0){?>
                    <span class="registrado"></span><?php
                }
        ?>
    </div>
    
</div><!-- cpContent -->

<div style="clear:both; height:60px;"></div>

 <div id="precargadiv">
    <div id="precarga" class="" style="text-align: center;">            
        <img src="../wp-content/themes/EspecialesT2/culturapass/siscp/images/cargando.gif" style=" width: 100px; height: 100px;"/><br>
        <b>Cargando Informaci&oacute;n. Espere...</b>
    </div>	
</div>









<?php
/*
get_posts(
$args=array(
    'post_type'      => 'eventos',
    'posts_per_page' => '-1',
    'post_status' => 'publish',
    'meta_query'    => array()
	)
);
if($selCosto!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'tipo_entrada', 
                 'value' => $selCosto, 
                 'compare' => '==',
      )),
  ));
}
if($selPublico != '0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'publico', 
                 'value' => $selPublico, 
                 'compare' => '==',
      )),
  ));
}
if($selDisciplina!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'disciplina', 
                 'value' => $selDisciplina, 
                 'compare' => '==',
      )),
  ));
}
if($selOrganiza!='4'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'tipo_organismo', 
                 'value' => $selOrganiza, 
                 'compare' => '==',
      )),
  ));
}
if($selMunicipios!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selMunicipiosT, 
                 'compare' => 'IN',
      )),
    ));
}
if($selRecinto!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'lugar', 
                 'value' => $selRecintosT, 
                 'compare' => 'IN',
      )),
    ));
}
if($selCategorias!='0'){
  array_push($args['meta_query'], array(
      array(
             array(
                 'key' => 'categoria', 
                 'value' => $selCategorias, 
                 'compare' => 'LIKE',
      )),
    ));
}

$metaQuery = count($args['meta_query']);
if ($metaQuery>=2) {
  array_push($args['meta_query'], array(
      'relation'  => 'AND',
      ));
}

$posts1 = get_posts($args);
$array_de_resultados = Array(); 

foreach( $posts1 as $post ){
	$ID = get_the_ID();
	$array_de_fechas = Array(); 
	
	if( have_rows('fechas') ){
			while( have_rows('fechas') ){
				the_row();
				$array_de_fechas[] = get_sub_field('fecha',false);
			}
		}
	
	$result = array_intersect($array_fechas_actual, $array_de_fechas);

	if (!empty($result)) {
		$array_de_resultados[] = [$ID, reset($result)];
		$bandera=1;
	}//hubo resultado
} //end foreach

if($bandera == 0){
    echo '<div class="msj_error">No existen resultados con los parÃ¡metros aplicados</div>';
}else{
	
foreach ($array_de_resultados as $clave => $fila){
	$fech[$clave] = $fila['1'];
}
array_multisort($fech, SORT_ASC, $array_de_resultados);

$myarray = Array(); 
foreach ($array_de_resultados as $fila){
	$myarray[] = $fila[0];
}
*/





//get_posts(
//$args=array(
//    'post_type'      => 'eventos',
//    'posts_per_page' => '-1',
//    'post_status' => 'publish',
//    'meta_query'    => array()
//	)
//);
//
//  array_push($args['meta_query'], array(
//      array(
//             array(
//                 'key' => 'publico', 
//                 'value' => 'Adultos', 
//                 'compare' => '==',
//      )),
//  ));
//
// array_push($args['meta_query'], array(
//      array(
//             array(
//                 'key' => 'tipo_entrada', 
//                 'value' => 'Pre Registro', 
//                 'compare' => '===',
//      )),
//  ));
//
//
//
//  array_push($args['meta_query'], array(
//      'relation'  => 'AND',
//      ));
//$posts = get_posts($args);
//foreach( $posts as $post ){
//	echo $ID = get_the_ID();
//	echo '<br>';
//	
//    //print_r( get_post_meta( get_the_ID() ) ); 
//    print_r( get_post_meta( $ID, 'tipo_entrada', true ) );
//    echo '<br>';
//    echo '<br>';
//}
//}

?>