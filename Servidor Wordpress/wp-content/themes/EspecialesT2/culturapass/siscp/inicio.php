<?php
//plantilla v4.0
    //Declaración del Objeto $consultas de la Clase controladora DBClass.php necesaria para el control de funciones del Sistema
    include_once 'DBClass.php';
    $consultas = new DBClass(); 
    
    //Extracción del Token de Sesion del Sistema
    $tokenSystem=$consultas->gettokensystem();
    
                    /***********************Configuración****************************/
    //Recuperar la pagina que esta apuntano el script
    $pagina=$_SERVER['PHP_SELF'];
    $paginaarray=explode('/', $pagina);
    $selfpag=array_pop($paginaarray);
    
    //Varibles Globales del Archivo (pueden ser omitidas), optimizadas para catálogos solo cambiar nombre de tabla y el ID de la misma.
    $tablabase="";
    $idbase="";
    $paginabase=$selfpag;
    
    //Variables para generación de formularios y almacen de datos $campos['Nombre_campo']="aray de atributos";
    $atribs['tipo']="texto";
    $atribs['label']="ID Cultura Pass";
    $atribs['obligatorio']=true; 
    $campos['idculturapass']=$atribs;
    unset($atribs);  
    $atribs['tipo']="number";
    $atribs['label']="Cantidad";
    $atribs['obligatorio']=true; 
    $campos['cantidad']=$atribs;
    unset($atribs);
  
    $atribs['tipo']="select";
    $atribs['label']="Evento";
    $atribs['obligatorio']=true;                
    $atribs['camposselect']="ID,concat(post_title,' (',substring(meta_value,1,5),')') as fechah,substring(meta_value,1,5) as hora, '". date("Y-m-d")."' as date,meta_key,meta_value";                
    $atribs['tablaselect']="(
        SELECT ID,post_title, replace(meta_key, '_fecha', '') as meta_key_new FROM wp_postmeta join wp_posts on wp_posts.ID=wp_postmeta.post_id  WHERE wp_posts.post_type='eventos' and wp_posts.post_status='publish' and (meta_key like '%fechas_%' and meta_value='". date("Ymd")."') 
        group by wp_posts.ID
        ) as eventosxfech join wp_postmeta on eventosxfech.ID=wp_postmeta.post_id";  
    
    //ajuste de hora para posibles eventos (hasta 30 min despues de haber iniciado
    $nuevafecha = strtotime ( '-60 minute' , strtotime ( date("H:i:s") ) ) ;
    $nuevafecha = date ( 'H:i:s' , $nuevafecha );
    
    $atribs['whereselect']="meta_key like concat('%',meta_key_new,'_horarios_%') and meta_value>'". $nuevafecha."' and meta_value not like '%field_%'  group by eventosxfech.ID,meta_key,meta_value";                
//    $atribs['camposselect']='ID,post_title';                
//    $atribs['tablaselect']='wp_postmeta join wp_posts on wp_posts.ID=wp_postmeta.post_id';                
//    $atribs['whereselect']="wp_posts.post_type='eventos' and wp_posts.post_status='publish' and meta_key like '%fechas_%' and meta_value='". date("Ymd")."' group by wp_posts.ID";                
    $atribs['defaultselect']='';              
    $camposacceso['idevento']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="ID Cultura Pass";
    $atribs['obligatorio']=true; 
    $camposaccesocp['idculturapassevent']=$atribs;
    unset($atribs); 
    $atribs['tipo']="divisor3";
    $atribs['label']="";
    $atribs['classall']="50";
    $atribs['obligatorio']=true; 
    $camposaccesocp['saldocpevento']=$atribs;
    unset($atribs); 
    $atribs['tipo']="divisor3";
    $atribs['label']="";
    $atribs['classall']="50";
    $atribs['obligatorio']=true; 
    $camposaccesocp['eventomax']=$atribs;
    unset($atribs); 
    $atribs['tipo']="number";
    $atribs['label']="Cantidad de Boletos";
    $atribs['obligatorio']=true; 
    $camposaccesocp['cantidadboletos']=$atribs;
    unset($atribs);
    
    
    $atribs['tipo']="divisor3";
    $atribs['label']="Hombres";
    $atribs['classall']="50";
    $atribs['attr']='style="text-align:center; font-size:1.2em; margin-bottom:10px;"';
    $atribs['obligatorio']=false; 
    $camposaccesodata['hombreslabel']=$atribs;
    unset($atribs); 
    $atribs['tipo']="divisor3";
    $atribs['label']="Mujeres";
    $atribs['classall']="50";
    $atribs['attr']='style="text-align:center; font-size:1.2em; margin-bottom:10px;"';
    $atribs['obligatorio']=false; 
    $camposaccesodata['mujereslabel']=$atribs;
    unset($atribs); 
    $atribs['tipo']="number";
    $atribs['label']="Niños";
    $atribs['class']="nboleto";
    $atribs['classall']="50";
    $atribs['classalli']="90";
    $atribs['attr']=' idgrupoedad="1" sexo="H" ';
    $atribs['obligatorio']=false; 
    $camposaccesodata['nniñosh']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Niñas";
    $atribs['class']="nboleto";
    $atribs['classall']="50";
    $atribs['classalli']="90";
    $atribs['attr']=' idgrupoedad="1" sexo="M" ';
    $atribs['obligatorio']=false; 
    $camposaccesodata['nniñosm']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Adolescente";
    $atribs['class']="nboleto";
    $atribs['classall']="50";
    $atribs['classalli']="90";
    $atribs['attr']=' idgrupoedad="2" sexo="H" ';
    $atribs['obligatorio']=false; 
    $camposaccesodata['nadolescenteh']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Adolescente";
    $atribs['class']="nboleto";
    $atribs['classall']="50";
    $atribs['classalli']="90";
    $atribs['attr']=' idgrupoedad="2" sexo="M" ';
    $atribs['obligatorio']=false; 
    $camposaccesodata['nadolescentem']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Adulto";
    $atribs['class']="nboleto";
    $atribs['classall']="50";
    $atribs['classalli']="90";
    $atribs['attr']=' idgrupoedad="3" sexo="H" ';
    $atribs['obligatorio']=false; 
    $camposaccesodata['nadultoh']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Adulto";
    $atribs['class']="nboleto";
    $atribs['classall']="50";
    $atribs['classalli']="90";
    $atribs['attr']=' idgrupoedad="3" sexo="M" ';
    $atribs['obligatorio']=false; 
    $camposaccesodata['nadultom']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Adulto Mayor";
    $atribs['class']="nboleto";
    $atribs['classall']="50";
    $atribs['classalli']="90";
    $atribs['attr']=' idgrupoedad="4" sexo="H" ';
    $atribs['obligatorio']=false; 
    $camposaccesodata['nadultomh']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Adulto Mayor";
    $atribs['class']="nboleto";
    $atribs['classall']="50";
    $atribs['classalli']="90";
    $atribs['attr']=' idgrupoedad="4" sexo="M" ';
    $atribs['obligatorio']=false; 
    $camposaccesodata['nadultomm']=$atribs;
    unset($atribs);
    $atribs['tipo']="divisor3";
    $atribs['label']="";
    $atribs['obligatorio']=false; 
    $camposaccesodata['endform']=$atribs;
    
    
    //Variables para generación de formularios y almacen de datos $campos['Nombre_campo']="aray de atributos";
    $atribs['tipo']="texto";
    $atribs['label']="ID Cultura Pass";
    $atribs['obligatorio']=true; 
    $camposconsulta['idculturapass']=$atribs;
    unset($atribs);
    
    //Funciones de manejo de pagina
    if(isset($_POST['abono'])){
        echo $consultas->save_abono($_POST['idculturapass'],$_POST['cantidad'],$_POST['idusuariosc']);
        die();
    }  
    
    if(isset($_POST['cargo'])){
        echo $consultas->save_cargo($_POST['idculturapass'],$_POST['cantidad'],$_POST['idservicio'],$_POST['idevento'],$_POST['fecha'],$_POST['hora'],$_POST['idusuariosc'],$_POST['cantidadb'],$_POST['estadistica']);
        die();
    }  
    
    if(isset($_POST['consulta'])){
        echo $consultas->consulta_saldo($_POST['idculturapass']);
        die();
    }   
        
    if(isset($_POST['validcp'])){
        echo $consultas->validar_cp_movs($_POST['idculturapass']);
        die();
    }   
    
    //obtener iformación definiendo tipo de return, campos, tabla y condición en la solicitud post.
    //requiere: tipo return, Campos, tabla y condición
    //return: dependiendo del tipo: single->array en json con un solo resultados de la consulta..... multiple->array en json con multiples resultados de la consulta.
    if(isset($_POST['obtener_info'])){
        if($_POST['obtener_info']==="multiple"){
            $informacionreturn=array();
            $informacion=array();

            $data = $consultas->obtener_datos_campos($_POST['campos'],$_POST['tabla'], $_POST['where']);
            while ($row = mysql_fetch_array($data)){    
                foreach ($row as $key => $value) {
                    if(is_string($key)){
                        $informacion[$key]=$value;                
                    }
                }
                $informacionreturn[]=($informacion);
            }     

            echo (json_encode(array($informacionreturn)));
        }else if($_POST['obtener_info']==="single") {
            $informacion=array();
        
            $data = $consultas->obtener_datos_campos($_POST['campos'],$_POST['tabla'], $_POST['where']);
            while ($row = mysql_fetch_array($data)){                
                foreach ($row as $key => $value) {
                    if(is_string($key)){
                        $informacion[$key]=$value;                
                    }
                }
            }     

            echo (json_encode(array($informacion)));
        }
        die();
    }
    
    //Validación de SESION
    session_start();
    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set('Mexico/General');    
    
    if((!isset($_SESSION[$tokenSystem]))||($_SESSION[$tokenSystem]==false))
    {
        header("Location: index.php");        
        exit;
    }   
       
    $usuariologin=$_SESSION['idusuariocultura'.$consultas->gettokensystemclass()];
    
    //Construcción del html para formulario Agregar y Editar (catalogos)
    //<!--Formato del bloque por campo.... 
    //        <div
    //            <label
    //            <div
    //                <input
    //            </div>
    //        </div>
    //        -->
    //<!--FIN Formato del bloque por campo....-->
    
    //definición de los ancho de campo (cambia de 5 en 5 a sumar 100)
    $ancholabel=40;
    $anchocampo=60;  
    
    //anchos de los formularios
    $anchoformadd='600px';
    
    $buscari=array("%_ancholabel_%", "%_anchocampo_%");
    $reemplazari=array($ancholabel, $anchocampo);
    
     //formulario de agregar saldo
    $formadd='<form id="FormAgrega" class="ink-form all-100 content-center" action="" method="post">';
        foreach($campos as $key=>$value){           
            $dominput=$consultas->obtener_plantilla($value['tipo'], $key, $value,false);
            $formadd.=str_ireplace($buscari,$reemplazari,$dominput);
        }
    $formadd.='</form>';
    
     //formulario de consulta de saldos
    $formconsulta='<form id="FormConsulta" class="ink-form all-100 content-center" action="" method="post">';
        foreach($camposconsulta as $key=>$value){           
            $dominput=$consultas->obtener_plantilla($value['tipo'], $key, $value,false);
            $formconsulta.=str_ireplace($buscari,$reemplazari,$dominput);
        }
    $formconsulta.='<div id="detalles_saldos"></div></form>';
    
     //formulario de acceso
    $formacceso='<form id="FormAccesa" class="ink-form all-100 content-center" action="" method="post">';
        foreach($camposacceso as $key=>$value){           
            $dominput=$consultas->obtener_plantilla($value['tipo'], $key, $value,false);
            $formacceso.=str_ireplace($buscari,$reemplazari,$dominput);
        }
        $formacceso.='<div id="formdetacceso" style="display:none; all-100;">'
                . '<div id="costoeventolabel"></div>';
        foreach($camposaccesocp as $key=>$value){           
            $dominput=$consultas->obtener_plantilla($value['tipo'], $key, $value,false);
            $formacceso.=str_ireplace($buscari,$reemplazari,$dominput);
        }
        $formacceso.="</div><hr>";                
        $formacceso.='<div id="formdatacceso" style="all-100; display:none;">';                
        foreach($camposaccesodata as $key=>$value){           
            $dominput=$consultas->obtener_plantilla($value['tipo'], $key, $value,false);
            $formacceso.=str_ireplace($buscari,$reemplazari,$dominput);
        }
        $formacceso.="</div>";                
    $formacceso.='</form>';
    
    //formateo de las cadenas de los formularios definidos por el usuario a una cadena serializada.(NO MODIFICAR)
    $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
    $reemplazar=array("", "", "", "");
    $formadd=str_ireplace($buscar,$reemplazar,$formadd);
    $formconsulta=str_ireplace($buscar,$reemplazar,$formconsulta);
    $formacceso=str_ireplace($buscar,$reemplazar,$formacceso);
    
?>
<!DOCTYPE html>
<html lang="es">    
    <head>
        <!-- Información General del Sistema-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $consultas->getnamesystem(); ?></title>
        <meta name="description" content="">
        <meta name="author" content="Subsecretaría de Innovación y Emprendimiento Cultural">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
        
        <!-- Place favicon.ico and apple-touch-icon(s) here  -->

        <link rel="shortcut icon" href="img/favicon.ico">
        <link rel="apple-touch-icon-precomposed" href="img/touch-icon.57.png">
        <link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/touch-icon.72.png">
        <link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/touch-icon.114.png">
        <link rel="apple-touch-startup-image" href="img/splash.320x460.png" media="screen and (min-device-width: 200px) and (max-device-width: 320px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="img/splash.768x1004.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:portrait)">
        <link rel="apple-touch-startup-image" href="img/splash.1024x748.png" media="screen and (min-device-width: 481px) and (max-device-width: 1024px) and (orientation:landscape)">
        
        <!--Archivos CSS de INK, y Fuentes-->  
        <link rel="stylesheet" type="text/css" href="css/ink.css">
        <link rel="stylesheet" type="text/css" href="css/quick-start.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/ink-flex.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        
		<!-- <link rel="stylesheet" type="text/css" href="css/style2.css"> -->
        <!--<link rel="stylesheet" type="text/css" href="css/chosen.css">-->
		<!--<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>-->
        <!--[if IE 7 ]>
            <link rel="stylesheet" href="../css/ink-ie7.css" type="text/css" media="screen" title="no title" charset="utf-8">
        <![endif]-->
        
        <!--Archivo CSS de Data Tables-->
        <link href="datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        
        <!--Archivo CSS para plugin Chosen para listas desplegables -->
        <!--<link rel="stylesheet" type="text/css" href="css/chosen.css">-->
        
        <!--Archivo CSS para plugin JConfirm para ventanas modales -->
        <link href="css/jquery-confirm.css" rel="stylesheet" type="text/css"/>
        
        <!--Plugin JS de INK y JQUERY (Esqueleto del funcionamiento de los sistemas)!-->
        <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/holder.js"></script>
        <script type="text/javascript" src="js/ink.min.js"></script>
        <script type="text/javascript" src="js/ink-ui.min.js"></script>
        <script type="text/javascript" src="js/ink-all.min.js"></script>
        <script type="text/javascript" src="js/autoload.js"></script>
        
        <!--Plugin chosen para listas desplegables!-->
        <!--<script type="text/javascript" src="js/chosen.jquery.js"></script>-->
        
        <!--Plugin para control de datatables!-->
        <script src="datatables/jquery.dataTables.js" type="text/javascript"></script>
        
        <!--Archivo JS para plugin JConfirm para ventanas modales -->
        <script src="js/jquery-confirm.js" type="text/javascript"></script>
                
        <!-- Script Principal de control de la página en general-->
        <script>
            $(document).ready(function(){  
                //Página a la que se realizarán las peticiones AJAX y solicitudes de información
                var paginaact='<?php echo $paginabase; ?>';                
                var widthjc="50%";     
                                
                $('#abono').click(function (e){    
                    
                    var width = $(window).width();
                    if(width<=360){
                        widthjc="99%";
                    }else if(width>360 && width<=750){
                        widthjc="70%";
                    }
                    
                    var abonojc = $.confirm({
                        title: '<b>Abonar Saldo</b>',
                        content: '<?php echo trim($formadd); ?>',
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
                                    if(!valida("#FormAgrega")){
                                        return false;
                                    }else{
                                        var validacultus=0;
                                        var infoData = new FormData();
                                        infoData.append('obtener_info',"single");
                                        infoData.append('campos','count(*) as validcultus');
                                        infoData.append('tabla','wp_usermeta');
                                        infoData.append('where',"meta_key='cp_id_culturapass' and meta_value='"+$('#idculturapass').val()+"'");
                                        //Vaciado de la información actual
                                        $.each(obtener_info(infoData,true), function(key, value){ 
                                            validacultus=this.validcultus;
                                        });
                                        
                                        if(validacultus==0){
                                            $('#precargadiv').fadeOut('fast');
                                            $.dialog({
                                                title: 'Atención!',
                                                content: 'La tarjeta no se encuentra activada!',
                                                icon: 'fa fa-exclamation-circle',
                                                type: 'red',
                                                typeAnimated: true,
                                                backgroundDismissAnimation: 'glow',
                                                boxWidth: widthjc,
                                                useBootstrap: false,
                                                buttons: {
                                                    close: function () {
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        
                                        //validar si la tarjeta tiene movimientos corruptos
                                        var infoDatac = new FormData();
                                        infoDatac.append('validcp',"true");
                                        infoDatac.append('idculturapass',$('#idculturapass').val());
                                        //Vaciado de la información actual
                                        if(!obtener_info(infoDatac,false)){
                                            $.dialog({
                                                title: 'Atención!',
                                                content: 'La tarjeta parece estar corrupta!',
                                                icon: 'fa fa-exclamation-circle',
                                                type: 'red',
                                                typeAnimated: true,
                                                backgroundDismissAnimation: 'glow',
                                                boxWidth: widthjc,
                                                useBootstrap: false,
                                                buttons: {
                                                    close: function () {
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        
                                        $.confirm({
                                            title: '<b>Confirmar Transacción</b>',
                                            icon: 'fa fa-warning',
                                            type: 'red',
                                            content: '<span style="font-size:20px;">¿Deseas abonar la cantidad de <b style="color:red">$'+parseFloat($('#cantidad').val()).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')+'</b> a la tarjeta <b style="color:red">No. '+$('#idculturapass').val()+'</b></span>',
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
                                                        if(!valida("#FormAgrega")){
                                                            return false;
                                                        }else{           
                                                            //formato de la información a enviar por POST con isntrucción SAVE
                                                            var formData = new FormData();
                                                            formData.append('abono','true');
                                                            formData.append('idusuariosc','<?php echo $usuariologin; ?>');

                                                            //obtener los input junto con sus valores para agregarlos a la petición
                                                            $('#FormAgrega input,#FormAgrega select').each(function(){
                                                                if($(this).attr('id')!==undefined){
                                                                    formData.append($(this).attr('id'),$(this).val());
                                                                }
                                                            });

                                                            //bloquear boton para evitar multiples envios de información
                                                            this.$$formSubmit.prop('disabled', 'disabled');
                                                            
                                                            //procesar petición
                                                            senddata(formData,true);     
                                                            abonojc.close();
                                                        }                                                         
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
                                            }
                                        });                                  
                                    }   
                                    
                                    
                                    return false;
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
                        }
                    });
                    
                });
                
                $('#consulta').click(function (e){    
                    
                    var width = $(window).width();
                    if(width<=360){
                        widthjc="99%";
                    }else if(width>360 && width<=750){
                        widthjc="70%";
                    }
                    
                    var consultajc = $.confirm({
                        title: '<b>Consulta de Saldo</b>',
                        content: '<?php echo trim($formconsulta); ?>',
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
                                    $('#detalles_saldos').html('');
                                    if(!valida("#FormConsulta")){
                                        return false;
                                    }else{
                                        var validacultus=0;
                                        var infoData = new FormData();
                                        infoData.append('obtener_info',"single");
                                        infoData.append('campos','count(*) as validcultus');
                                        infoData.append('tabla','wp_usermeta');
                                        infoData.append('where',"meta_key='cp_id_culturapass' and meta_value='"+$('#idculturapass').val()+"'");
                                        //Vaciado de la información actual
                                        $.each(obtener_info(infoData,true), function(key, value){ 
                                            validacultus=this.validcultus;
                                        });

                                        if(validacultus==0){
                                            $('#precargadiv').fadeOut('fast');
                                            $.dialog({
                                                title: 'Atención!',
                                                content: 'La tarjeta no se encuentra activada!',
                                                icon: 'fa fa-exclamation-circle',
                                                type: 'red',
                                                typeAnimated: true,
                                                backgroundDismissAnimation: 'glow',
                                                boxWidth: widthjc,
                                                useBootstrap: false,
                                                buttons: {
                                                    close: function () {
                                                    }
                                                }
                                            });
                                            return false;
                                        }
                                        
                                        var infoDatac = new FormData();
                                        infoDatac.append('consulta','true');
                                        infoDatac.append('idculturapass',$('#idculturapass').val());
                                        var saldos=obtener_info(infoDatac,false);
                                        
                                        $('#detalles_saldos').html(saldos);
                                    }
                                    
                                    return false;
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
                        }
                    });
                    
                });
                
                $('#acceso').click(function (e){    
                    
                    var width = $(window).width();
                    if(width<=360){
                        widthjc="99%";
                    }else if(width>360 && width<=750){
                        widthjc="70%";
                    }
                    
                    var abonojc = $.confirm({
                        title: '<b>Acceso a Evento</b>',
                        content: '<?php echo trim($formacceso); ?>',
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
                                    if(!valida("#FormAccesa")){
                                        return false;
                                    }else{
                                        var nboletos = 0;                                    
                                        var nboletosd=0;
                                        var totalcompra=0;
                                        var costob=parseFloat($('#costoeventolabel').attr("costo"));
                                        var textboletos="boleto";
                                        
                                        nboletos = parseFloat($('#cantidadboletos').val());
                                        $('input.nboleto').each(function(){
                                            if($(this).val()!==""){
                                                var nb=parseFloat($(this).val());
                                                nboletosd+=nb;                            
                                            }
                                        });
                                        nboletosd = parseFloat(nboletosd);
                                        
                                        if(nboletos>1){
                                            textboletos="boletos";
                                        }
                                        
                                        totalcompra=nboletos*costob;
                                        
                                        if(nboletos!=nboletosd){
                                            $.dialog({
                                                title: 'Atención!',
                                                content: 'La cantidad de boletos deseada y el desgloce de los mismos debe ser igual!',
                                                icon: 'fa fa-exclamation-circle',
                                                type: 'red',
                                                typeAnimated: true,
                                                backgroundDismissAnimation: 'glow',
                                                boxWidth: widthjc,
                                                useBootstrap: false,
                                                buttons: {
                                                    close: function () {
                                                    }
                                                }
                                            });
                                            return false;
                                        }else{
                                            
                                            $.confirm({
                                                title: '<b>Confirmar Transacción</b>',
                                                icon: 'fa fa-warning',
                                                type: 'red',
                                                content: '<span style="font-size:20px;">¿Confirmar la compra de <b style="color:red">'+nboletos
                                                        +' '+textboletos+' </b> por la cantidad de <b style="color:red">$'+parseFloat(totalcompra).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')+'</b> de la tarjeta <b style="color:red">No. '+$('#idculturapassevent').val()+'</b>?</span>',
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
                                                            //formato de la información a enviar por POST con isntrucción SAVE
                                                            var formData = new FormData();
                                                            formData.append('cargo','true');
                                                            formData.append('cantidad',totalcompra);
                                                            formData.append('idculturapass',$('#idculturapassevent').val());
                                                            
                                                            formData.append('idservicio','1');
                                                            formData.append('idevento',$('#idevento').val());
                                                            formData.append('fecha',$('#idevento option:selected').attr('attradd2'));
                                                            formData.append('hora',$('#idevento option:selected').attr('attradd'));
                                                            formData.append('idusuariosc','<?php echo $usuariologin; ?>');
                                                            formData.append('cantidadb',nboletos);
                                                            
                                                            var estadistica="";
                                                            
                                                            $('input.nboleto').each(function(){
                                                                if($(this).val()!==""){
                                                                    if(estadistica===""){
                                                                        estadistica=$(this).attr('idgrupoedad')+";"+$(this).attr('sexo')+";"+$(this).val();
                                                                    }else{
                                                                        estadistica+="|"+$(this).attr('idgrupoedad')+";"+$(this).attr('sexo')+";"+$(this).val();
                                                                    }                         
                                                                }
                                                            });
                                                            
                                                            
                                                            formData.append('estadistica',estadistica);
                                                            
                                                            //obtener los input junto con sus valores para agregarlos a la petición
//                                                                $('#FormAgrega input,#FormAgrega select').each(function(){
//                                                                    if($(this).attr('id')!==undefined){
//                                                                        formData.append($(this).attr('id'),$(this).val());
//                                                                    }
//                                                                });

                                                            //bloquear boton para evitar multiples envios de información
                                                            this.$$formSubmit.prop('disabled', 'disabled');

                                                            //procesar petición
                                                            senddata(formData,false);  
                                                            $('#idevento').change();
//                                                                abonojc.close();                                                     
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
                                                }
                                            });    
                                        }
                                    }
                                    
                                    return false;
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
                        }
                    });
                    
                });
                
                /********************Controlar cambios de change de un select**********************/
                $('body').on('change','select',function(){
                    var id=$(this).attr('id');
                    var value=$(this).val();
                    
                    switch(id){
                        case 'idevento':
                            $('#idculturapassevent').removeClass('errorstyle');
                            $('#idculturapassevent').removeAttr('placeholder');
                            $('#cantidadboletos').removeClass('errorstyle');
                            $('#cantidadboletos').removeAttr('placeholder');
                            $('#idculturapassevent').val("").change();
                            
                            if(value!==""){
                                var tipoevento="";
                                var costo="";
                                var costolabel="";
                                var infoData = new FormData();
                                infoData.append('obtener_info',"single");
                                infoData.append('campos','meta_value');
                                infoData.append('tabla','wp_postmeta');
                                infoData.append('where',"meta_key='tipo_entrada' and post_id='"+value+"'");
                                //Vaciado de la información actual
                                $.each(obtener_info(infoData,true), function(key, value){ 
                                    tipoevento=this.meta_value;
                                });

                                if(tipoevento==="Cuota de recuperación" || tipoevento==="Inscripción"){                                
                                    var infoData = new FormData();
                                    infoData.append('obtener_info',"single");
                                    infoData.append('campos','meta_value');
                                    infoData.append('tabla','wp_postmeta');
                                    infoData.append('where',"meta_key='costo_entrada' and post_id='"+value+"'");
                                    //Vaciado de la información actual
                                    $.each(obtener_info(infoData,true), function(key, value){ 
                                        costo=parseFloat(this.meta_value);
                                        costolabel='<div class="control-group gutters"> <div class="all-40"><b>Costo:</b> </div><div class="all-60"><b>$'+parseFloat(costo).toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, '$1,')+'</b></div></div>';
                                    });
                                }else if(tipoevento==="Gratuito" || tipoevento==="Boleto de cortesía"){
                                    costo=0;
                                    costolabel='<div class="control-group gutters"> <div class="all-40"><b>Costo:</b> </div><div class="all-60"><b>Gratuito</b></div></div>';
                                    //ostolabel="Costo: Gratuito";
                                }

                                $('#formdetacceso').show('slow');
                                $('#costoeventolabel').html(costolabel);
                                $('#costoeventolabel').attr("costo",costo);
                                if(tipoevento==="Cuota de recuperación" || tipoevento==="Inscripción"){
                                    $('#cantidadboletos').attr("disabled","disabled");
                                }else{
                                    $('#cantidadboletos').attr("disabled","disabled");
                                }
                            }else{
                                
                                $('#costoeventolabel').html('');
                                $('#costoeventolabel').attr("costo",0);
                                $('#formdetacceso').hide('slow');
                            }
                            
                            break;                              
                    }
                });
                
                $('body').on('change','input',function(){
                    var id=$(this).attr('id');
                    var value=$(this).val();
                    
                    switch(id){
                        case 'idculturapassevent':
                            
                            if(value!==""){
                                var validacultus=0;
                                var infoData = new FormData();
                                infoData.append('obtener_info',"single");
                                infoData.append('campos','count(*) as validcultus');
                                infoData.append('tabla','wp_usermeta');
                                infoData.append('where',"meta_key='cp_id_culturapass' and meta_value='"+value+"'");
                                //Vaciado de la información actual
                                $.each(obtener_info(infoData,true), function(key, value){ 
                                    validacultus=this.validcultus;
                                });

                                if(validacultus==0){
                                    $.dialog({
                                        title: 'Atención!',
                                        content: 'La tarjeta no se encuentra activada!',
                                        icon: 'fa fa-exclamation-circle',
                                        type: 'red',
                                        typeAnimated: true,
                                        backgroundDismissAnimation: 'glow',
                                        boxWidth: widthjc,
                                        useBootstrap: false,
                                        buttons: {
                                            close: function () {
                                            }
                                        }
                                    });
                                    $(this).val("").change();
                                    return false;
                                }

                                var infoDatac = new FormData();
                                infoDatac.append('consulta','true');
                                infoDatac.append('idculturapass',$('#idculturapassevent').val());
                                var saldos=obtener_info(infoDatac,false);

                                $('#divsaldocpevento').html(saldos+"<br>");
                                
                                var costoevento=parseFloat($('#costoeventolabel').attr("costo"));
                                
                                if(costoevento==0){
                                    $('#cantidadboletos').removeAttr('disabled');
                                    $('#diveventomax').html("Boletos para compra: <b>---<b><br>");
                                }else{
                                    var saldo=parseFloat($('#saldocp_calc1').attr('saldo'));
                                    
                                    if(saldo>=costoevento){
                                        $('#cantidadboletos').removeAttr('disabled');
                                        var maxboletosn=Math.trunc(saldo/costoevento);
                                        $('#diveventomax').html("Boletos para compra: <b>"+maxboletosn+"<b><br>");
                                    }else{
                                        $('#cantidadboletos').attr('disabled','disabled');
                                        $('#cantidadboletos').val("").change();
                                        $('#diveventomax').html("Boletos para compra: <b>0<b><br>");
                                        $.dialog({
                                            title: 'Atención!',
                                            content: 'La tarjeta no cuenta con saldo suficiente!',
                                            icon: 'fa fa-exclamation-circle',
                                            type: 'red',
                                            typeAnimated: true,
                                            backgroundDismissAnimation: 'glow',
                                            boxWidth: widthjc,
                                            useBootstrap: false,
                                            buttons: {
                                                close: function () {
                                                }
                                            }
                                        });
                                    }
                                }
                                
                            }else{
                                $('#divsaldocpevento').html("");
                                $('#diveventomax').html("");
                                $('#cantidadboletos').val("").change().attr('disabled','disabled');
                            }
                            break;
                        case 'cantidadboletos':
                            if(value!==""){
                                if(value>0){
                                    var costo=parseFloat($('#costoeventolabel').attr('costo'));
                                    var saldo=parseFloat($('#saldocp_calc1').attr('saldo'));
    //                                var maxboletosn=parseFloat(Math.trunc(saldo/costoevento));
                                    var nboletosc=parseFloat(value);

                                    if(costo==0){
                                        $('#formdatacceso').show('slow');
                                        $('#formdatacceso input').each(function(){
                                            $(this).val("");
                                        });
                                    }else{
                                        if((nboletosc*costo)>saldo){
                                            $.dialog({
                                                title: 'Atención!',
                                                content: 'La tarjeta no cuenta con saldo suficiente para comprar '+nboletosc+' boletos!',
                                                icon: 'fa fa-exclamation-circle',
                                                type: 'red',
                                                typeAnimated: true,
                                                backgroundDismissAnimation: 'glow',
                                                boxWidth: widthjc,
                                                useBootstrap: false,
                                                buttons: {
                                                    close: function () {                                                    
                                                    }
                                                }
                                            });
                                            $("#cantidadboletos").val("").change();
                                        }else{
                                            $('#formdatacceso').show('slow');
                                            $('#formdatacceso input').each(function(){
                                                $(this).val("");
                                            });
                                        }
                                    }
                                }else{
                                    $.dialog({
                                        title: 'Atención!',
                                        content: 'El número de boletos no puede ser menor o igual a 0!',
                                        icon: 'fa fa-exclamation-circle',
                                        type: 'red',
                                        typeAnimated: true,
                                        backgroundDismissAnimation: 'glow',
                                        boxWidth: widthjc,
                                        useBootstrap: false,
                                        buttons: {
                                            close: function () {                                                    
                                            }
                                        }
                                    });
                                    $(this).val("").change();
                                }    
                            }else{
                                $('#formdatacceso input').each(function(){
                                    $(this).val("");
                                });
                                
                                $('#formdatacceso').hide('slow');
                            }
                            break;
                    }
                    
                });
                
                $('body').on('change','input.nboleto',function(){ 
                    var id=$(this).attr('id');
                    var value=$(this).val();
                    var nboletos=$('#cantidadboletos').val();
                    var totalbol=0;
                    
                    if(value>=0){
                        $('input.nboleto').each(function(){
                            if($(this).val()!==""){
                                var nb=parseFloat($(this).val());
                                totalbol+=nb;                            
                            }
                        });

                        if(totalbol>nboletos){
                            $.dialog({
                                title: 'Atención!',
                                content: 'El número de boletos en el desgloce no puede exceder de '+nboletos+'!',
                                icon: 'fa fa-exclamation-circle',
                                type: 'red',
                                typeAnimated: true,
                                backgroundDismissAnimation: 'glow',
                                boxWidth: widthjc,
                                useBootstrap: false,
                                buttons: {
                                    close: function () {                                                    
                                    }
                                }
                            });
                            $(this).val("");

                        }
                    }else{
                        $.dialog({
                            title: 'Atención!',
                            content: 'El número de boletos en el desgloce no puede ser menor de 0!',
                            icon: 'fa fa-exclamation-circle',
                            type: 'red',
                            typeAnimated: true,
                            backgroundDismissAnimation: 'glow',
                            boxWidth: widthjc,
                            useBootstrap: false,
                            buttons: {
                                close: function () {                                                    
                                }
                            }
                        });
                        $(this).val("");
                        
                    }
                });
                
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
                            var width = $(window).width();
                            if(width<=360){
                                widthjc="99%";
                            }else if(width>360 && width<=750){
                                widthjc="70%";
                            }
                            if(data.toString().indexOf("Error")!=-1 || data.toString().indexOf("error")!=-1 || data.toString().indexOf("rollback")!=-1){
                                $('#precargadiv').fadeOut('fast'); 
                                $.dialog({
                                    title: 'Atención!',
                                    content: 'Error al Realizar la Operación<BR>'+data,
                                    type: 'red',
                                    typeAnimated: true,
                                    backgroundDismissAnimation: 'glow',
                                    boxWidth: widthjc,
                                    useBootstrap: false,
                                    buttons: {
                                        close: function () {
                                        }
                                    }
                                });
                            }else{
                                $('#precargadiv').fadeOut('fast');                                 
                                var confirm=$.confirm({
                                    title: 'Operación Realizada Correctamente!',
                                    content: 'Actualizando Contenido...',
                                    type: 'green',
                                    typeAnimated: true,
                                    backgroundDismissAnimation: 'glow',
                                    boxWidth: widthjc,
                                    useBootstrap: false,
                                    autoClose: 'aceptar|1000',
                                    lazyOpen: true,
                                    buttons: {
                                        aceptar: {
                                            text: 'Actualizar',
                                            btnClass: 'btn-green',
                                            action: function () {
                                                if(reload){
                                                    location.reload();
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
                                
                //validación de campos con clase REQUIRED de un FORM ESPECIFICO
                function valida(form){
                    var valid=true;
                    
                    $(form+' input.required').each(function(){   
                        $(this).removeClass('errorstyle');
                        if($(this).val()=="" && $(this).attr('id')){
                            $(this).addClass('errorstyle');  
                            $(this).attr('placeholder','Campo Obligatorio'); 
                            valid=false;
                        }                                                
                    }); 
                    
                    $(form+' select.required').each(function(){   
                        $(this).removeClass('errorstyle');
                        if($(this).val()=="" && $(this).attr('id')){
                            $(this).addClass('errorstyle');  
                            valid=false;
                        }                        
                    }); 
                    
                    return valid;
                }
                
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
                
               $('#precargadiv').fadeOut('fast');                
            });
        </script>
        
        <!--Style Para la página especifico-->
        <style type="text/css">
        </style>
    </head>
    
    <body>
        <!-- Include del archivo Menu -->	
        <?php include ("menu.php"); ?>
        
        <!-- Contenido de la Pagina en GRID de INK -->	
        <div class="ink-grid vspace">
            <!-- Div de bloqueo para precarga de información -->
            <div id="precargadiv">
                <div id="precarga" class="" style="text-align: center;">            
                    <img src="images/cargando.gif" style=" width: 100px; height: 100px;"/><br>
                    <b>Cargando Información. Espere...</b>
                </div>	
            </div>
            
            <!--******************************Div con el contenido a mostrar al usuario (tablas, información, formularios estaticos etc.-->
            <div class="column-group">
                <div class="all-100 control-group gutters " style="text-align:center">
                    <h1 style="font-size: 2em; color: #999; margin-bottom: 15px;">Menú de Opciones</h1>

                    <a class="ink-button green push-center small-80 tiny-100 medium-70 all-50" target="_blank" href="../wp-admin/user-new.php">Activar Tarjeta</a>
                    <br>
                    <br>
                    <a class="ink-button green push-center small-80 tiny-100 medium-70 all-50"  id="abono">Abonar Saldo</a>
                    <br>
                    <br>
                    <a class="ink-button green push-center small-80 tiny-100 medium-70 all-50"  id="consulta">Consultar Saldo</a>
                    <br>
                    <br>
                    <a class="ink-button green push-center small-80 tiny-100 medium-70 all-50"  id="acceso">Acceso a Evento</a>
                </div>
            </div>            
        </div><!--Contenido-->
    </body>

</html>
