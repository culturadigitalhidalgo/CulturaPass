<?php
$path="../wp-content/themes/EspecialesT2/culturapass/siscp/";

$usuarios_culturapass = get_users( 'role=cultuspass' );
$Ninguno=0;
$Primaria=0;
$Secundaria=0;
$Media_superior=0;
$Superior=0;
$Posgrado=0;

$Hombre=0;
$Mujer=0;
$X=0;
$Tactivas=0;
$municipios=Array();
foreach ( $usuarios_culturapass as $usuario ) {
    //print_r( get_the_author_meta( 'cp_ult_gra', $usuario->ID ) );
    switch (get_the_author_meta( 'cp_ult_gra', $usuario->ID )) {
       case 'Ninguno':
             $Ninguno++;
             break;
       case 'Primaria':
             $Primaria++;
             break;
       case 'Secundaria':
             $Secundaria++;
             break;
       case 'Media superior':
             $Media_superior++;
             break;
       case 'Superior':
             $Superior++;
             break;
       case 'Posgrado':
             $Posgrado++;
             break;
    }
    switch (get_the_author_meta( 'cp_gen', $usuario->ID )) {
       case 'Hombre':
             $Hombre++;
             break;
       case 'Mujer':
             $Mujer++;
             break;
       case 'X':
             $X++;
             break;
    }
    
    if(get_the_author_meta( 'cp_edo_nac', $usuario->ID ) == 'Hidalgo')
        $municipios[] = get_the_author_meta( 'cp_dom_nac', $usuario->ID );
    
    if(get_the_author_meta( 'cp_id_culturapass', $usuario->ID ) <> '')
        $Tactivas++; 
    
    //echo '<span>' . esc_html( $usuario->user_email ) . '</span>';
    //print_r($usuario);


}
//echo $Ninguno;
//echo '<br>';
//echo $Primaria;
//echo '<br>';
//echo $Secundaria;
//echo '<br>';
//echo $Media_superior;
//echo '<br>';
//echo $Superior;
//echo '<br>';
//echo $Posgrado;
//echo '<br>';
//echo $Hombre;
//echo '<br>';
//echo $Mujer;
//echo '<br>';
//echo $X;
//echo '<br>';

$municipios_unicos = array_count_values($municipios);

arsort($municipios_unicos);

$municipios_unicos = array_slice($municipios_unicos, 0, 10); 

$mun_data_n = implode(",", $municipios_unicos);


//echo $mun_data_m = implode(", ", array_keys($municipios_unicos));

foreach ($municipios_unicos as $key => $municipio){
    $mun_data_m = $mun_data_m.'"'.$key.'",';
}

$mun_data_m = trim($mun_data_m, ',');
//echo $mun_data_m;
//print_r($valores);

//echo '<br>';
//echo $Tactivas;
//echo '<br>';
                 //solo me falta las comillas antes y despues
                 //concateno el punto al final
                //foreach ($municipios_unicos as $key => $municipio){
                        //echo '"'.$key.'",';
                //}


$Total = count($usuarios_culturapass);
?>        
        <!-- Librerias Chart-->
        <link rel="stylesheet" type="text/css" href="<?php echo $path; ?>css/ink.css">
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/Chart.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/Chart.bundle.js"></script>
        <script type="text/javascript" src="<?php echo $path; ?>Chart.js/samples/utils.js"></script>
        <link rel="stylesheet" href="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/siscp/epack/css/font-awesome.min.css">
        <link rel="stylesheet" href="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/culturapass/siscp/epack/css/elements/box.css">
<script type="text/javascript">
    jQuery(document).ready(function(){
        var estudiosC = document.getElementById("estudios");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;
        
        var estudiosD = {
            labels: [
                'Ninguno',
                'Primaria',
                'Secundaria',
                'Media superior',
                'Superior',
                'Posgrado'
            ],
            datasets: [
                {
                    data: [<?php echo $Ninguno; ?>, <?php echo $Primaria; ?>, <?php echo $Secundaria; ?>, <?php echo $Media_superior; ?>, <?php echo $Superior; ?>, <?php echo $Posgrado; ?>],
                    backgroundColor: [                        
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(220, 69, 23, 1)',                        
                        "#FF6384",
                        "#63FF84",
                        "#84FF63",
                        "#8463FF",
                        "#6384FF"
                    ]
                }]
        };
        
        var pieChart = new Chart(estudiosC, {
          type: 'doughnut',
          data: estudiosD
        });

        var generoC = document.getElementById("genero");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;
        
        var generoD = {
            labels: [
                "Hombre",
                "Mujer"
            ],
            datasets: [
                {
                    data: [<?php echo $Hombre ;?>, <?php echo $Mujer; ?>],
                    backgroundColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 99, 132, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ]
                }]
        };
        
        var pieChart = new Chart(generoC, {
          type: 'doughnut',
          data: generoD
        });

        var activasC = document.getElementById("activas");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;
        
        var activasD = {
            labels: [
                "Usuarios con tarjetas",
                "Usuarios sin tarjetas"
            ],
            datasets: [
                {
                    data: [<?php echo $Tactivas ;?>, <?php echo $Total-$Tactivas; ?>],
                    backgroundColor: [
                        "#84FF63",
                        "#8463FF",
                        "#6384FF"
                    ]
                }]
        };
        
        var pieChart = new Chart(activasC, {
          type: 'doughnut',
          data: activasD
        });

        var municipiosC = document.getElementById("municipios");

        Chart.defaults.global.defaultFontFamily = "Lato";
        Chart.defaults.global.defaultFontSize = 18;
        
        var municipiosD = {
            labels: [<?php echo $mun_data_m; ?>],
            datasets: [
                {
                    data: [<?php echo $mun_data_n;?>],
                    backgroundColor: [
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)',
                        'rgba(220, 69, 23, 1)',                        
                        "#FF6384",
                        "#63FF84",
                        "#84FF63",
                        "#8463FF",
                        "#6384FF"
                    ]
                }]
        };
        
        var pieChart = new Chart(municipiosC, {
          type: 'polarArea',
          data: municipiosD
        });
    });
</script>

    <h3>Total de usuarios registrados: <?php echo $Total;?> </h3>

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
                        <td><?php echo $Ninguno; ?></td>
                    </tr>
                    <tr>
                        <td>Primaria</td>
                        <td><?php echo $Primaria; ?></td>
                    </tr>
                    <tr>
                        <td>Secundaria</td>
                        <td><?php echo $Secundaria; ?></td>
                    </tr>
                    <tr>
                        <td>Media superior</td>
                        <td><?php echo $Media_superior; ?></td>
                    </tr>
                    <tr>
                        <td>Superior</td>
                        <td><?php echo $Superior; ?></td>
                    </tr>
                    <tr>
                        <td>Posgrado</td>
                        <td><?php echo $Posgrado; ?></td>
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
                        <td><?php echo $Hombre ;?></td>
                    </tr>
                    <tr>
                        <td>Mujer</td>
                        <td><?php echo $Mujer; ?></td>                        
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
                        <td><?php echo $Tactivas ;?></td>
                    </tr>
                    <tr>
                        <td>Usuarios sin tarjetas</td>
                        <td><?php echo $Total-$Tactivas; ?></td>                        
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
                    foreach ($municipios_unicos as $key => $municipio){
                        echo '<tr><td>'.$key.'</td><td>'.$municipio.'</td></tr>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>                  



     