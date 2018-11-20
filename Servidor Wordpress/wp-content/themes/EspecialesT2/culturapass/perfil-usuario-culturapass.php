<?php
$path="../wp-content/themes/EspecialesT2/culturapass/siscp/";
global $current_user;
get_currentuserinfo();

$user_info = get_userdata($current_user->ID);

?>        
        <!-- Librerias Chart-->
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/ink.css">
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/Chart.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/Chart.bundle.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/samples/utils.js"></script>
        <link rel="stylesheet" href="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/siscp/epack/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/siscp/epack/css/elements/tabs.css">
        <link rel="stylesheet" href="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/siscp/epack/css/elements/buttons.css">
<style type="text/css">
    .principal{
        /*background-image: url('http://cultura.hidalgo.gob.mx/wp-content/plugins/form_user_cultuspass/assets/fondo.png');*/
        width:100%;
        padding: 0 0 36% 0;
        background:url('http://cultura.hidalgo.gob.mx/wp-content/plugins/form_user_cultuspass/assets/fondo.png') no-repeat top;
        background-size:100% auto;
        font-family: Graphik;
    }
</style>
 <div class="principal">
 <center><a class="tcb-animate-a tcb-success" href="http://cultura.hidalgo.gob.mx/wp-login.php?action=logout">Cerrar sesión</a></center>
 <br>
    <section class="sec-spacer sec-color">
        <div class="container container-center">
            <div class="row">
                <div class="col-md-7">
                    <h3 class="title"><?php echo $user_info->first_name.' '.$user_info->last_name; ?> <span class="badge">Bienvenido</span></h3>
                    <div class="tc-tabs-style4">
                        <ul class="nav nav-tabs">
                            <li class="active"><a data-toggle="tab" href="#tab16">Perfil</a></li>
                            <li><a data-toggle="tab" href="#tab17">Promociones</a></li>
                            <li><a data-toggle="tab" href="#tab18">Eventos</a></li>
                        </ul>
                        <div class="tab-content">
                            <div id="tab16" class="tab-pane fade in active">
                                <div class="row">
                                    <div class="col-md-8">
                                        
<?php
include('http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/phpqrcode/qrlib.php'); 
$file = 'qrcode.png'; 
$data = get_the_author_meta( 'cp_id_culturapass', $user_info->ID ); 
//QRcode::png($data, $file, QR_ECLEVEL_L, 5, 1); 
echo '<div style="background: url(http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/T02.png) no-repeat; background-size: 350px 200px;"><img style="width: 70px; padding-top: 60px; margin-left: 253px;" src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/'.$file.'"/><span style="padding-top: 0px; margin-left: 267px; color: black; font-size: 10px;">'.$data.'</span><br><br><br><br><br><br></div>';
?>
<!--                                        <img src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/T01.png">-->
                                    </div>
                                    <div class="col-md-4">
                                        <h3 class="tc-tab-title">Perfil</h3>
                                        <p class="tc-tab-desc">
                                            <b>Email:</b> <?php echo $user_info->user_email; ?>
                                            <br>
                                            <b>Usuario:</b> <?php echo $user_info->user_nicename; ?>
                                            <br>
                                            <b>CulturaPass:</b> <?php echo get_the_author_meta( 'cp_id_culturapass', $user_info->ID ); ?>
                                        </p>

                                    </div>
                                </div>
                            </div>
                            <div id="tab17" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-8 text-right">
                                        <h3 class="tc-tab-title">Promociones</h3>
                                        <p class="tc-tab-desc">
                                            Personas que cuenten con CulturaPass <h2 style="color: #b74e4e;">$100.00</h2>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <img src="https://scontent.fmex5-1.fna.fbcdn.net/v/t1.0-9/46347698_1219369208200946_1896058126507966464_n.jpg?_nc_cat=109&_nc_ht=scontent.fmex5-1.fna&oh=af09a6ccf1d29a39ed6d73d040a93d84&oe=5C69B75D">
                                    </div>
                                </div>
                            </div>
                            <div id="tab18" class="tab-pane fade">
                                <div class="row">
                                    <div class="col-md-4">
                                        <img src="http://cultura.hidalgo.gob.mx/wp-content/uploads/2018/11/FNC_-16.jpg">
                                    </div>
                                    <div class="col-md-8">
                                        <h3 class="tc-tab-title">Eventos</h3>
                                        <p class="tc-tab-desc">
                                            MÚSICA / ACTIVIDAD RECREATIVA | GRATUITO
                                        <h2 style="color: #b74e4e; margin-bottom: 0px;">RwR</h2>                                        
                                        </p>
                                        <p class="tc-tab-desc" style="color: #af7373b5">                                        
                                            Próximas fechas: noviembre 25 15:00 h
                                            <br>
                                            Plaza Juárez, Pachuca Hidalgo.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>                              
                    </div>


                </div>
                <div class="col-md-4">
                    
                </div>
            </div>
        </div>
    </section>
</div>
<!--            
    <div class="control-group gutters all-100 ink-form"> 
        <div class="all-40">
            <canvas id="estudios" width="200" height="200"></canvas>
        </div>
        <div class="all-40 left-space">
            <table class="ink-table">
                <thead>
                    <tr>
                        <th colspan="2">Último grado de estudios</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Ninguno</td>
                        <td><?php //echo $Ninguno; ?></td>
                    </tr>
                    <tr>
                        <td>Primaria</td>
                        <td><?php //echo $Primaria; ?></td>
                    </tr>
                    <tr>
                        <td>Secundaria</td>
                        <td><?php //echo $Secundaria; ?></td>
                    </tr>
                    <tr>
                        <td>Media superior</td>
                        <td><?php //echo $Media_superior; ?></td>
                    </tr>
                    <tr>
                        <td>Superior</td>
                        <td><?php //echo $Superior; ?></td>
                    </tr>
                    <tr>
                        <td>Posgrado</td>
                        <td><?php //echo $Posgrado; ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="control-group gutters all-100 ink-form"> 
        <div class="all-40">
            <canvas id="genero" width="200" height="200"></canvas>
        </div>
        <div class="all-40 left-space">
            <table class="ink-table">
                <thead>
                    <tr>
                        <th colspan="2">Género</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Hombre</td>
                        <td><?php //echo $Hombre ;?></td>
                    </tr>
                    <tr>
                        <td>Mujer</td>
                        <td><?php //echo $Mujer; ?></td>                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="control-group gutters all-100 ink-form"> 
        <div class="all-40">
            <canvas id="activas" width="200" height="200"></canvas>
        </div>
        <div class="all-40 left-space">
            <table class="ink-table">
                <thead>
                    <tr>
                        <th colspan="2">Usuarios con tarjetas activas</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Usuarios con tarjetas</td>
                        <td><?php //echo $Tactivas ;?></td>
                    </tr>
                    <tr>
                        <td>Usuarios sin tarjetas</td>
                        <td><?php //echo $Total-$Tactivas; ?></td>                        
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="control-group gutters all-100 ink-form"> 
        <div class="all-40">
            <canvas id="municipios" width="200" height="200"></canvas>
        </div>
        <div class="all-40 left-space">
            <table class="ink-table">
                <thead>
                    <tr>
                        <th colspan="2">Municipios</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    //foreach ($municipios_unicos as $key => $municipio){
                    //    echo '<tr><td>'.$key.'</td><td>'.$municipio.'</td></tr>';
                    //}
                    ?>
                </tbody>
            </table>
        </div>
    </div>                  
-->


     