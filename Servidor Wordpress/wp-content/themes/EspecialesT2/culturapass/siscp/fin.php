<?php
     //Declaración del Objeto $consultas de la Clase controladora DBClass.php necesaria para el control de funciones del Sistema
    include_once 'DBClass.php';
    $consultas = new DBClass(); 
    
    //Extracción del Nombre del Sistema
    $nameSystem=$consultas->getnamesystem();
    
    //Extracción del Token de Sesion del Sistema
    $tokenSystem=$consultas->gettokensystem();
    
    //Validación de SESION
    session_start();
    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set('Mexico/General');    
    
    if((!isset($_SESSION[$tokenSystem]))||($_SESSION[$tokenSystem]==false))
    {
        //header("Location: index.php");        
        //exit;
    }   
    
    //destruir sesion
    $consultas->destruirSesion();

?>
<!DOCTYPE html>
<html>
    <head>
	<!-- Información General del Sistema-->
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title><?php echo $nameSystem; ?></title>
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
                
        <!-- Script Principal de control de la página en general-->
        <script>
            $(document).ready(function(){  
               $('#precargadiv').fadeOut('fast');                
            });
        </script>
        
        <style type="text/css">
            html, body {
                height: 100%;
                background: #f0f0f0;
            }
            .wrap {
                min-height: 100%;
                height: auto !important;
                height: 100%;
                margin: 0 auto -80px;
                overflow: auto;
            }
            .push, footer { 
                height: 80px; 
                margin-top: 0; 
            }
            footer { 
                background: rgba(10,10,10,0.95); 
                border: 0; 
                line-height: 80px; 
                margin-top: 0 !important; 
            }
            footer * { 
                line-height: inherit; 
            }
            footer p { 
                margin-top: 0; 
            }
            footer .ink-navigation ul.menu.horizontal li { 
                margin-right: 2em; 
                line-height: inherit; 
            }
            footer .ink-navigation ul.menu.horizontal li a {
                padding: 0;
                color: white;
                text-decoration: underline;
            }
            footer p {
                color: white;
            }
            footer .ink-navigation ul.menu.horizontal li a:hover {
                color: #c91111;
            }
            .top-menu {
                background: #000;
            }
            .cta {
                font-size: 1.8em;
                margin-left: 0;
            }
            #topbar { 
                background: #be1c1c;
				/*margin-top:1em;*/
            } 
            button#toggleVisibility { 
                background:none; 
                border: none; 
                outline: none; 
                position: absolute; 
                top: .6em; right: 0; 
                padding: 0; 
                color: #bbbbbb; 
            }			
        </style>
    </head>
    <body>
<!--        <div class="muestraHead">
            
    <img src="images/header.jpg" />
</div>-->
        <header class="ink-grid vspace">
        <div class="column-group">
            <h2 style="font-size: 2em;">Subsecretaría de Innovación y Emprendimiento Cultural</h2>
            <div class="all-100">
                <div class="all-50"><h5 style="margin:0;"><?php //echo $consultas->getnamesystem(); ?></h5></div>
                <div class="all-50" style="text-align: right;">
                    <h5 style="margin:0;">
                    </h5>                
                </div>
            </div>
            
        </div>   
        
    </header>
        <div id="topbar">
            <nav class="ink-navigation ink-grid show-all">
                <ul class="menu horizontal flat institucional">   
                    <li>
                        <a href="index.php"><i class="fa fa-sign-in"></i> Ingresar nuevamente</a>
                    </li>
                </ul>
            </nav>  
            <div class="border">
            </div>
        </div>    
        <!-- Contenido -->	
        <div class="ink-grid vspace">
            <!-- Div de bloqueo para precarga de información -->
            <div id="precargadiv">
                <div id="precarga" class="" style="text-align: center;">            
                    <img src="images/cargando.gif" style=" width: 100px; height: 100px;"/><br>
                    <b>Cargando Información. Espere...</b>
                </div>	
            </div>
            <div class="column-group">
                <div class="all-100">
                    <br>
                    <h2>Su sesión ha finalizado correctamente.</h2>
                    <br>
                    <!--<h5>La Dirección de planeación a través de la Subdirección de Información proporciona este sistema para........</h5>-->
                </div>
            </div>
        </div>
        <div class="push"></div>
    </body>
</html>
