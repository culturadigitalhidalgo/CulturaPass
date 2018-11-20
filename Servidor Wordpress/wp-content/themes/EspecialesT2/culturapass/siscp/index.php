<?php
//plantilla v4.0
    //Declaración del Objeto $consultas de la Clase controladora DBClass.php necesaria para el control de funciones del Sistema 
    include_once 'DBClass.php';
    $consultas = new DBClass();
    
    //Extracción del Token de Sesion del Sistema
    $tokenSystem=$consultas->gettokensystem();

    //Proceso de validación de inicio de sesion
    if(isset($_POST['verifica']))
    {
        $usuario = $_POST["usuario"];
        $claveplana = $_POST["clave"];
        echo $consultas->verificar_WPUsr($usuario, $claveplana);
        die();
    }
    
    //Validación de SESION
    session_start();
    header("Content-Type: text/html;charset=utf-8");
    date_default_timezone_set('Mexico/General');
    if((!isset($_SESSION[$tokenSystem]))||($_SESSION[$tokenSystem]==false))
    {
       
    }  else{
        header("Location: inicio.php");
    } 
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"> 
        <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
        <title>
            <?php echo $consultas->getnamesystem(); ?>
        </title>
        <meta name="description" content="Muestra Gastronómica Santiago de Anaya 2018" />
        <meta name="keywords" content="Muestra, Gastronómica, Santiago de Anaya 2018" />
        <link rel="stylesheet" type="text/css" href="loginfiles/css/style.css" />
        <link rel="stylesheet" href="css/jquery-confirm.min.css">
        
        <script src="loginfiles/js/modernizr.custom.63321.js"></script>  
        <script src="js/jquery-3.2.1.min.js" type="text/javascript"></script>
        <script src="js/jquery-confirm.min.js" type="text/javascript"></script>
        <!--[if lte IE 7]><style>.main{display:none;} .support-note .note-ie{display:block;}</style><![endif]-->
        <script type="text/javascript">
            function validar()
            {
                var usuario = $('#usuario').val();
                var pass = $('#clave').val();
                var estado;
                $('#error').html("");
                if ((usuario ==="") || (pass==="")){
                    $.dialog({
                        title: 'Atención!',
                        content: '<b>Debes introducir correctamente tu usuario y clave!</b>',
                        type: 'red',
                        typeAnimated: true,
                        backgroundDismissAnimation: 'glow',
                        boxWidth: '400px',
                        useBootstrap: false,
                        buttons: {
                            close: function () {
                            }
                        }
                    });
                    //alert("Debes introducir correctamente tu usuario y clave!");
                }
                        
                else
                {

                    $.ajaxSetup({ async: false });
                    $.post("index.php", { usuario:usuario, clave:pass, verifica:true}, function(data){
                            //alert(data);
                        estado=data.trim();                        
                        if (estado === "Login")
                        {
                            window.open('inicio.php', '_self', false);
                            return true;
                        }else if(estado==="SIN PERMISOS"){
                            $.dialog({
                                title: 'Atención!',
                                content: '<b>Acceso NO Autorizado!</b> <br> El Usuario ya no tiene permisos para entrar a este sistema.',
                                type: 'red',
                                typeAnimated: true,
                                backgroundDismissAnimation: 'glow',
                                boxWidth: '400px',
                                useBootstrap: false,
                                buttons: {
                                    close: function () {
                                    }
                                }
                            });
                            //alert("Acceso NO Autorizado! - El Usuario ya no tiene permisos para entrar a este sistema.");
                        }
                        else
                        {
                            $.dialog({
                                title: 'Atención!',
                                content: '<b>Acceso NO Autorizado!</b> <br> Verifica tu Usuario y contraseña e intenta de nuevo.',
                                type: 'red',
                                typeAnimated: true,
                                backgroundDismissAnimation: 'glow',
                                boxWidth: '400px',
                                useBootstrap: false,
                                buttons: {
                                    close: function () {
                                    }
                                }
                            });
                            //alert("Acceso NO Autorizado! - Verifica tu Usuario y contraseña e intenta de nuevo.");
                        }
                    });
                    $.ajaxSetup({ async: true });
                }
            }

        </script>
<style>
    table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 50%;
    }

    td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
    }

    tr:nth-child(even) {
        background-color: #dddddd;
    }
</style>

    </head>
    <body>
        <div class="container">
            <header>
                <!--<img class="" src="images/pag_en_construccion2.png" width="25%" height="100%"/>-->
                <h1><strong><?php echo $consultas->getnamesystem(); ?></strong> </h1>
                <!--<img class="" src="images/header.jpg" width="45%" height="100%"/>-->
                <br>
                <br>
                <h1><b>Secretaría de Cultura</b></h1>                
                <h2>Subsecretaría de Innovación y Emprendimiento Cultural </h2>                
            </header>
            <section class="main">
                <?php   ?>
                <form class="form-1">
                    <p class="field">
                        <input type="text" id="usuario" name="usuario" placeholder="Usuario">
                        <i class="icon-user icon-large"></i>
                    </p>
                    <p class="field">
                        <input type="password" id="clave" name="clave" placeholder="Clave">
                        <i class="icon-lock icon-large"></i>
                    </p>
                    <p class="submit">
                        <button type="submit" name="ingresar" onclick="validar();return false;"><i class="icon-arrow-right icon-large"></i></button>
                    </p>
                </form>
                <br>
<!--                <center>
                    <table>
                        <tr>
                            <th>Usuario</th>
                            <th>Clave</th>
                            <th>Encuesta</th>
                        </tr>
                        <tr>
                            <td>encocinero1</td>
                            <td>123</td>
                            <td>Encuestador Cocineros</td>
                        </tr>
                        <tr>
                            <td>enartesanos1</td>
                            <td>123</td>
                            <td>Encuestador Artesanos</td>
                        </tr>
                        <tr>
                            <td>enasistentes1</td>
                            <td>123</td>
                            <td>Encuestador Asistentes</td>
                        </tr>
                    </table>                
                </center>-->
                <br><br>
                <h2 style="font-size: 16px; font-weight: bold; font-family: Cambria, Georgia, serif; text-align: center; color: #666; text-shadow: 0 1px 1px rgba(255,255,255,0.6);">Se recomienda el uso de Google Chrome para el correcto funcionamiento del sistema.</h2>
            </section>
            <!--<center><img class="" src="images/pag_en_construccion2.png" width="25%" height="100%"/></center>-->
        </div>
    </body>
</html>