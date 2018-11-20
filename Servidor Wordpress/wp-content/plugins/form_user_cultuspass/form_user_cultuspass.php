<?php 
/*
  Plugin Name: Form User cultuspass
  Description: Formulario personalizado preregistro CultusPass.
  Version: 1.0
  Author: Eliel Trigueros Hernandez.
 */

// include custom jQuery
if(isset($_POST['validarreg'])){
	include_once(ABSPATH . 'wp-includes/pluggable.php');
	$type=$_POST['type'];
	$element=$_POST['element'];
	
	if($type==="validusrexist"){
		if ( username_exists( $element ) ){
			echo 'Existe';
		}
	}
	if($type==="validusrname"){
		if ( !validate_username( $element ) ){
			echo 'Error';
		}
	}
	if($type==="validemail"){
		if ( !is_email( $element ) ){
			echo 'Error';
		}
	}
	if($type==="validemailexist"){
		if ( email_exists( $element ) ){
			echo 'Existe';
		}
	}
	
	
	die();
}

function form_user_cultuspass_scripts() {
    wp_enqueue_script( 'script', plugins_url('js/form_user_cultuspass_script.js', __FILE__), array('jquery'));
}
add_action('init', 'form_user_cultuspass_scripts');

function registration_form( $username, $password, $password2, $email, $first_name, $last_name, $cp_ult_gra, $cp_p_origen, $cp_edo_nac, $cp_dom_nac, $cp_ynac, $cp_gen, $cp_tipo_usuario ) {
?>
	<link href="../wp-content/libccd/jquery-confirm.min.css" rel="stylesheet" type="text/css"/>
  <script src="../wp-content/libccd/jquery-confirm.min.js" ></script>
  <script src="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/rutas_culturales/OLD/assets/lib/fancybox/jquery.fancybox.js"></script>
  <link rel="stylesheet" type="text/css" href="http://cultura.hidalgo.gob.mx/wp-content/themes/EspecialesT2/rutas_culturales/OLD/assets/lib/fancybox/jquery.fancybox.css">
  <script type="text/javascript">
  jQuery(".various").fancybox({
    maxWidth  : 900,
    maxHeight : 900,
    fitToView : false,
    width   : '100%',
    autoSize  : false,
    closeClick  : false,
    openEffect  : 'none',
    closeEffect : 'none'
  });
</script>
	
<style type="text/css">
    div {
      margin-bottom:2px;
    }
     
    input{
        margin-bottom:4px;
    }
	
	.errorstyle{
		box-shadow: inset 0 1px 3px rgba(0,0,0,0.1),0 0 10px rgba(200,10,16,0.5);
	}
  .principal{
     /*background-image: url('http://cultura.hidalgo.gob.mx/wp-content/plugins/form_user_cultuspass/assets/fondo.png');*/
     width:100%;
     padding: 0 0 36% 0;
     background:url('http://cultura.hidalgo.gob.mx/wp-content/plugins/form_user_cultuspass/assets/fondo.png') no-repeat top;
     background-size:100% auto;
     font-family: Graphik;


}
.button {
    background-color: #71B631;
    border: none;
    color: white;
    padding: 2px 62px;
    text-align: center;
    text-decoration: none;
    display: inline-block;
    font-size: 16px;
    margin: 4px 2px;
    cursor: pointer;
    position:absolute;
    overflow: hidden;
}

[class*="icheck-"] {
    min-height: 22px;
    margin-top: 6px !important;
    margin-bottom: 6px !important;
    padding-left: 0px;
}

.icheck-inline {
    display: inline-block;
}

    .icheck-inline + .icheck-inline {
        margin-left: .75rem;
        margin-top: 6px;
    }

[class*="icheck-"] > label {
    padding-left: 29px !important;
    min-height: 22px;
    line-height: 22px;
    display: inline-block;
    position: relative;
    vertical-align: top;
    margin-bottom: 0;
    font-weight: normal;
    cursor: pointer;
}

[class*="icheck-"] > input:first-child {
    position: absolute !important;
    opacity: 0;
    margin: 0;
}

    [class*="icheck-"] > input:first-child:disabled {
        cursor: default;
    }

    [class*="icheck-"] > input:first-child + label::before,
    [class*="icheck-"] > input:first-child + input[type="hidden"] + label::before {
        content: "";
        display: inline-block;
        position: absolute;
        width: 22px;
        height: 22px;
        border: 1px solid #D3CFC8;
        border-radius: 0px;
        margin-left: -29px;
    }

    [class*="icheck-"] > input:first-child:checked + label::after,
    [class*="icheck-"] > input:first-child:checked + input[type="hidden"] + label::after {
        content: "";
        display: inline-block;
        position: absolute;
        top: 0;
        left: 0;
        width: 7px;
        height: 10px;
        border: solid 2px #fff;
        border-left: none;
        border-top: none;
        transform: translate(7.75px, 4.5px) rotate(45deg);
        -ms-transform: translate(7.75px, 4.5px) rotate(45deg);
    }

[class*="icheck-"] > input[type="radio"]:first-child + label::before,
[class*="icheck-"] > input[type="radio"]:first-child + input[type="hidden"] + label::before {
    border-radius: 50%;
}

[class*="icheck-"] > input:first-child:not(:checked):not(:disabled):hover + label::before,
[class*="icheck-"] > input:first-child:not(:checked):not(:disabled):hover + input[type="hidden"] + label::before {
    border-width: 2px;
}

[class*="icheck-"] > input:first-child:disabled + label,
[class*="icheck-"] > input:first-child:disabled + input[type="hidden"] + label,
[class*="icheck-"] > input:first-child:disabled + label::before,
[class*="icheck-"] > input:first-child:disabled + input[type="hidden"] + label::before {
    pointer-events: none;
    cursor: default;
    filter: alpha(opacity=65);
    -webkit-box-shadow: none;
    box-shadow: none;
    opacity: .65;
}


.icheck-emerland > input:first-child:not(:checked):not(:disabled):hover + label::before,
.icheck-emerland > input:first-child:not(:checked):not(:disabled):hover + input[type="hidden"] + label::before {
    border-color: #71B631;
}

.icheck-emerland > input:first-child:checked + label::before,
.icheck-emerland > input:first-child:checked + input[type="hidden"] + label::before {
    background-color: #71B631;
    border-color: #71B631;
}

input {
  background-color : #CCCCCC;
}
input[type="text"], input[type="password"]{
  width: 192%;
  padding: 2px 10px;
  border: none;
}
input[type="date"]{
  width: 100%;
  padding: 2px 10px;
  border: none;
}
/*select option {
    margin: 40px;
    background: #CCCCCC;
    color: #fff;
    text-shadow: 0 1px 0 rgba(0, 0, 0, 0.4);
}*/
select {
    width: 100%;
    padding: 2px 10px;
    border: none;
    /*border-radius: 4px;*/
    background-color: #CCCCCC;
    color: #716D6D;
}

@font-face {
    font-family: "Graphik";
    src: url("http://cultura.hidalgo.gob.mx/wp-content/plugins/form_user_cultuspass/assets/Graphik-Regular-Web.woff") format('woff');
}
    </style>
<div style="color:#71B631; text-align: center; font-size: 24px; font-weight:bold;">Formulario de Solicitud de CulturaPass</div>

<div style="font-weight:bold;">CulturaPass es tu pasaporte a la cultura.</div>

<div>Solo necesitas completar el siguiente formulario para aprovechar sus beneficios. Una vez que recibamos tus datos, te esperamos en cualquiera de los siguientes lugares para que puedas recoger tu tarjeta.</div>

<p><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Tienda SomosHidalgo, ubicada en el Teatro Bartolomé de Medina, en Plaza Juárez s/n, Col. Centro, Pachuca de Soto, Hidalgo, C.P. 42000</p>
<p><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Biblioteca Central del Estado de Hidalgo Ricardo Garibay, Boulevar Felipe Angeles s/n, Int. Parque Cultural David Ben Gurión, Fraccionamiento, Zona Plateada, 42083 Pachuca de Soto, Hgo.</p>
<p><i class="fa fa-chevron-circle-right" aria-hidden="true"></i> Edificio en Río de las Avenidas No.200 Col. Periodistas, Pachuca de Soto, Hidalgo</p>
 <div class="principal">
   
 <?php echo '<form id="registrarpersona" action="' . $_SERVER['REQUEST_URI'] . '" method="post">'; ?>
    <table class="form-table">

            <tr>
                <!--<th><label for="username">Nombre de usuario <strong>*</strong></label></th>-->
                <td>
                    <input type="text" class="required" name="username" id="username" value="" placeholder="Nombre de usuario *">
                    <!--<span>Nombre de usuario, al menos debe contener 4 caracteres</span>-->
                </td>
            </tr>
            <tr>
                <!--<th><label for="email">Email <strong>*</strong></label></th>-->
                <td>
                    <input type="text" class="required"  name="email" id="email" value="" placeholder="Email *">
                </td>
            </tr>
            <tr>
<!--                 <th><label for="password">Contraseña<strong>*</strong></label></th>
 -->                <td>
                    <input type="password" class="required"  name="password" id="password" value="" placeholder="Contraseña *">
<!--                     <span>La contraseña debe contener al menos 5 caracteres</span>
 -->                </td>
            </tr>
            <tr>
<!--                 <th><label for="password2">Confirmar contraseña <strong>*</strong></label></th>
 -->                <td>
                    <input type="password" class="required"  name="password2" id="password2" value="" placeholder="Confirmar contraseña *">
                </td>
            </tr>
            <tr>
<!--                 <th><label for="firstname">Nombre(s) <strong>*</strong></label></th>
 -->                <td>
                    <input type="text"  class="required" name="fname" id="fname" value="" placeholder="Nombre(s) *">
                </td>
            </tr>
            <tr>
<!--                 <th><label for="website">Apellidos <strong>*</strong></label></th>
 -->                <td>
                    <input type="text" class="required"  name="lname" id="lname" value="" placeholder="Apellidos *">
                </td>
            </tr>
            <!--<tr>
                <th><label for="nickname">Nickname <strong>*</strong></label></th>
                <td>
                    <input type="text" class="required"  name="nickname" id="nickname" value="">
                </td>
            </tr>-->
            <tr>
                <th><label for="cp_ult_gra">Último grado de estudios <strong>*</strong></label></th>
                <td>
                    <select name="cp_ult_gra" id="cp_ult_gra"  class="required" >
                        <option value=""></option>
                        <option value="Ninguno">Ninguno</option>
                        <option value="Primaria">Primaria</option>
                        <option value="Secundaria">Secundaria</option>
                        <option value="Media superior">Media superior</option>
                        <option value="Superior">Superior</option>
                        <option value="Posgrado">Posgrado</option>
                    </select>
                </td>
            </tr>
            <tr>
              <th><label for="cp_p_origen">País de origen <strong>*</strong></label></th>
                <td>
                    <select name="cp_p_origen" id="cp_p_origen" class="required">
                      <option value="México">México</option>
                      <option value="Otro">Otro</option>
                    </select>
                </td>
            </tr>
            <tr>          
              <th><label for="cp_edo_nac">Estado donde nació <strong>*</strong></label></th>
               <td>
                <div id="div-cp_edo_nac">
                  <select name="cp_edo_nac" id="cp_edo_nac" value=""  class="required" >
                     <option value=""></option>
                     <option value="Aguascalientes">Aguascalientes</option>
                     <option value="Baja California">Baja California</option>
                     <option value="Baja California Sur">Baja California Sur</option>
                     <option value="Campeche">Campeche</option>
                     <option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option>
                     <option value="Colima">Colima</option>
                     <option value="Chiapas">Chiapas</option>
                     <option value="Chihuahua">Chihuahua</option>
                     <option value="Ciudad de México">Ciudad de México</option>
                     <option value="Durango">Durango</option>
                     <option value="Guanajuato">Guanajuato</option>
                     <option value="Guerrero">Guerrero</option>
                     <option value="Hidalgo" selected="selected">Hidalgo</option>
                     <option value="Jalisco">Jalisco</option>
                     <option value="México">México</option>
                     <option value="Michoacán de Ocampo">Michoacán de Ocampo</option>
                     <option value="Morelos">Morelos</option>
                     <option value="Nayarit">Nayarit</option>
                     <option value="Nuevo León">Nuevo León</option>
                     <option value="Oaxaca">Oaxaca</option>
                     <option value="Puebla">Puebla</option>
                     <option value="Querétaro de Arteaga">Querétaro de Arteaga</option>
                     <option value="Quintana Roo">Quintana Roo</option>
                     <option value="San Luis Potosí">San Luis Potosí</option>
                     <option value="Sinaloa">Sinaloa</option>
                     <option value="Sonora">Sonora</option>
                     <option value="Tabasco">Tabasco</option>
                     <option value="Tamaulipas">Tamaulipas</option>
                     <option value="Tlaxcala">Tlaxcala</option>
                     <option value="Veracruz de Ignacio Llave">Veracruz de Ignacio Llave</option>
                     <option value="Yucatán">Yucatán</option>
                     <option value="Zacatecas">Zacatecas</option>
                  </select>
                </div>
               </td>
            </tr>          
            <tr>
                <th><label for="cp_dom_nac">Delegación municipio donde nació <strong>*</strong></label></th>
                <td>
                    <div id="div-cp_dom_nac">
                        <select class="required"  name="cp_dom_nac" id="cp_dom_nac" value=""><option value=""></option><option value="Acatlán">Acatlán</option><option value="Acaxochitlán">Acaxochitlán</option><option value="Actopan">Actopan</option><option value="Agua Blanca de Iturbide">Agua Blanca de Iturbide</option><option value="Ajacuba">Ajacuba</option><option value="Alfajayucan">Alfajayucan</option><option value="Almoloya">Almoloya</option><option value="Apan">Apan</option><option value="El Arenal">El Arenal</option><option value="Atitalaquia">Atitalaquia</option><option value="Atlapexco">Atlapexco</option><option value="Atotonilco el Grande">Atotonilco el Grande</option><option value="Atotonilco de Tula">Atotonilco de Tula</option><option value="Calnali">Calnali</option><option value="Cardonal">Cardonal</option><option value="Cuautepec de Hinojosa">Cuautepec de Hinojosa</option><option value="Chapantongo">Chapantongo</option><option value="Chapulhuacán">Chapulhuacán</option><option value="Chilcuautla">Chilcuautla</option><option value="Eloxochitlán">Eloxochitlán</option><option value="Emiliano Zapata">Emiliano Zapata</option><option value="Epazoyucan">Epazoyucan</option><option value="Francisco I. Madero">Francisco I. Madero</option><option value="Huasca de Ocampo">Huasca de Ocampo</option><option value="Huautla">Huautla</option><option value="Huazalingo">Huazalingo</option><option value="Huehuetla">Huehuetla</option><option value="Huejutla de Reyes">Huejutla de Reyes</option><option value="Huichapan">Huichapan</option><option value="Ixmiquilpan">Ixmiquilpan</option><option value="Jacala de Ledezma">Jacala de Ledezma</option><option value="Jaltocán">Jaltocán</option><option value="Juárez Hidalgo">Juárez Hidalgo</option><option value="Lolotla">Lolotla</option><option value="Metepec">Metepec</option><option value="San Agustín Metzquititlán">San Agustín Metzquititlán</option><option value="Metztitlán">Metztitlán</option><option value="Mineral del Chico">Mineral del Chico</option><option value="Mineral del Monte">Mineral del Monte</option><option value="La Misión">La Misión</option><option value="Mixquiahuala de Juárez">Mixquiahuala de Juárez</option><option value="Molango de Escamilla">Molango de Escamilla</option><option value="Nicolás Flores">Nicolás Flores</option><option value="Nopala de Villagrán">Nopala de Villagrán</option><option value="Omitlán de Juárez">Omitlán de Juárez</option><option value="San Felipe Orizatlán">San Felipe Orizatlán</option><option value="Pacula">Pacula</option><option value="Pachuca de Soto">Pachuca de Soto</option><option value="Pisaflores">Pisaflores</option><option value="Progreso de Obregón">Progreso de Obregón</option><option value="Mineral de la Reforma">Mineral de la Reforma</option><option value="San Agustín Tlaxiaca">San Agustín Tlaxiaca</option><option value="San Bartolo Tutotepec">San Bartolo Tutotepec</option><option value="San Salvador">San Salvador</option><option value="Santiago de Anaya">Santiago de Anaya</option><option value="Santiago Tulantepec de Lugo Guerrero">Santiago Tulantepec de Lugo Guerrero</option><option value="Singuilucan">Singuilucan</option><option value="Tasquillo">Tasquillo</option><option value="Tecozautla">Tecozautla</option><option value="Tenango de Doria">Tenango de Doria</option><option value="Tepeapulco">Tepeapulco</option><option value="Tepehuacán de Guerrero">Tepehuacán de Guerrero</option><option value="Tepeji del Río de Ocampo">Tepeji del Río de Ocampo</option><option value="Tepetitlán">Tepetitlán</option><option value="Tetepango">Tetepango</option><option value="Villa de Tezontepec">Villa de Tezontepec</option><option value="Tezontepec de Aldama">Tezontepec de Aldama</option><option value="Tianguistengo">Tianguistengo</option><option value="Tizayuca">Tizayuca</option><option value="Tlahuelilpan">Tlahuelilpan</option><option value="Tlahuiltepa">Tlahuiltepa</option><option value="Tlanalapa">Tlanalapa</option><option value="Tlanchinol">Tlanchinol</option><option value="Tlaxcoapan">Tlaxcoapan</option><option value="Tolcayuca">Tolcayuca</option><option value="Tula de Allende">Tula de Allende</option><option value="Tulancingo de Bravo">Tulancingo de Bravo</option><option value="Xochiatipan">Xochiatipan</option><option value="Xochicoatlán">Xochicoatlán</option><option value="Yahualica">Yahualica</option><option value="Zacualtipán de Ángeles">Zacualtipán de Ángeles</option><option value="Zapotlán de Juárez">Zapotlán de Juárez</option><option value="Zempoala">Zempoala</option><option value="Zimapán">Zimapán</option></select>
                    </div>
                </td>
            </tr>


            <tr>
                <th><label for="cp_ynac">Fecha de nacimiento <strong>*</strong></label></th>
                <td>
                    <input type="date" name="cp_ynac" id="cp_ynac" class="required"  value="">
                </td>
            </tr>
            <!-- <tr> -->
                <th><label for="cp_gen">Género <strong>*</strong></label></th>
                <td>
                    <select name="cp_gen" id="cp_gen" class="required" >
                        <option value=""></option>
                        <option value="Hombre">Hombre</option>
                        <option value="Mujer">Mujer</option>
                        <option value="X">X</option>
                    </select>
                </td>
            </tr>
            <tr>
              <td>
                <input type="hidden" name="cp_tipo_usuario" id="cp_tipo_usuario" value="Consumidor"/>
              </td>
            </tr>
            <tr>
              <td>
                <p style="color:#71B631; padding-top: 25px;"><strong>(*)</strong> Campos obligatorios</p>
              </td>
            </tr>            
            <tr>
              <td>
                <div class="checkbox icheck-emerland">
                  <input type="checkbox" name="cp_privacidad" id="cp_privacidad" class="required" />
                  <label for="cp_privacidad"><p style="color:#71B631";><a class="various" target="black_" href="http://cultura.hidalgo.gob.mx/aviso-de-privacidad/"><i class="fa fa-eye" style="color:#71B631;"></i><span style="color:#71B631";> He leído y acepto la 
                  política de privacidad</span></a></label>
                  <!--<label for="cp_privacidad"><p style="color:#71B631";><a class="various" data-fancybox-type="iframe" href="http://cultura.hidalgo.gob.mx/wp-content/plugins/form_user_cultuspass/aviso.html"><i class="fa fa-eye" style="color:#71B631;"></i><span style="color:#71B631";> He leído y acepto la 
                  política de privacidad</span></a></label>-->
                </div>

              </td>
            </tr>
            <tr>
              <td>
                <center><input type="submit" name="submit" value="Registrar" id="registrarnew" class="button"/></center>
              </td>
            </tr>
            
    </table>
</form>
</div>
<?php
}

/*
function registration_validation( $username, $password, $password2, $email, $first_name, $last_name, $nickname, $cp_ult_gra, $cp_edo_nac, $cp_dom_nac, $cp_ynac, $cp_gen, $cp_tipo_usuario )  {
	global $reg_errors;
    $reg_errors = new WP_Error;
    
    if ( empty( $username ) || empty( $password ) || empty( $password2 ) || empty( $email ) || empty( $first_name ) || empty( $last_name ) || empty( $cp_ult_gra ) || empty( $cp_edo_nac ) || empty( $cp_dom_nac ) || empty( $cp_ynac ) || empty( $cp_gen ) ) {
        $reg_errors->add('field', 'Te falto agregar un campo requerido');
    }
    
    if ( 4 > strlen( $username ) ) {
        $reg_errors->add( 'username_length', 'Nombre de usuario es muy corto, al menos debe contener 4 caracteres' );
    }
    
    if ( username_exists( $username ) )
        $reg_errors->add('user_name', 'Disculpa, el nombre de usuario ya existe!');
    
    if ( ! validate_username( $username ) ) {
        $reg_errors->add( 'username_invalid', 'Disculpa, el nombre de usuario no es valido' );
    }
    
    if ( 5 > strlen( $password ) ) {
        $reg_errors->add( 'password', 'La contraseña debe contener al menos 5 caracteres' );
    }

    if ( $password !== $password2 ) {
        $reg_errors->add( 'password2', 'La contraseña y la confirmación de la contrasña deben ser iguales' );
    }
    
    if ( !is_email( $email ) ) {
        $reg_errors->add( 'email_invalid', 'Email no valido' );
    }
    
    if ( email_exists( $email ) ) {
        $reg_errors->add( 'email', 'Email ya esta en uso!' );
    }
    
    if ( is_wp_error( $reg_errors ) ) {
     
        foreach ( $reg_errors->get_error_messages() as $error ) {
         
            echo '<div>';
            echo '<strong>ERROR</strong>: ';
            echo $error . '<br/>';
            echo '</div>';
             
        }
     
    }
}*/

function complete_registration() {
    global $reg_errors, $username, $password, $password2, $email, $first_name, $last_name, $cp_ult_gra, $cp_p_origen, $cp_edo_nac, $cp_dom_nac, $cp_ynac, $cp_gen, $cp_tipo_usuario;
    //if ( 1 > count( $reg_errors->get_error_messages() ) ) {
        $userdata = array(
        'user_login'    =>   $username,
        'user_email'    =>   $email,
        'user_pass'     =>   $password,
        'first_name'    =>   $first_name, 
        'last_name'     =>   $last_name,
        );
        $user = wp_insert_user( $userdata );
        update_user_meta( $user, 'cp_ult_gra', $cp_ult_gra );
        update_user_meta( $user, 'cp_p_origen', $cp_p_origen );
        update_user_meta( $user, 'cp_edo_nac', $cp_edo_nac );
        update_user_meta( $user, 'cp_dom_nac', $cp_dom_nac );
        update_user_meta( $user, 'cp_ynac', $cp_ynac );
        update_user_meta( $user, 'cp_gen', $cp_gen );
        update_user_meta( $user, 'cp_tipo_usuario', $cp_tipo_usuario );
        echo '<h1 class="registrocompletado">Registro completo. Aqui puedes <a href="' . get_site_url() . '/wp-login.php">acceder a tu nueva cuenta</a>.</h1>';   
    //}
}

function custom_registration_function() {
    if ( isset($_POST['submit'] ) ) {
        /*registration_validation(
        $_POST['username'],
        $_POST['password'],
        $_POST['password2'],
        $_POST['email'],
        $_POST['fname'],
        $_POST['lname'],
        $_POST['cp_ult_gra'],
        $_POST['cp_p_origen'],
        $_POST['cp_edo_nac'],
        $_POST['cp_dom_nac'],
        $_POST['cp_ynac'],
        $_POST['cp_gen'],
        $_POST['cp_tipo_usuario']
        );*/

        global $username, $password, $password2, $email, $first_name, $last_name, $cp_ult_gra, $cp_p_origen, $cp_edo_nac, $cp_dom_nac, $cp_ynac, $cp_gen, $cp_tipo_usuario;
        $username   =   sanitize_user( $_POST['username'] );
        $password   =   esc_attr( $_POST['password'] );
        $password2   =   esc_attr( $_POST['password2'] );
        $email      =   sanitize_email( $_POST['email'] );
        $first_name =   sanitize_text_field( $_POST['fname'] );
        $last_name  =   sanitize_text_field( $_POST['lname'] );
        $cp_ult_gra  =   sanitize_text_field( $_POST['cp_ult_gra'] );
        $cp_p_origen  =   sanitize_text_field( $_POST['cp_p_origen'] );
        $cp_edo_nac  =   sanitize_text_field( $_POST['cp_edo_nac'] );
        $cp_dom_nac   =   sanitize_text_field( $_POST['cp_dom_nac'] );
        $cp_ynac   =   sanitize_text_field( $_POST['cp_ynac'] );
        $cp_gen   =   sanitize_text_field( $_POST['cp_gen'] );
        $cp_tipo_usuario   =   sanitize_text_field( $_POST['cp_tipo_usuario'] );
 
        complete_registration(
        $username,
        $password,
        $password2,
        $email,
        $first_name,
        $last_name,
        $cp_ult_gra,
        $cp_p_origen,
        $cp_edo_nac,
        $cp_dom_nac,
        $cp_ynac,
        $cp_gen, 
        $cp_tipo_usuario
        );
    }
 
    registration_form(
        $username,
        $password,
        $password2,
        $email,
        $first_name,
        $last_name,
        $cp_ult_gra, 
        $cp_p_origen,
        $cp_edo_nac,
        $cp_dom_nac,
        $cp_ynac,
        $cp_gen, 
        $cp_tipo_usuario
        );
}

add_shortcode( 'cr_custom_registration', 'custom_registration_shortcode' );
 
function custom_registration_shortcode() {
    ob_start();
    custom_registration_function();
    return ob_get_clean();
}

