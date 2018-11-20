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
    <link href="../wp-content/themes/EspecialesT2/culturapass/siscp/datatables/jquery.dataTables.css" rel="stylesheet" type="text/css"/>
    <script src="../wp-content/themes/EspecialesT2/culturapass/siscp/datatables/jquery.dataTables.js" ></script>

    <script src="../wp-content/themes/EspecialesT2/culturapass/siscp/datatables/dataTables.buttons.min.js" type="text/javascript"></script>
        <script src="../wp-content/themes/EspecialesT2/culturapass/siscp/datatables/jszip.min.js" type="text/javascript"></script>
        <script src="../wp-content/themes/EspecialesT2/culturapass/siscp/datatables/pdfmake.min.js" type="text/javascript"></script>
        <script src="../wp-content/themes/EspecialesT2/culturapass/siscp/datatables/vfs_fonts.js" type="text/javascript"></script>
        <script src="../wp-content/themes/EspecialesT2/culturapass/siscp/datatables/buttons.html5.min.js" type="text/javascript"></script>
        <script src="../wp-content/themes/EspecialesT2/culturapass/siscp/datatables/buttons.print.min.js" type="text/javascript"></script>
        <script>
        jQuery(document).ready(function(){
            jQuery(function ($) {
                //Configuración de la tabla DataTables para muestreo de información                              
                var table = $('.informacion').dataTable( {  
                    dom: 'Bfrtip',
                    buttons: [
                       {
                           extend: 'copy',
                           text: 'Copiar'
                       },
                       {
                           extend: 'csv',
                           text: 'CSV'
                       },
                       {
                           extend: 'excel',
                           text: 'EXCEL'
                       },
                       {
                           extend: 'pdf',
                           text: 'PDF'
                       },
                       {
                           extend: 'print',
                           text: 'Imprimir'
                       }
                    ],  
                    "oLanguage": {
                        "sSearch": "Buscar:",
                        "sInfoEmpty": "No existen resultados para mostrar",
                        "sInfoFiltered": " (filtrado de _MAX_ registros en total)",
                        "sLoadingRecords": "Por favor espere - cargando...",
                        "sZeroRecords": "No existen registros para mostrar",
                        "sEmptyTable": "No existe informaci&oacute;n en la tabla",
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
                $('#precargadiv').fadeOut('fast');
            });
        });
        </script>
        
        <style>
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
            
            .boxevento{
                clear: left;
                width:100%;
                margin:10px;
            }
        </style>
        
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
        
       
        
        echo '<div class="boxevento" registrado="'.$registrado.'" cupo="'.$evento['cupo'].'" id-evento="'.$evento['ID'].'" userid="'.$current_user->ID.'" hora="'.$evento['hora'].'" horamostrar="'.substr($evento['hora'],0,5).'" fecha="'.$evento['fecha'].'" fechamostrar="'.substr($evento['fecha'],6,2).'/'.substr($evento['fecha'],4,2).'/'.substr($evento['fecha'],0,4).'">' ;
            echo "<b>".$evento['post_title'].'</b><br>';
            echo "Fecha: <b>".substr($evento['fecha'],6,2).'/'.substr($evento['fecha'],4,2).'/'.substr($evento['fecha'],0,4).'</b><br>';
            echo "Hora: <b>".substr($evento['hora'],0,5).'</b>';
            if($nregistros>=$evento['cupo']){
                echo '<br><br><span  style="background-color:red; color:white; padding: 5px;border-radius: 5px;">Evento Lleno!</span>';
            }   
            
            echo '<table class="informacion"><thead><tr><th>Nombre</th><th>Apellidos</th><th>Email</th></tr></thead><tbody>';
             $listaasistentes=$consultastc->to_query(" select * from preregistros where "
                . "idevento=".$evento['ID']." and fechaevento ='".$evento['fecha']."' and horaevento='".$evento['hora']."' ");
            while($asistentes=mysqli_fetch_array($listaasistentes)){
                //$registrado= floatval($validregistro['registrado']);
                echo '<tr>';
                echo '<td>'.$consultasloc->obtener_por_id("wp_usermeta", "user_id","'".$asistentes['idusuario']."' and meta_key='first_name'" ,"meta_value").'</td>';
                echo '<td>'.$consultasloc->obtener_por_id("wp_usermeta", "user_id","'".$asistentes['idusuario']."' and meta_key='last_name'" ,"meta_value").'</td>';
                echo '<td>'.$consultasloc->obtener_por_id("wp_users", "ID","'".$asistentes['idusuario']."'" ,"user_email").'</td>';
                echo '</tr>';
            }
            
        echo'</tbody></table></div>';
    }

?>

 <div id="precargadiv">
    <div id="precarga" class="" style="text-align: center;">            
        <img src="../wp-content/themes/EspecialesT2/culturapass/siscp/images/cargando.gif" style=" width: 100px; height: 100px;"/><br>
        <b>Cargando Informaci&oacute;n. Espere...</b>
    </div>	
</div>


