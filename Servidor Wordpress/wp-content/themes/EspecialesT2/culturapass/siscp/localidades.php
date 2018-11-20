<?php
//plantilla V4.0
    //Declaración del Objeto $consultas de la Clase controladora DBClass.php necesaria para el control de funciones del Sistema
    include_once 'DBClass.php';
    $consultas = new DBClass();
    
    //Extracción del Token de Sesion del Sistema
    $tokenSystem = $consultas->gettokensystem();
    
                        /***********************Configuración****************************/
    //Recuperar la pagina que esta apuntano el script
    $pagina=$_SERVER['PHP_SELF'];
    $paginaarray=explode('/', $pagina);
    $selfpag=array_pop($paginaarray);
    
    //Varibles Globales del Archivo (pueden ser omitidas), optimizadas para catálogos solo cambiar nombre de tabla y el ID de la misma.
    $tablabase="localidades";
    $idbase="idlocalidad";
    $paginabase=$selfpag;
    
    //Variables Globales del Archivo (pueden ser omitidas) texto desplegado en los formularios de catálogos
    $textoencabezado="Localidades";
    $textoencabezadoforms="Localidad";
    
    //Variables para obtención de información en grid data table
    $camposrs="estados.idestado as IDEstado, estado as Estado, municipios.idmunicipio as IDMunicipio, municipio as Municipio, idlocalidad as IDLocalidad, localidad as Localidad";
    $tablars=$tablabase." join municipios on municipios.idmunicipio= localidades.idmunicipio and municipios.idestado = localidades.idestado join estados on estados.idestado = municipios.idestado";
    $wherers="1";
    $idaccion="IDLocalidad";
    
    //Variables para generación de formularios y almacen de datos $campos['Nombre_campo']="aray de atributos";
    $atribs['tipo']="select";
    $atribs['label']="Estado";
    $atribs['obligatorio']=true;                
    $atribs['camposselect']='idestado,estado';                
    $atribs['tablaselect']='estados';                
    $atribs['whereselect']='1';                
    $atribs['defaultselect']='13';                
    $campos['idestado']=$atribs;
    unset($atribs);
    $atribs['tipo']="select";
    $atribs['label']="Municipio";
    $atribs['obligatorio']=true;                
    $atribs['camposselect']='idmunicipio,municipio';                
    $atribs['tablaselect']='municipios';                
    $atribs['whereselect']='0';                
    $atribs['defaultselect']='';                
    $campos['idmunicipio']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="IDLocalidad";
    $atribs['obligatorio']=true; 
    $campos['idlocalidad']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Localidades";
    $atribs['obligatorio']=true; 
    $campos['localidad']=$atribs;
    unset($atribs);
                            /***********************Configuración****************************/
        
    //Procesamiento del POST para guardar información 
    if(isset($_POST['save'])){
        //Validador de la transacción
        $valid=true;
        
        //inicio de la transaccion de guardado
        $consultas->to_query("begin;");
        
        //obtención de variables POST y guardado en forma de Array $data; los nombres de los campos estan definidos en la configuración del array $campos
        foreach($campos as $key=>$value){
            $data[$key] = $_POST[$key];
        }
                
        //Guardado de información en la tabla declarada en la variable global $tablabase y la información en forma de Array $data
        if(($insert = $consultas->to_insert_trans($tablabase, $data))===false){
            $valid=false;
            echo 'Error al procesar la información<br>';
        }
        
        if($valid==true){
            $consultas->to_query("commit;");
            echo "commit";      
        }else{
            $consultas->to_query("rollback;");  
            echo "rollback"; 
        }
        die();
    }
    
    //Procesamiento del POST para eliminar información 
    if(isset($_POST['delete'])){
        //Validador de la transacción
        $valid=true;
        
        //inicio de la transaccion de guardado
        $consultas->to_query("begin;");
        
        //ejecución de "Delete" en la BD en la tabla declarada en la variable global $tablabase y el $idbase junto al POST recibido con ID a eliminar   
        if(($delete = $consultas->to_delete_trans($tablabase,$idbase."='".$_POST['delete']."' and idestado='".$_POST['idestado']."' and idmunicipio='".$_POST['idmunicipio']."'"))===false){
            $valid=false;
            echo 'Error al procesar la información<br>';
        }
        
        if($valid==true){
            $consultas->to_query("commit;");
            echo "commit";      
        }else{
            $consultas->to_query("rollback;");  
            echo "rollback"; 
        }
        die();
    }
    
    //Procesamiento del POST para actualizar información 
    if(isset($_POST['update'])){
        //Validador de la transacción
        $valid=true;
        
        //inicio de la transaccion de guardado
        $consultas->to_query("begin;");
        
        //obtención de variables POST y guardado en forma de Array $data; los nombres de los campos estan definidos en la configuración del array $campos
        foreach($campos as $key=>$value){
            $data[$key] = $_POST[$key];
        }
                  
        //Guardado de información en la tabla declarada en la variable global $tablabase y la información en forma de Array $data 
        if(($update = $consultas->to_update_trans($tablabase, $data, $idbase."='".$_POST['update']."' and idestado='".$_POST['idestadoo']."' and idmunicipio='".$_POST['idmunicipioo']."'"))===false){
            $valid=false;
            echo 'Error al procesar la información<br>';
        }
        
        if($valid==true){
            $consultas->to_query("commit;");
            echo "commit";      
        }else{
            $consultas->to_query("rollback;");  
            echo "rollback"; 
        }
        die();
    }
    
    //Función de procesamiento para obtener información de una tabla por transacción AJAX return JSON con la información de la misma.
        
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
    
    //Función de procesamiento para obtener información de una tabla por transacción AJAX return codigo HTML con la información para crear elementos OPTION de un SELECT 
    if(isset($_POST['obtenerselect'])){
        echo $data = $consultas->obtener_select_data($_POST['obtenerselect'],$_POST['tabla'],$_POST['where']); 
        die();
    } 
	
    //Validación de SESION
    session_start();
    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set('Mexico/General');
    if((!isset($_SESSION[$tokenSystem]))||($_SESSION[$tokenSystem]==false))
    {
        header("Location: index.php");
        $consultas->destruirSesion();
        exit;
    }   
        
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
    
    $buscari=array("%_ancholabel_%", "%_anchocampo_%");
    $reemplazari=array($ancholabel, $anchocampo);
    
    //anchos de los formularios
    $anchoformadd='600px';
    $anchoformupdate='600px';
    
    //formulario de agregar
    $formadd='<form id="FormAgrega" class="ink-form all-100 content-center" action="" method="post">';
        foreach($campos as $key=>$value){           
            $dominput=$consultas->obtener_plantilla($value['tipo'], $key, $value,false);
            $formadd.=str_ireplace($buscari,$reemplazari,$dominput);
        }
    $formadd.='</form>';
    
    //formulario Editar
    $formupdate='<form id="FormModifica" class="ink-form all-100 content-center" action="" method="post">';
        foreach($campos as $key=>$value){           
            $dominput=$consultas->obtener_plantilla($value['tipo'], $key, $value,true);
            $formupdate.=str_ireplace($buscari,$reemplazari,$dominput);
        }
    $formupdate.='</form>';
 
    //formateo de las cadenas de los formularios definidos por el usuario a una cadena serializada.(NO MODIFICAR)
    $buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
    $reemplazar=array("", "", "", "");
    $formadd=str_ireplace($buscar,$reemplazar,$formadd);
    $formupdate=str_ireplace($buscar,$reemplazar,$formupdate);
?>
<!DOCTYPE html>
<html lang="en">    
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
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/ink-flex.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        		
        <!--[if IE 7 ]>
            <link rel="stylesheet" href="../css/ink-ie7.css" type="text/css" media="screen" title="no title" charset="utf-8">
        <![endif]-->
        
        <!--Archivo CSS de Data jquery confirm-->
        <link rel="stylesheet" href="css/jquery-confirm.min.css">
        
        <!--Archivo CSS de Data Tables-->
        <link href="datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        
        <!--Archivo CSS para plugin Chosen para listas desplegables -->
        <!--<link rel="stylesheet" type="text/css" href="css/chosen.css">-->
        
        <!--Plugin JS de INK y JQUERY (Esqueleto del funcionamiento de los sistemas)!-->
        <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/holder.js"></script>
        <script type="text/javascript" src="js/ink.min.js"></script>
        <script type="text/javascript" src="js/ink-ui.min.js"></script>
        <script type="text/javascript" src="js/ink-all.min.js"></script>
        <script type="text/javascript" src="js/autoload.js"></script>
        
        <!--Plugin chosen para listas desplegables!-->
        <!--<script type="text/javascript" src="js/chosen.jquery.js"></script>-->
        
        <!--Plugin jquery confirm para el control y creacion de formularios y alertas modales!-->
        <script src="js/jquery-confirm.min.js" type="text/javascript"></script>
        
        <!--Plugin para control de datatables!-->
        <script src="datatables/jquery.dataTables.js" type="text/javascript"></script>
                
        <!-- Script Principal de control de la página en general-->
        <script>
            $(document).ready(function(){
                //Página a la que se realizarán las peticiones AJAX y solicitudes de información
                var paginaact='<?php echo $paginabase; ?>';
                
                //Configuración de la tabla DataTables para muestreo de información                              
                var table = $('#informacion').dataTable( {  
                    "oLanguage": {
                        "sSearch": "Buscar:",
                        "sInfoEmpty": "No existen resultados para mostrar",
                        "sInfoFiltered": " (filtrado de _MAX_ registros en total)",
                        "sLoadingRecords": "Por favor espere - cargando...",
                        "sZeroRecords": "No existen registros para mostrar",
                        "sEmptyTable": "No existe información en la tabla",
                        "sProcessing": "Procesando...",
                        "sLengthMenu": 'Ver <select>'+
                        '<option value="10">10</option>'+
                        '<option value="25">25</option>'+
                        '<option value="50">50</option>'+
                        '<option value="100">100</option>'+
                        '</select> Registros',
                        "sInfo": "Mostrando _START_ - _END_ de _TOTAL_ registros",
                        "oPaginate": {
                            "sPrevious": "Anterior",
                            "sNext": "Siguiente"
                          }
                      }
                } );
                                
                //***************Control de las funciones de la página**********************//
                
                //Insertar Nuevo Registro
                $('#agregar').click(function(){
                    $.confirm({
                        title: 'Agregar <b><?php echo $textoencabezadoforms; ?></b>',
                        content: '<?php echo trim($formadd); ?>',
                        typeAnimated: true,
                        backgroundDismissAnimation: 'glow',
                        boxWidth: '<?php echo $anchoformadd; ?>',
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
                                        formData.append('save','true');
                                        
                                        //obtener los input junto con sus valores para agregarlos a la petición
                                        $('#FormAgrega input,#FormAgrega select').each(function(){
                                            formData.append($(this).attr('id'),$(this).val());
                                        });
                                        
                                        //bloquear boton para evitar multiples envios de información
                                        this.$$formSubmit.prop('disabled', 'disabled');
                                        
                                        //procesar petición
                                        senddata(formData,true);                                        
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
                            
                            //change inicial del id estado para cargar jurisdicciones
                            $('#idestado').change();
                        }
                    });
                });                    
                               
                //Mostrar Advertencia de Eliinacion de Registro
                $('#informacion').on('click','a.eliminar',function(e){
                    e.preventDefault();  
                    //capturar id-accion del evento que solicitó la modificación
                    var id= $(this).attr('id-accion');  
                    var idestado=$(this).attr('idestado'); 
                    var idmunicipio=$(this).attr('idmunicipio'); 
                                        
                    $.confirm({                            
                        title: 'Atención!',
                        content: '¿Deseas eliminar el registro?',
                        type: 'red',
                        typeAnimated: true,
                        backgroundDismissAnimation: 'glow',
                        boxWidth: '400px',
                        useBootstrap: false,
                        escapeKey: 'cancel',
                        buttons: {                                
                            confirm: {
                                text: 'Eliminar',
                                btnClass: 'btn-red',
                                action: function(){
                                    //formato de la información a enviar por POST
                                    var formData = new FormData();
                                    formData.append('delete',id);
                                    formData.append('idestado',idestado);
                                    formData.append('idmunicipio',idmunicipio);
                                    
                                    //bloquear boton para evitar multiples envios de información
                                    this.$$confirm.prop('disabled', 'disabled');
                                        
                                    //procesar información
                                    senddata(formData,true);
                                }
                            },
                            cancel: {
                                text: 'Cancelar',
                                btnClass: 'btn-red',
                                action: function(){
                                    //close
                                }
                            }
                        }
                    });                     
                });
               
                //Mostrar Form para Modificar                
                $('#informacion').on('click','a.modificar',function(e){
                    e.preventDefault();  
                    //capturar id-accion del elemento que dispoaró el evento                    
                    var id = $(this).attr('id-accion'); 
                    var idestado=$(this).attr('idestado'); 
                    var idmunicipio=$(this).attr('idmunicipio'); 
                            
                    //arreglo variables que recolectarán la iformación de la BD actual
                    var variables = Array(); 
                           
                    //realizar peticion de datos para recuperar información actual
                    var infoData = new FormData();
                    infoData.append('obtener_info',"single");
                    infoData.append('campos','*');
                    infoData.append('tabla','<?php echo $tablabase;?>');
                    infoData.append('where','<?php echo $idbase;?>='+id+" and idestado='"+idestado+"' and idmunicipio='"+idmunicipio+"'");
                    //Vaciado de la información actual
                    $.each(obtener_info(infoData,true), function(key, value){ 
                        $.each(value,function(index,data){
                            variables[index]=data;
                        });
                    });
                    
                    //crear Formulario de Actualización
                    $.confirm({
                        title: 'Modificar <b><?php echo $textoencabezadoforms; ?></b>',
                        content: '<?php echo trim($formupdate); ?>',
                        typeAnimated: true,
                        backgroundDismissAnimation: 'glow',
                        boxWidth: '<?php echo $anchoformupdate; ?>',
                        useBootstrap: false,
                        escapeKey: 'cancel',
                        onContentReady: function () {
                            // bind to events
                            var jc = this;
                            this.$content.find('form').on('submit', function (e) {
                                // if the user submits the form by pressing enter in the field.
                                e.preventDefault();
                                jc.$$formSubmit.trigger('click'); // reference the button and click it
                            });
                            
                            //vaciar la información de la BD al formulario de actualización
                            $('#FormModifica input,#FormModifica select').each(function(){
                                $(this).val(variables[$(this).attr('id').slice(0,-1)]).change(); 
                            });
                        },
                        buttons: {
                            formSubmit: {
                                text: 'Aceptar',
                                btnClass: 'btn-green',
                                action: function () {
                                    if(!valida("#FormModifica")){
                                        return false;
                                    }else{     
                                        //formatear datos para enviar por POST
                                        var formData = new FormData();
                                        formData.append('update',id);
                                        
                                        //obtención de información 
                                        $('#FormModifica input,#FormModifica select').each(function(){
                                            formData.append($(this).attr('id').slice(0,-1),$(this).val());
                                        });
                                        formData.append("idestadoo",idestado);
                                        formData.append("idmunicipioo",idmunicipio);
                                        
                                        //bloquear boton para evitar multiples envios de información
                                        this.$$formSubmit.prop('disabled', 'disabled');
                                        
                                        //Procesar solicitud Update
                                        senddata(formData,true);                                                 
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
                        }
                    });                   
                });
                
                /********************Controlar cambios de change de un select**********************/
                $('body').on('change','select',function(){
                    var id=$(this).attr('id');
                    var value=$(this).val();
                    
                    switch(id){
                        case 'idestado':
                            var formData = new FormData();
                            formData.append('obtenerselect',"idmunicipio,concat(idmunicipio,' ',municipio) as municipio");
                            formData.append('tabla','municipios');
                            formData.append('where',"idestado='"+value+"'");
                            //procesar información
                            
                            $('#idmunicipio').html('<option value="">Seleccione Municipio...</option>'+obtener_info(formData,false));
                            
                            break;
                        case 'idestadom':
                            var formData = new FormData();
                            formData.append('obtenerselect',"idmunicipio,concat(idmunicipio,' ',municipio) as municipio");
                            formData.append('tabla','municipios');
                            formData.append('where',"idestado='"+value+"'");
                            //procesar información
                            
                            $('#idmunicipiom').html('<option value="">Seleccione...</option>'+obtener_info(formData,false));
                            
                            break;
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
                            if(data.toString().indexOf("Error")!=-1 || data.toString().indexOf("error")!=-1 || data.toString().indexOf("rollback")!=-1){
                                $('#precargadiv').fadeOut('fast'); 
                                $.dialog({
                                    title: 'Atención!',
                                    content: 'Error al Realizar la Operación<BR>'+data,
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
                                    title: 'Operación Realizada Correctamente!',
                                    content: 'Actualizando Contenido...',
                                    type: 'green',
                                    typeAnimated: true,
                                    backgroundDismissAnimation: 'glow',
                                    boxWidth: '600px',
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
                
                //Ocultar Div de Precarga (Pantalla de bloqueo inicial)
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
            
            <!-- Div de bloqueo para precarga y carga de información -->
            <div id="precargadiv">
                <div id="precarga" class="" style="text-align: center;">            
                    <img src="images/cargando.gif" style=" width: 100px; height: 100px;"/><br>
                    <b>Cargando Información. Espere...</b>
                </div>	
            </div>
            
            <!--******************************Div con el contenido a mostrar al usuario (tablas, información, formularios estaticos etc.-->
            <div class="column-group">
                <div class="all-100" style="text-align: center; font-size: 22px; margin-top: 10px;">
                    <?php echo $textoencabezado; ?>
                </div>
                <div class="all-100">
                    <table id="informacion" class="condensed-300">
                        <?php
                            //Ejecutar Query con la configuración de campos, tablas y condiciones configuradas
                            $data=$consultas->obtener_datos_campos($camposrs,$tablars,$wherers);
                        ?>
                        <thead>
                            <tr class="nohov">  
                                <?php
                                    //obtener numero de campos configurados
                                    $numberfields = mysql_num_fields($data);
                                    //declaración del arreglo para almacenar los campos y fetchear resultados
                                    $camposresult="";
                                    //impresión de campos para cabeceras de la tabla y asignación del arreglo de campos
                                    for ($i=0; $i<$numberfields ; $i++ ) {
                                        $fieldname = mysql_field_name($data, $i);
                                        echo '<th>'.$fieldname.'</th>';     
                                        $camposresult[$fieldname]=$fieldname;
                                    }
                                ?>  
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php                                
                                //fetcheo de datos de la consulta configurada
                                while ($row = mysql_fetch_array($data)){
                                    echo '<tr>';
                                        //fetcheo de datos con base a los nombres recuperados en el arreglo $camposresult
                                        foreach($camposresult as $key=>$value){
                                            echo '<td>'.$row[$key].'</td>';
                                        }
                                        //impresión de los botones de acción modificar y eliminar
                                        echo '<td style="width:50px; min-width:50px; text-align:right;">
                                            <a id-accion="'.$row[$idaccion].'" idestado="'.$row['IDEstado'].'" idmunicipio="'.$row['IDMunicipio'].'" class="modificar"><span class="fa fa-pencil-square-o" title="Modificar"></span></a> 
                                            <a id-accion="'.$row[$idaccion].'" idestado="'.$row['IDEstado'].'" idmunicipio="'.$row['IDMunicipio'].'" class="eliminar"><span class="fa fa-trash-o" title="Eliminar"></span></a>
                                        </td>
                                    </tr>';
                                }
                            ?>                            
                        </tbody>
                    </table>
                </div>
                
                <!--Desplegar botones de acción en caso de ser necesarios.-->
                <div class="all-100">
                    <button id="agregar" class="ink-button green">Agregar</button>
                    <!--<button id="xlsx" class="ink-button red ">XLSX</button>-->
<!--                    <button id="deltable" class="ink-button red ">Borrar Contenido</button>-->
                </div>
            </div>
            <!--FIN Div con el contenido a mostrar al usuario (tablas, información, formularios estaticos etc.-->
            
            <!--*************************************Elementos a mostrar dinamicos (formularios en ventanas modal, advertencias, estados de carga, etc.)-->
            
            <!--Elemento emergente (Gif de carga de información al guardar, actualizar, elminar, etc)-->
            <div id="carga" class="" >            
                <img src="images/cargando.gif" style=" width: 100px; height: 100px;"/>
            </div>
            <!--Elemento emergente (Mensaje que despliega información de status después de guardar, actualizar, elminar, etc) en forma de alerta-->
            <div id="mensajes" class="ink-alert basic alerta" role="alert">            
                <p id="mensaje"></p>
            </div>

            <div class="push"></div>

            <!--Elemento emergente (Formulario en ventana modal para guardar información configurado por el usuario)-->
            
            <!--Elemento emergente (Formularios o vemntanas modales que necesite el usuario para dar avisos oc ontrolar eventos)-->
            <div id="divFormmodal" >
                <div class="ink-shade fade">
                    <div id="Formmodal" class="ink-modal" data-trigger="#openmodal" data-width="360px" data-height="170px">
                        <div class="modal-body">
                            <h4 id="etiquetadel" style="margin-bottom:0px;">¿Titulo?</h4>
                        </div>
                        <div class="modal-footer">
                            <button class="ink-button red" id="ok" id-accion="">Aceptar</button>
                            <button class="ink-button red ink-dismiss">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div> <!--FIN Form Modal-->
            
            <!--FIN Elementos a mostrar dinamicos (formularios en ventanas modal, advertencias, estados de carga, etc.)-->
            
        </div><!--FIN Contenido-->
    </body>

</html>
