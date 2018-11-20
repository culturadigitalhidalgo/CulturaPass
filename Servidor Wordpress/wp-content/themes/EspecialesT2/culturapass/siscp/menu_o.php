<?php 
    //Extracción del Token de Sesion del Sistema
    $tokenSystem=$consultas->gettokensystem();
    
//    if((!isset($_SESSION[$tokenSystem]))||($_SESSION[$tokenSystem]==false))
//    {
//        header("Location: index.php");
//        exit;
//    }    
?>	  
<div class="muestraHead">
    <img src="images/header.jpg" />
</div>
    <header class="ink-grid vspace">
<!--        <div class="column-group">
            <h2 style="font-size: 2em;">Subsecretaría de Innovación y Emprendimiento Cultural</h2>
            <div class="all-100">
                <div class="all-50"><h5 style="margin:0;"><?php //echo $consultas->getnamesystem(); ?></h5></div>
                <div class="all-50" style="text-align: right;">
                    <h5 style="margin:0;">
                    </h5>                
                </div>
            </div>
            
        </div>   
        -->
    </header>
    <div id="topbar">
        <nav class="ink-navigation ink-grid show-all">            
            <ul class="menu horizontal flat institucional">
<!--                <li>
                    <a href="index.php">Bienvenido</a>
                </li>	-->
                <?php if($_SESSION['privilegiosculturamgsa']==1 && ($_SESSION['idusuarioculturamgsa']!=12 && $_SESSION['idusuarioculturamgsa']!=10)){ 
                    //Menú para privilegios =1; (Programar a petición del Usuario.
                    ?>
                    <!-- CATÁLOGOS -->
                    <li>
                        <a href="#">Catálogos <i class="fa fa-caret-down"></i></a>
                        <ul class="submenu" style="width: 230px;"> 
                            <li>
                                <a href="estados.php">Estados</a>
                            </li>             
                            <li>
                                <a href="municipios.php">Municipios</a>
                            </li>         
                            <li>
                                <a href="localidades.php">Localidades</a>
                            </li>         
                            <li>
                                <a href="privilegios.php">Privilegios Usuarios</a>
                            </li> 
                            <li>
                                <a href="escolaridad.php">Escolaridad</a>
                            </li> 
                                
                            <li>
                                <a href="ingredientes.php">Ingredientes</a>
                            </li>        
                            <li>
                                <a href="adqingredientes.php">Modo Adquirir Ingredientes</a>
                            </li>        
                            <li>
                                <a href="tecnicastradicion.php">Técnicas Tradicionales</a>
                            </li>        
                            <li>
                                <a href="plangasto.php">Planes de Gasto</a>
                            </li>        
                            <li>
                                <a href="tipoactividades.php">Tipos de Actividades</a>
                            </li>        
                            <li>
                                <a href="tipoartesanias.php">Tipos de Artesanias</a>
                            </li>        
                            <li>
                                <a href="artesanoap.php">Aprendizajes Artesanos</a>
                            </li>        
                            <li>
                                <a href="parentescoasist.php">Parentescos Acompañantes</a>
                            </li>        
                                   
                        </ul>
                    </li> 
                    <!-- Opciones -->
<!--                    <li>
                        <a href="#">Menu2 <i class="fa fa-caret-down"></i></a>
                        <ul class="submenu" style="width: 250px;">                        
                             Estructura Programática 
                            <li>
                                <a href="#">opcion 1</a>
                            </li>

                        </ul>
                    </li> -->
                    <!-- Configuración -->
                    <li>
                        <a href="#">Administración <i class="fa fa-caret-down"></i></a>
                        <ul class="submenu">                 
                            <li>
                                <a href="cocineros.php">Cocineros</a>
                            </li>
                            <li>
                                <a href="usuarios.php">Usuarios</a>
                            </li>
                            <li>
                                <a href="jueces.php">Jueces</a>
                            </li>
                            <li>
                                <a href="configuracion.php">Configuración</a>
                            </li>   
                        </ul>
                    </li>
                    <li>
                        <a href="#">Reportes <i class="fa fa-caret-down"></i></a>
                        <ul class="submenu" style="width:200px;">                 
                            <li>
                                <a href="reportes2017.php">Año 2017</a>
                            </li>
                            <li>
                                <a href="reportes2018.php">Año 2018</a>
                            </li>   
                            <li>
                                <a href="registros.php">Reigistros por Día</a>
                            </li> 
                            <li>
                                <a href="registros2.php">Reigistros Total</a>
                            </li>
                            <li>
                                <a href="registros3.php">Comparativo 2017 - 2018</a>
                            </li> 
                            <li>
                                <a href="encuestadoresreporte.php">Reporte Encuestadores</a>
                            </li>
                        </ul>
                    </li>
                    
                    <li>
                        <a href="#">Calificaciones <i class="fa fa-caret-down"></i></a>
                        <ul class="submenu">                 
                            <li>
                                <a href="calificaciones.php?categoria=1">Platillos</a>
                            </li>
                            <li>
                                <a href="calificaciones.php?categoria=2">Postres</a>
                            </li>   
                            <li>
                                <a href="calificaciones.php?categoria=3">Bebidas</a>
                            </li>
                            <li>
                                <a href="calificaciones.php?categoria=4">Pulques</a>
                            </li>   
                        </ul>
                    </li>
                    <li>
                        <a href="#">Descarga de encuestas <i class="fa fa-caret-down"></i></a>
                        <ul class="submenu">                 
                            <li>
                                <a href="descargas/encuestacocineros_2018.xlsx">Cocineras platillo y bebidas</a>
                            </li>
                            <li>
                                <a href="descargas/encuestaartesanos_2018.xlsx">Artesanos</a>
                            </li>
                            <li>
                                <a href="descargas/encuestaasistentes_2018.xlsx">Asistentes</a>
                            </li>
                            
                        </ul>
                    </li>
                <?php } else if($_SESSION['privilegiosculturamgsa']==2){ 
                    //Menú para privilegios ==2s; (Programar a petición del Usuario.) Pueden agregarse menús dependiento de la validación de $_SESSION['privilegiossighosegcultura']
                    ?>
                <li>
                    <a href="inicio.php">Precaptura</a>
                </li>
                <li>
                    <a href="jueces.php">Jueces</a>
                </li>
            <?php } else if($_SESSION['privilegiosculturamgsa']>2 &&$_SESSION['privilegiosculturamgsa']<6){ 
                    //Menú para privilegios ==2s; (Programar a petición del Usuario.) Pueden agregarse menús dependiento de la validación de $_SESSION['privilegiossighosegcultura']
                    ?>
                <li>
                    <a href="inicio.php">Encuesta</a>
                </li>
             <?php } else if($_SESSION['idusuarioculturamgsa']==10 || $_SESSION['idusuarioculturamgsa']==12){ 
                    //Menú para privilegios ==2s; (Programar a petición del Usuario.) Pueden agregarse menús dependiento de la validación de $_SESSION['privilegiossighosegcultura']
                    ?>
                <li>
                    <a href="reportes2017.php">Reporte 2017</a>
                </li>
                <li>
                    <a href="reportes2018.php">Reporte 2018</a>
                </li>
                <li>
                    <a href="registros.php">Registros por día 2018</a>
                </li>
                <li>
                    <a href="registros2.php">Registros Totales 2018</a>
                </li>
                <li>
                    <a href="registros3.php">Comparativo 2017 - 2018</a>
                </li>
                <li>
                    <a href="jueces.php">Jueces</a>
                </li>
                <li>
                    <a href="encuestadoresreporte.php">Reporte Encuestadores</a>
                </li>
                <li>
                        <a href="#">Calificaciones <i class="fa fa-caret-down"></i></a>
                        <ul class="submenu">                 
                            <li>
                                <a href="calificaciones.php?categoria=1">Platillos</a>
                            </li>
                            <li>
                                <a href="calificaciones.php?categoria=2">Postres</a>
                            </li>   
                            <li>
                                <a href="calificaciones.php?categoria=3">Bebidas</a>
                            </li>
                            <li>
                                <a href="calificaciones.php?categoria=4">Pulques</a>
                            </li>   
                        </ul>
                </li>
                <li>
                    <a href="#">Descarga de encuestas <i class="fa fa-caret-down"></i></a>
                    <ul class="submenu">                 
                        <li>
                            <a href="descargas/encuestacocineros_2018.xlsx">Cocineras platillo y bebidas</a>
                        </li>
                        <li>
                            <a href="descargas/encuestaartesanos_2018.xlsx">Artesanos</a>
                        </li>
                        <li>
                            <a href="descargas/encuestaasistentes_2018.xlsx">Asistentes</a>
                        </li>
                        
                    </ul>
                </li>
                
            <?php } 
                //(Programar a petición del Usuario.) Pueden agregarse menús dependiento de la validación de $_SESSION['privilegiossighosegcultura']?>
                
                <!-- Opción para todos los menús -->
                <li>
                    <a href="fin.php"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                </li>
            </ul>            
        </nav>            
        <div class="border">
        </div>
    </div>
