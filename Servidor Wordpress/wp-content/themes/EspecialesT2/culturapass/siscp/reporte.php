<?php
//------------CONFIGURAR LINKS------------------------------------------------------------
//config local---------------------------------
//$wpconfigurl='../../../../../wp-config.php';
//$logoutpage="http://192.168.100.92/worpress/wp-login.php?action=logout";
//$path="../wp-content/themes/twentyseventeen/culturapass/siscp/";
//$pathcontrolador="http://192.168.100.92/worpress/wp-content/libccd/ccdcontroladorsiscp.php";
//$pagina=$path."reporte.php";

//config produccion-------------------------------
$wpconfigurl='../../../../../wp-config.php';
$logoutpage="http://cultura.hidalgo.gob.mx/wp-login.php?action=logout";
$path="../wp-content/themes/EspecialesT2/culturapass/siscp/";
$pathcontrolador="http://cultura.hidalgo.gob.mx/wp-content/libccd/ccdcontroladorsiscp.php";
$pagina=$path."reporte.php";
$paginaextra="";
//
//----------------------------Procesamiento de funciones de validacion de WP para crear usuarios

global $current_user;
get_currentuserinfo();

if($current_user->ID==0){
    echo '<br><br><h2>Lo sentimos no tiene permisos para entrar a esta p&aacute;gina</h2><br><h2><a href="'.$logoutpage.'">Salir</a></h2>';
    die();
}

//------------VALIDAR PERMISOS DE USUARIO------------------------------------------------------------    
$user_info = get_userdata($current_user->ID);
$roles= implode(', ', $user_info->roles);
$validroladmin = strpos($roles, "admin_cultus");
if ($validroladmin === false) {
//    echo '<br><br><h2>Lo sentimos no tiene permisos para entrar a esta p&aacute;gina</h2><br><h2><a href="'.$logoutpage.'">Salir</a></h2>';
//    die();
}
//------------VALIDAR PERMISOS DE USUARIO------------------------------------------------------------

//------------OBTENER ID USUARIO------------------------------------------------------------
$usuariologin=$current_user->ID;

//------------DECLARACIÓN DE LAS CLASES DE CONTROL------------------------------------------------------------
require_once ('DBClass.php');
$consultasloc=new DBClass(); 
$consultasloc->to_query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';");
//
require_once ('DBClass_thinkcloud_siscp.php');
$consultastc=new DBClass_thinkcloud_SISCP(); 
$consultastc->to_query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION';");
//------------DECLARACIÓN DE LAS CLASES DE CONTROL-----------------------------------------------------------

if(isset($_GET['page'])){
    $paginaextra=$_GET['page'];
}

?>
<!DOCTYPE html>
<html lang="es">    
    <head>
        <!-- Información General del Sistema-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title>Reporte Cultura Pass</title>
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
<!--        <link rel="stylesheet" type="text/css" href="css/ink.css">
        <link rel="stylesheet" type="text/css" href="css/quick-start.css">
        <link rel="stylesheet" type="text/css" href="css/style.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.css">
        <link rel="stylesheet" type="text/css" href="css/ink-flex.min.css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css">
        
		 <link rel="stylesheet" type="text/css" href="css/style2.css"> 
        <link rel="stylesheet" type="text/css" href="css/chosen.css">
		<link href='http://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700' rel='stylesheet' type='text/css'>
        [if IE 7 ]>
            <link rel="stylesheet" href="../css/ink-ie7.css" type="text/css" media="screen" title="no title" charset="utf-8">
        <![endif]
        
        Archivo CSS de Data Tables
        <link href="datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
        
        Archivo CSS para plugin Chosen para listas desplegables 
        <link rel="stylesheet" type="text/css" href="css/chosen.css">
        
        Archivo CSS para plugin JConfirm para ventanas modales 
        <link href="css/jquery-confirm.css" rel="stylesheet" type="text/css"/>
        
        Plugin JS de INK y JQUERY (Esqueleto del funcionamiento de los sistemas)!
        <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
	<script type="text/javascript" src="js/holder.js"></script>
        <script type="text/javascript" src="js/ink.min.js"></script>
        <script type="text/javascript" src="js/ink-ui.min.js"></script>
        <script type="text/javascript" src="js/ink-all.min.js"></script>
        <script type="text/javascript" src="js/autoload.js"></script>
        
        Plugin chosen para listas desplegables!
        <script type="text/javascript" src="js/chosen.jquery.js"></script>
        
        Plugin para control de datatables!
        <script src="datatables/jquery.dataTables.js" type="text/javascript"></script>
        
        Archivo JS para plugin JConfirm para ventanas modales 
        <script src="js/jquery-confirm.js" type="text/javascript"></script>-->
                
        <!--<link href="../wp-content/libccd/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>-->
        <!--Archivos CSS de INK, y Fuentes-->  
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/ink.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/quick-start.css">
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/style.css">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/font-awesome.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/ink-flex.min.css">
        <!--<link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/font-awesome.min.css">-->
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>fontawesome/css/all.min.css">

        <script type="text/javascript" src="<?php echo $path; ?>js/holder.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>js/ink.min.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>js/ink-ui.min.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>js/ink-all.min.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>js/autoload.js"></script>
        
        <!--Librerias Jconfirm-->
        <link href="<?php echo $path; ?>css/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
        <script src="<?php echo $path; ?>js/jquery-confirm.js" ></script>
        
        <!-- Librerias Chart-->
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/Chart.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/Chart.bundle.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/samples/utils.js"></script>

        <!-- Script Principal de control de la página en general-->
        <script>
            jQuery(document).ready(function(){
                jQuery(function ($) {
                    //Página a la que se realizarán las peticiones AJAX y solicitudes de información
                    var paginaact='<?php echo $pagina; ?>';                
                    var paginacontrolador='<?php echo $pathcontrolador; ?>';                
                    var widthjc="50%";    
                    var width = $(window).width();
                    if(width<=360){
                        widthjc="99%";
                    }else if(width>360 && width<=750){
                        widthjc="70%";
                    }

                    var android=false;
                    var webbrowser='<?php echo $_SERVER['HTTP_X_REQUESTED_WITH'];?>';
                    if(webbrowser!==""){
                        android=true;
                    }
                    
                    $('#idevento').change(function(){
                        var idevento =$(this).val();
                        var url="";
                        var paginaextra="<?php echo $paginaextra; ?>";
                        if(paginaextra!==""){
                            url='?page='+paginaextra+"&idevento="+idevento;
                        }else{
                            url="?idevento="+idevento;
                        }
                        location.href=url;
                    });
                    
                    var ctx = document.getElementById("Chartsexo");
                    if(ctx!==null && ctx!==undefined){
                        ctx=ctx.getContext('2d');
                        var myChart = new Chart(ctx, {
                            type: 'doughnut',
                            data: {
                                datasets: [{
                                    data: [$('#Chartsexo').attr('M'), $('#Chartsexo').attr('H')],
                                    backgroundColor: [
                                        'rgba(255, 99, 132, 1)',
                                        'rgba(54, 162, 235, 1)',
                                    ]
                                }],

                                // These labels appear in the legend and in the tooltips when hovering different arcs
                                labels: [
                                    'Mujeres',
                                    'Hombres'
                                ]
                            }
                        });
                    }
                    
                    
                    $('.grupoedad').each(function(){
                        var ctx = $(this);
                        var ctxis = $(this).attr('id');                        
                        var gruposedad=Array();
                        gruposedad[1]="Niños";
                        gruposedad[2]="Jovenes";
                        gruposedad[3]="Adultos";
                        gruposedad[4]="Adultos Mayores";
                        if(ctx!==null && ctx!==undefined){
                            ctx=ctx.get(0).getContext('2d');
                            var myChart = new Chart(ctx, {
                                type: 'doughnut',
                                data: {
                                    datasets: [{
                                        data: [$('#'+ctxis).attr('1'), $('#'+ctxis).attr('2'), $('#'+ctxis).attr('3'), $('#'+ctxis).attr('4')],
                                        backgroundColor: [
                                            'rgba(255, 99, 132, 1)',
                                            'rgba(54, 162, 235, 1)',
                                            'rgba(153, 102, 255, 1)',
                                            'rgba(255, 159, 64, 1)'
                                        ]
                                    }],

                                    // These labels appear in the legend and in the tooltips when hovering different arcs
                                    labels: [
                                        gruposedad[1],
                                        gruposedad[2],
                                        gruposedad[3],
                                        gruposedad[4]
                                    ]
                                }
                            });
                        }
                    });
                    
                    $('#precargadiv').fadeOut('fast');    
                    
                });
            });
        </script>
        
        <!--Style Para la página especifico-->
        <style type="text/css">
        </style>
    </head>
    
    <body>
        <!-- Include del archivo Menu -->	
        
        <!-- Contenido de la Pagina en GRID de INK -->	
        <div class="ink-grid vspace">
            <!-- Div de bloqueo para precarga de información -->
           <div id="precargadiv">
                <div id="precarga" class="" style="text-align: center;">            
                    <!--<img src="<?php echo $path; ?>images/cargando.gif" style=" width: 100px; height: 100px;"/><br>-->
                    <i class="fa fa-spinner fa-spin fa-fw fa-4x"></i><br>
                    <b>Cargando Informaci&oacute;n. Espere...</b>
                </div>	
            </div>
            
            <!--******************************Div con el contenido a mostrar al usuario (tablas, información, formularios estaticos etc.-->
            <div class="column-group all-100">
                <?php if(!isset($_GET['idevento']) && $_GET['idevento']!==""){ ?>
                    <div class="control-group gutters all-100 ink-form">  
                        <label for="idevento" class="all-20">Evento:</label>
                        <div class="all-80">
                            <select class="all-95 required" id="idevento">
                                <option value="">Seleccione...</option>
                                <?php
                                    $eventoswp=$consultastc->to_query("select idevento from boletos group by idevento");
                                    while($eventowpid= mysqli_fetch_array($eventoswp)){
                                        echo '<option value="'.$eventowpid['idevento'].'">'.get_the_title($eventowpid['idevento']).'</option>'; 
                                    }
                                ?>
                                </select>
                        </div>
                    </div>
                <?php }else{ ?>
                    <div class="control-group gutters all-100 ink-form">  
                        <label for="idevento" class="all-20">Evento:</label>
                        <div class="all-80">
                            <select class="all-95 required" id="idevento">
                                <option value="">Seleccione...</option>
                                <?php
                                    $eventoswp=$consultastc->to_query("select idevento from boletos group by idevento");
                                    while($eventowpid= mysqli_fetch_array($eventoswp)){
                                        echo '<option value="'.$eventowpid['idevento'].'" ';
                                        if($eventowpid['idevento']===$_GET['idevento']){echo ' selected="true" ';}
                                        echo '>'.get_the_title($eventowpid['idevento']).'</option>'; 
                                    }
                                ?>
                                </select>
                        </div>
                    </div>
                    <br><br><br><br>
                    <div class="control-group gutters all-100 ink-form">
                        <div class="all-40">
                            <canvas id="Chartsexo" width="200" height="200" 
                            <?php     
                                $strtable="";
                                $eventoswp=$consultastc->to_query("select (case sexo when 'H' then 'Hombres' else 'Mujeres' end) as sexostr,sexo, sum(utilizados) as cantidad from boletos where idevento='".$_GET['idevento']."' group by sexo ");
                                while($eventowpid= mysqli_fetch_array($eventoswp)){
                                    echo $eventowpid['sexo'].'="'.$eventowpid['cantidad'].'" ';
                                    $strtable.='<tr><td>'.$eventowpid['sexostr'].'</td><td>'.$eventowpid['cantidad'].'</td></tr>';
                                }
                            ?>
                            ></canvas>
                        </div>
                        <div class="all-40 left-space">
                            <table class="ink-table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Asistentes Por Sexo</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $strtable; ?>
                                </tbody>
                            </table>
                        </div>                    
                    </div>
                    <div class="control-group gutters all-100 ink-form top-space">
                        <div class="all-40">
                            <canvas id="Chartgrupoedadh" class="grupoedad" width="200" height="200" 
                            <?php     
                                $strtable="";
                                $eventoswp=$consultastc->to_query("SELECT idgrupoedad,grupoedad,sum(utilizados) as cantidad FROM boletos join grupos_edad using(idgrupoedad) where idevento='".$_GET['idevento']."' and sexo='H' group by idgrupoedad,sexo ");
                                while($eventowpid= mysqli_fetch_array($eventoswp)){
                                    echo $eventowpid['idgrupoedad'].'="'.$eventowpid['cantidad'].'" ';
                                    $strtable.='<tr><td>'.$eventowpid['grupoedad'].'</td><td>'.$eventowpid['cantidad'].'</td></tr>';
                                }
                            ?>
                            ></canvas>
                        </div>
                        <div class="all-40 left-space">
                            <table class="ink-table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Asistentes Por Grupo de Edad Hombres</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $strtable; ?>
                                </tbody>
                            </table>
                        </div>  
                    </div>
                    <div class="control-group gutters all-100 ink-form top-space">
                        <div class="all-40">
                            <canvas id="Chartgrupoedadm" class="grupoedad" width="200" height="200" 
                            <?php     
                                $strtable="";
                                $eventoswp=$consultastc->to_query("SELECT idgrupoedad,grupoedad,sum(utilizados) as cantidad FROM boletos join grupos_edad using(idgrupoedad) where idevento='".$_GET['idevento']."' and sexo='M' group by idgrupoedad,sexo ");
                                while($eventowpid= mysqli_fetch_array($eventoswp)){
                                    echo $eventowpid['idgrupoedad'].'="'.$eventowpid['cantidad'].'" ';
                                    $strtable.='<tr><td>'.$eventowpid['grupoedad'].'</td><td>'.$eventowpid['cantidad'].'</td></tr>';
                                }
                            ?>
                            ></canvas>
                        </div>
                        <div class="all-40 left-space">
                            <table class="ink-table">
                                <thead>
                                    <tr>
                                        <th colspan="2">Asistentes Por Grupo de Edad Mujeres</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php echo $strtable; ?>
                                </tbody>
                            </table>
                        </div>  
                    </div>
                    
                <?php } ?>
            </div>            
        </div><!--Contenido-->
    </body>

</html>
