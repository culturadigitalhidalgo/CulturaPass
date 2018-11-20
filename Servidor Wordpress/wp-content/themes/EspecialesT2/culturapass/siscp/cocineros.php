<?php
//plantilla V4.0
    //Declaración del Objeto $consultas de la Clase controladora DBClass.php necesaria para el control de funciones del Sistema
    include_once 'DBClass.php';
    $consultas = new DBClass();
    
    //Extracción del Token de Sesion del Sistema
    $tokenSystem=$consultas->gettokensystem();
    
    //año de la muestra  para referencia de guardado de datos
    $aniomuestra=$consultas->getaniomuestra();
    
    //default 0 domingo ->select; 6 sabado-> platillo
    $diasemana = date("w");
//    $diasemana = 6;
    $defaultplatillo=0;
    if($diasemana==6){
        $defaultplatillo="1";
    }else{
        $defaultplatillo="";
    }
    
                        /***********************Configuración****************************/
    //Recuperar la pagina que esta apuntano el script
    $pagina=$_SERVER['PHP_SELF'];
    $paginaarray=explode('/', $pagina);
    $selfpag=array_pop($paginaarray);
    
    //Varibles Globales del Archivo (pueden ser omitidas), optimizadas para catálogos solo cambiar nombre de tabla y el ID de la misma.
    $tablabase="cocineros";
    $idbase="idcocinero";
    $paginabase=$selfpag;
    
    //Variables Globales del Archivo (pueden ser omitidas) texto desplegado en los formularios de catálogos
    $textoencabezado="Cocineros";
    $textoencabezadoforms="Cocinero";
    
    //Variables para obtención de información en grid data table
    $camposrs="idcocinero as IDCocinero, esa_no_part as 'Número de Participante', esa_nom as Nombre, esa_ap_p as 'Apellido Paterno', esa_ap_m as 'Apellido Materno', estado as Estado, municipio as Municipio,  localidad as Localidad, descorigen as 'Descripción Origen'";
    $tablars=$tablabase." c left join localidades l on l.idlocalidad=c.idlocalidad and l.idmunicipio=c.idmunicipio and l.idestado=c.idestado"
            . " left join municipios m on m.idmunicipio=c.idmunicipio and m.idestado=c.idestado left join estados e on e.idestado=c.idestado left join encuestacocineros_".$aniomuestra." using(idcocinero)";
    $wherers="1";
    $idaccion="IDCocinero";
    
    //Variables para generación de formularios y almacen de datos $campos['Nombre_campo']="aray de atributos";
    $atribs['tipo']="texto";
    $atribs['label']="Nombre";
    $atribs['obligatorio']=true;                
    $campos['esa_nom']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Apellido Paterno";
    $atribs['obligatorio']=true; 
    $campos['esa_ap_p']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Apellido Materno";
    $atribs['obligatorio']=false; 
    $campos['esa_ap_m']=$atribs;
    unset($atribs);
    $atribs['tipo']="date";
    $atribs['label']="Fecha de Nacimiento";
    $atribs['obligatorio']=false; 
    $campos['esa_nac']=$atribs;
    unset($atribs);
    $atribs['tipo']="select2";
    $atribs['label']="Género";
    $atribs['obligatorio']=true;                
    $atribs['camposselect']="1^Hombre¬2^Mujer";            
    $atribs['defaultselect']='';                
    $campos['esa_gen']=$atribs;
    unset($atribs);
    $atribs['tipo']="select2";
    $atribs['label']="Pais";
    $atribs['obligatorio']=true;                
    $atribs['camposselect']="MX^México¬OTR^Otro";            
    $atribs['defaultselect']='';                
    $campos['pais']=$atribs;
    unset($atribs);
    $atribs['tipo']="select";
    $atribs['label']="Estado";
    $atribs['obligatorio']=true;                
    $atribs['camposselect']="idestado,estado";                
    $atribs['tablaselect']='estados';                
    $atribs['whereselect']='1';                
    $atribs['defaultselect']='';                
    $campos['idestado']=$atribs;
    unset($atribs);
    $atribs['tipo']="select";
    $atribs['label']="Municipio";
    $atribs['obligatorio']=true;                
    $atribs['camposselect']="idmunicipio,municipio";                
    $atribs['tablaselect']='municipios';                
    $atribs['whereselect']='0';                
    $atribs['defaultselect']='';                
    $campos['idmunicipio']=$atribs;
    unset($atribs);
    $atribs['tipo']="select";
    $atribs['label']="Localidad";
    $atribs['obligatorio']=false;                
    $atribs['camposselect']="idlocalidad,localidad";                
    $atribs['tablaselect']='localidades';                
    $atribs['whereselect']='0';                
    $atribs['defaultselect']='';  
    $atribs['noselecttext']="NR/NA";
    $campos['idlocalidad']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Colonia - Barrio";
    $atribs['obligatorio']=false; 
    $campos['colonia']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Descripción Domicilio";
    $atribs['obligatorio']=true; 
    $campos['descorigen']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Calle";
    $atribs['obligatorio']=false; 
    $campos['calle']=$atribs;    
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Número exterior";
    $atribs['obligatorio']=false; 
    $campos['noext']=$atribs;    
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Número Interior";
    $atribs['obligatorio']=false; 
    $campos['noint']=$atribs;    
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Código Postal";
    $atribs['obligatorio']=false; 
    $campos['cp']=$atribs;    
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Teléfono Fijo";
    $atribs['obligatorio']=false; 
    $campos['telefono']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Celular";
    $atribs['obligatorio']=false; 
    $campos['celular']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Email";
    $atribs['obligatorio']=false; 
    $campos['email']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Otro";
    $atribs['obligatorio']=false; 
    $campos['otrocontact']=$atribs;
    unset($atribs);
    
    
    
    //formulario de modificacion platillo y califs
    $atribs['tipo']="number";
    $atribs['label']="No. Participante";
    $atribs['obligatorio']=true; 
    $camposm['esa_no_part']=$atribs;
    unset($atribs);
    $atribs['tipo']="select2";
    $atribs['label']="Categoría a la cual se inscribe";
    $atribs['obligatorio']=true;                
    $atribs['camposselect']="1^Platillo¬2^Postre¬3^Bebida¬4^Pulque";            
    $atribs['defaultselect']=$defaultplatillo;                
    $camposm['esa_plat_cat']=$atribs;
    unset($atribs);
    $atribs['tipo']="texto";
    $atribs['label']="Nombre del Platillo";
    $atribs['obligatorio']=true; 
    $camposm['esa_plat_name']=$atribs;
    unset($atribs);
    $atribs['tipo']="divisor";
    $atribs['label']="Calificación";
    $camposm['divcalif']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Sazón";
    $atribs['obligatorio']=true; 
    $camposm['calif_sazon']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Presentación del Platillo";
    $atribs['obligatorio']=true; 
    $camposm['calif_presentacion']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Atuendo tradicional";
    $atribs['obligatorio']=true; 
    $camposm['calif_atuendo']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Elaboración tradicional";
    $atribs['obligatorio']=true; 
    $camposm['calif_elaboracion']=$atribs;
    unset($atribs);
    $atribs['tipo']="number";
    $atribs['label']="Expliación del Proceso";
    $atribs['obligatorio']=true; 
    $camposm['calif_expliacion']=$atribs;
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
            if(isset($_POST[$key]) && $_POST[$key]!==""){
                $data[$key] = $_POST[$key];
            }
        }
        
        
        //Guardado de información en la tabla declarada en la variable global $tablabase y la información en forma de Array $data
        if(($insertcocinero = $consultas->to_insert_trans("cocineros", $data))===false){
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
        
    //Procesamiento del POST para guardar información 
       
    //Procesamiento del POST para eliminar información 
    if(isset($_POST['delete'])){
        //Validador de la transacción
        $valid=true;
        
        //inicio de la transaccion de guardado
        $consultas->to_query("begin;");
        
        //ejecución de "Delete" en la BD en la tabla declarada en la variable global $tablabase y el $idbase junto al POST recibido con ID a eliminar   
        if(($delete = $consultas->to_delete_trans($tablabase,$idbase."='".$_POST['delete']."' "))===false){
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
            if(isset($_POST[$key]) && $_POST[$key]!==""){
                $data[$key] = $_POST[$key];
            }else{
                $data[$key] = 'null';
            }
        }
                  
        //Guardado de información en la tabla declarada en la variable global $tablabase y la información en forma de Array $data 
        if(($update = $consultas->to_update_trans($tablabase, $data, $idbase."='".$_POST['update']."'"))===false){
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
    if(isset($_POST['updateplat'])){
        //Validador de la transacción
        $valid=true;
        
        //inicio de la transaccion de guardado
        $consultas->to_query("begin;");
        
        //obtención de variables POST y guardado en forma de Array $data; los nombres de los campos estan definidos en la configuración del array $campos
//        foreach($campos as $key=>$value){
//            if(isset($_POST[$key]) && $_POST[$key]!==""){
//                $data[$key] = $_POST[$key];
//            }else{
//                $data[$key] = 'null';
//            }
//        }
             
        $datacalif['calif_sazon']=$_POST['calif_sazon'];
        $datacalif['calif_presentacion']=$_POST['calif_presentacion'];
        $datacalif['calif_atuendo']=$_POST['calif_atuendo'];
        $datacalif['calif_elaboracion']=$_POST['calif_elaboracion'];
        $datacalif['calif_expliacion']=$_POST['calif_expliacion'];
        
        //Guardado de información en la tabla declarada en la variable global $tablabase y la información en forma de Array $data 
        if(($update = $consultas->to_update_trans("calificaciones_".$aniomuestra, $datacalif, "idcocinero='".$_POST['updateplat']."' and etapa='".$_POST['etapa']."'"))===false){
            $valid=false;
            echo 'Error al procesar la información<br>';
        }
        
        $dataplat['esa_no_part']=$_POST['esa_no_part'];
        $dataplat['esa_plat_name']=$_POST['esa_plat_name'];
        $dataplat['esa_plat_cat']=$_POST['esa_plat_cat'];
        
        //Guardado de información en la tabla declarada en la variable global $tablabase y la información en forma de Array $data 
        if(($update = $consultas->to_update_trans("encuestacocineros_".$aniomuestra, $dataplat, "idcocinero='".$_POST['updateplat']."'"))===false){
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
        
    $usuariologin=$_SESSION['idusuariocultura'.$consultas->gettokensystemclass()];
    $privilegioslogin=$_SESSION['privilegioscultura'.$consultas->gettokensystemclass()];
    
    if($privilegioslogin!=1){
        header("Location: inicio.php");        
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
        foreach($camposm as $key=>$value){           
            $dominput=$consultas->obtener_plantilla($value['tipo'], $key, $value,false);
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
                                        $('#FormAgrega input, #FormAgrega select').each(function(){
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
                                                        
                            $('#pais').val('MX').change();
                        }
                    });
                });                    
                               
                //Mostrar Advertencia de Eliinacion de Registro
                $('#informacion').on('click','a.eliminar',function(e){
                    e.preventDefault();  
                    //capturar id-accion del evento que solicitó la modificación
                    var id= $(this).attr('id-accion');    
                                        
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
                    
                    //arreglo variables que recolectarán la iformación de la BD actual
                    var variables = Array(); 
                           
                    //realizar peticion de datos para recuperar información actual
                    var infoData = new FormData();
                    infoData.append('obtener_info',"single");
                    infoData.append('campos','*');
                    infoData.append('tabla','<?php echo $tablabase;?>');
                    infoData.append('where','<?php echo $idbase;?>='+id);
                    //Vaciado de la información actual
                    $.each(obtener_info(infoData,true), function(key, value){ 
                        $.each(value,function(index,data){
                            variables[index]=data;
                        });
                    });
                    
                    //crear Formulario de Actualización
                    $.confirm({
                        title: 'Modificar <b><?php echo $textoencabezadoforms; ?></b>',
                        content: '<?php echo trim($formadd); ?>',
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
                            $('#FormAgrega input, #FormAgrega select').each(function(){
                                $(this).val(variables[$(this).attr('id')]).change(); 
                            });
                        },
                        buttons: {
                            formSubmit: {
                                text: 'Aceptar',
                                btnClass: 'btn-green',
                                action: function () {
                                    if(!valida("#FormAgrega")){
                                        return false;
                                    }else{     
                                        //formatear datos para enviar por POST
                                        var formData = new FormData();
                                        formData.append('update',id);
                                        
                                        //obtención de información 
                                        $('#FormAgrega input, #FormAgrega select').each(function(){
                                            formData.append($(this).attr('id'),$(this).val());
                                        });
                                                                                
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
                
                //Mostrar Form para Modificar                
                //Mostrar Form para Modificar   calif              
                $('#informacion').on('click','a.modifcalif',function(e){
                    e.preventDefault();  
                    //capturar id-accion del elemento que dispoaró el evento                    
                    var id = $(this).attr('id-accion'); 
                    var etapa = $(this).attr('etapa'); 
                    
                    //arreglo variables que recolectarán la iformación de la BD actual
                    var variables = Array(); 
                           
                    //realizar peticion de datos para recuperar información actual
                    var infoData = new FormData();
                    infoData.append('obtener_info',"single");
                    infoData.append('campos','*');
                    infoData.append('tabla','calificaciones_<?php echo$aniomuestra;?>');
                    infoData.append('where','<?php echo $idbase;?>='+id+" and etapa="+etapa);
                    //Vaciado de la información actual
                    $.each(obtener_info(infoData,true), function(key, value){ 
                        $.each(value,function(index,data){
                            variables[index]=data;
                        });
                    });
                    
                    var infoData = new FormData();
                    infoData.append('obtener_info',"single");
                    infoData.append('campos','esa_no_part,esa_plat_name,esa_plat_cat');
                    infoData.append('tabla','encuestacocineros_<?php echo$aniomuestra;?>');
                    infoData.append('where','<?php echo $idbase;?>='+id);
                    //Vaciado de la información actual
                    $.each(obtener_info(infoData,true), function(key, value){ 
                        $.each(value,function(index,data){
                            variables[index]=data;
                        });
                    });
                    
                    //crear Formulario de Actualización
                    $.confirm({
                        title: 'Modificar <b>Datos del Platillo</b>',
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
                            $('#FormModifica input, #FormModifica select').each(function(){
                                $(this).val(variables[$(this).attr('id')]).change(); 
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
                                        //validar no participante solo si cambió
                                        if($('#esa_no_part').val()!==variables['esa_no_part']){
                                            var validano_part=0;
                                            var infoDataq = new FormData();
                                            infoDataq.append('obtener_info',"single");
                                            infoDataq.append('campos','count(*) as validafolio');
                                            infoDataq.append('tabla','<?php echo 'encuestacocineros_'.$aniomuestra;?>');
                                            infoDataq.append('where','esa_no_part='+$('#esa_no_part').val());
                                            //Vaciado de la información actual
                                            $.each(obtener_info(infoDataq,true), function(key, value){ 
                                                validano_part=this.validafolio;
                                            });

                                            if(validano_part!=0){
                                                $.dialog({
                                                    title: 'Atención!',
                                                    content: 'El No. de Participante se encuentra Capturado!',
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
                                                return false;
                                            }                                        
                                        }
                                        
                                        //formatear datos para enviar por POST
                                        var formData = new FormData();
                                        formData.append('updateplat',id);
                                        formData.append('etapa',etapa);
                                        
                                        //obtención de información 
                                        $('#FormModifica input, #FormModifica select').each(function(){
                                            formData.append($(this).attr('id'),$(this).val());
                                        });
                                                                                
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
                
                //Mostrar Form para Modificar                
                
                
                /********************Controlar cambios de change de un select**********************/
                $('body').on('change','select',function(){
                    var id=$(this).attr('id');
                    var value=$(this).val();
                    
                    switch(id){
                        case 'pais':
                            $('#idestado').removeClass('errorstyle').attr('placeholder','');
                            $('#idmunicipio').removeClass('errorstyle').attr('placeholder','');
                            $('#idlocalidad').removeClass('errorstyle').attr('placeholder','');  
                            $('#colonia').removeClass('errorstyle').attr('placeholder','');  
                            $('#descorigen').removeClass('errorstyle').attr('placeholder','');  
                            
                            if(value==='MX'){
                                $('#descorigen').val('');
                                $('#divdescorigen').hide('slow');
                                $('#descorigen').removeClass('required');
                                $('#dividestado').show('slow');
                                $('#dividmunicipio').show('slow');
                                $('#dividlocalidad').show('slow');
                                $('#divcolonia').show('slow');
                                $('#idestado').addClass('required');
                                $('#idmunicipio').addClass('required');
                                
                                $('#idestado').val(13).change();
                                $('#idmunicipio').val('055').change();
                                $('#idlocalidad').val('0001').change();
                            }else{              
                                $('#descorigen').val('');                  
                                $('#divdescorigen').show('slow');
                                $('#descorigen').addClass('required');
                                $('#dividestado').hide('slow');
                                $('#dividmunicipio').hide('slow');
                                $('#dividlocalidad').hide('slow');
                                $('#divcolonia').hide('slow');
                                $('#idestado').val("").change();
                                $('#idestado').removeClass('required');
                                $('#idmunicipio').removeClass('required');
                                
                            }

                            break;
                        case 'idestado':
                            if(value==13){
                                $('#descorigen').val('');
                                $('#divdescorigen').hide('slow');
                                $('#descorigen').removeClass('required');
                                $('#dividmunicipio').show('slow');
                                $('#dividlocalidad').show('slow');
                                $('#divcolonia').show('slow');
                                $('#idmunicipio').addClass('required');
                                
                                $('#idestado').val(13);
                                
                                var idedo = $(this).val();
                                var formData = new FormData();
                                formData.append('obtenerselect'," idmunicipio,municipio  ");
                                formData.append('tabla','municipios');
                                formData.append('where',"idestado='"+idedo+"' order by municipio");
                                //procesar información

                                $('#idmunicipio').html('<option value="">Seleccione Municipio...</option>'+obtener_info(formData,false));
                                
                                $('#idmunicipio').val('055').change();
                                $('#idlocalidad').val('0001').change();
                            }else{                 
                                $('#descorigen').val('');               
                                $('#divdescorigen').show('slow');
                                $('#descorigen').addClass('required');
                                $('#idmunicipio').val("").change();
                                $('#dividmunicipio').hide('slow');
                                $('#dividlocalidad').hide('slow');
                                $('#divcolonia').hide('slow');
                                $('#idmunicipio').removeClass('required');
                            }

                            break;
                        case 'idmunicipio':
                            var idedo = $('#idestado').val();
                            var idmun = $('#idmunicipio').val();
                            var idloc = $('#idlocalidad').val();
                            var formData = new FormData();
                            formData.append('obtenerselect'," idlocalidad,localidad");
                            formData.append('tabla','localidades');
                            formData.append('where',"idestado='"+idedo+"' and idmunicipio='"+idmun+"' order by localidad");
                            //procesar información

                            $('#idlocalidad').html('<option value="">NA/NR</option>'+obtener_info(formData,false));
                            
                            if(idloc==="055"){
                                $('#idlocalidad').val('0001').change();
                            }

                            break;   
                    }
                });
                
                
                
                $('body').on('change','input',function(){
                    var id=$(this).attr('id');
                    var value=$(this).val();
                    
                    switch(id){
                        case 'calif_sazon':
                            if(value<0 || value>100){
                                $.dialog({
                                    title: 'Atención!',
                                    content: 'La calificación de Sazón no puede ser mayor a 100 ni menor a 0!',
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
                                $(this).val("");
                            }
                            break;
                        case 'calif_presentacion':
                            if(value<0 || value>100){
                                $.dialog({
                                    title: 'Atención!',
                                    content: 'La calificación de Presentación del Platillo no puede ser mayor a 100 ni menor a 0!',
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
                                $(this).val("");
                            }
                            break;
                        case 'calif_atuendo':
                            if(value<0 || value>100){
                                $.dialog({
                                    title: 'Atención!',
                                    content: 'La calificación de Atuendo tradicional no puede ser mayor a 100 ni menor a 0!',
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
                                $(this).val("");
                            }
                            break;
                        case 'calif_elaboracion':
                            if(value<0 || value>100){
                                $.dialog({
                                    title: 'Atención!',
                                    content: 'La calificación de Elaboración tradicional no puede ser mayor a 100 ni menor a 0!',
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
                                $(this).val("");
                            }
                            break;
                        case 'calif_expliacion':
                            if(value<0 || value>100){
                                $.dialog({
                                    title: 'Atención!',
                                    content: 'La calificación de Expliación del Proceso no puede ser mayor a 100 ni menor a 0!',
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
                                $(this).val("");
                            }
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
                                confirm.buttons.aceptar.hide('slow');
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
                                            if($row[$key]===NULL || $row[$key]==="" || is_null($row[$key])){
                                                echo '<td>---</td>';
                                            }else{
                                                echo '<td>'.$row[$key].'</td>';
                                            }
                                        }
                                        //impresión de los botones de acción modificar y eliminar
                                        echo '<td style="width:50px; min-width:50px; text-align:right;">';                                       
                                        $validacal=0;
                                        $validacalificaciones=$consultas->obtener_datos_campos("count(*) as ncalif", "calificaciones_".$aniomuestra, "idcocinero=".$row[$idaccion]." and etapa=1");
                                        while ($validacalificacion=mysql_fetch_array($validacalificaciones)){
                                            $validacal=$validacalificacion['ncalif'];
                                        }
                                        
                                        if($validacal>0){
                                            echo '<a id-accion="'.$row[$idaccion].'" etapa="1" class="modifcalif"><span class="fa fa-book" title="Modificar Calificaciones 1era Etapa"></span></a> ';
                                        }
                                        
                                        $validacal=0;
                                        $validacalificaciones=$consultas->obtener_datos_campos("count(*) as ncalif", "calificaciones_".$aniomuestra, "idcocinero=".$row[$idaccion]." and etapa=2");
                                        while ($validacalificacion=mysql_fetch_array($validacalificaciones)){
                                            $validacal=$validacalificacion['ncalif'];
                                        }
                                        
                                        if($validacal>0){
                                            echo '<a id-accion="'.$row[$idaccion].'" etapa="2" class="modifcalif"><span class="fa fa-list" title="Modificar Calificaciones 2da Etapa"></span></a> ';
                                        }
                                        
                                        $validacal=0;
                                        $validacalificaciones=$consultas->obtener_datos_campos("count(*) as ncalif", "calificaciones_".$aniomuestra, "idcocinero=".$row[$idaccion]." and etapa=3");
                                        while ($validacalificacion=mysql_fetch_array($validacalificaciones)){
                                            $validacal=$validacalificacion['ncalif'];
                                        }
                                        
                                        if($validacal>0){
                                            echo '<a id-accion="'.$row[$idaccion].'" etapa="3" class="modifcalif"><span class="fa fa-th-list" title="Modificar Calificaciones 3era Etapa"></span></a> ';
                                        }
                                        
                                        echo ' <a id-accion="'.$row[$idaccion].'" class="modificar"><span class="fa fa-pencil-square-o" title="Modificar"></span></a> 
                                            <a id-accion="'.$row[$idaccion].'" class="eliminar"><span class="fa fa-trash-o" title="Eliminar"></span></a>
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
