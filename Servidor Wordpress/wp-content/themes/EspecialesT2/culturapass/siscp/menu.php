<?php 
    //Extracción del Token de Sesion del Sistema
    $tokenSystem=$consultas->gettokensystem();
    
//    if((!isset($_SESSION[$tokenSystem]))||($_SESSION[$tokenSystem]==false))
//    {
//        header("Location: index.php");
//        exit;
//    }    
?>	  
<!--<div class="muestraHead">
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
                    <a href="#"> Cutura Pass</a>
                </li>
                
                <li>
                    <a href="fin.php"><i class="fa fa-sign-out"></i> Cerrar Sesión</a>
                </li>
            </ul>     
            
            
        </nav>            
        <div class="border">
        </div>
    </div>
