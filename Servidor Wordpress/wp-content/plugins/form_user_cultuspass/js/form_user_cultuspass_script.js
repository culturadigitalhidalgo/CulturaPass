jQuery(document).ready(function(){

    jQuery(function ($) {
    	var complete=0;
    	complete=$('h1.registrocompletado').length;
    	if(complete>0){
    		$('h1.registrocompletado').remove();
    		$.dialog({
				title: "Pre-Registro Completo.",
				content: "Te recomendamos pasar a algun punto autorizado a recoger tu Tarjeta CulturaPass.",
				type: 'green',
				typeAnimated: true,
				backgroundDismissAnimation: 'glow',
				boxWidth: '600px',
				useBootstrap: false,
				buttons: {
					close: function () {
					}
				}
			});
    	}

		$("#cp_privacidad").click(function() {
    	    if($("#cp_privacidad").is(':checked')) {  
    	        $('#cp_privacidad').removeClass('required errorstyle');
    	    } else {
    	        $('#cp_privacidad').addClass('required errorstyle');
    	    }  
    	});  

    	$('#cp_p_origen').change(function (){
			var p_origen=$(this).val();
			$('#div-cp_dom_nac').html('');
			
			if(p_origen==="Otro"){
				$('#div-cp_dom_nac').html('<input  class="required" type="text" name="cp_dom_nac" id="cp_dom_nac" value="">');
				$('#div-cp_edo_nac').html('<input  class="required" type="text" name="cp_edo_nac" id="cp_edo_nac" value="">');
			}else{
				$('#div-cp_edo_nac').html('<select name="cp_edo_nac" id="cp_edo_nac" value="" class="required" ><option value=""></option><option value="Aguascalientes">Aguascalientes</option><option value="Baja California">Baja California</option><option value="Baja California Sur">Baja California Sur</option><option value="Campeche">Campeche</option><option value="Coahuila de Zaragoza">Coahuila de Zaragoza</option><option value="Colima">Colima</option><option value="Chiapas">Chiapas</option><option value="Chihuahua">Chihuahua</option><option value="Ciudad de México">Ciudad de México</option><option value="Durango">Durango</option><option value="Guanajuato">Guanajuato</option><option value="Guerrero">Guerrero</option><option value="Hidalgo" selected="selected">Hidalgo</option><option value="Jalisco">Jalisco</option><option value="México">México</option><option value="Michoacán de Ocampo">Michoacán de Ocampo</option><option value="Morelos">Morelos</option><option value="Nayarit">Nayarit</option><option value="Nuevo León">Nuevo León</option><option value="Oaxaca">Oaxaca</option><option value="Puebla">Puebla</option><option value="Querétaro de Arteaga">Querétaro de Arteaga</option><option value="Quintana Roo">Quintana Roo</option><option value="San Luis Potosí">San Luis Potosí<option><option value="Sinaloa">Sinaloa</option><option value="Sonora">Sonora</option><option value="Tabasco">Tabasco</option><option value="Tamaulipas">Tamaulipas</option><option value="Tlaxcala">Tlaxcala</option><option value="Veracruz de Ignacio Llave">Veracruz de Ignacio Llave</option><option value="Yucatán">Yucatán</option><option value="Zacatecas">Zacatecas</option></select>');
				$('#div-cp_dom_nac').html('<select class="required"  name="cp_dom_nac" id="cp_dom_nac" value=""><option value=""></option><option value="Acatlán">Acatlán</option><option value="Acaxochitlán">Acaxochitlán</option><option value="Actopan">Actopan</option><option value="Agua Blanca de Iturbide">Agua Blanca de Iturbide</option><option value="Ajacuba">Ajacuba</option><option value="Alfajayucan">Alfajayucan</option><option value="Almoloya">Almoloya</option><option value="Apan">Apan</option><option value="El Arenal">El Arenal</option><option value="Atitalaquia">Atitalaquia</option><option value="Atlapexco">Atlapexco</option><option value="Atotonilco el Grande">Atotonilco el Grande</option><option value="Atotonilco de Tula">Atotonilco de Tula</option><option value="Calnali">Calnali</option><option value="Cardonal">Cardonal</option><option value="Cuautepec de Hinojosa">Cuautepec de Hinojosa</option><option value="Chapantongo">Chapantongo</option><option value="Chapulhuacán">Chapulhuacán</option><option value="Chilcuautla">Chilcuautla</option><option value="Eloxochitlán">Eloxochitlán</option><option value="Emiliano Zapata">Emiliano Zapata</option><option value="Epazoyucan">Epazoyucan</option><option value="Francisco I. Madero">Francisco I. Madero</option><option value="Huasca de Ocampo">Huasca de Ocampo</option><option value="Huautla">Huautla</option><option value="Huazalingo">Huazalingo</option><option value="Huehuetla">Huehuetla</option><option value="Huejutla de Reyes">Huejutla de Reyes</option><option value="Huichapan">Huichapan</option><option value="Ixmiquilpan">Ixmiquilpan</option><option value="Jacala de Ledezma">Jacala de Ledezma</option><option value="Jaltocán">Jaltocán</option><option value="Juárez Hidalgo">Juárez Hidalgo</option><option value="Lolotla">Lolotla</option><option value="Metepec">Metepec</option><option value="San Agustín Metzquititlán">San Agustín Metzquititlán</option><option value="Metztitlán">Metztitlán</option><option value="Mineral del Chico">Mineral del Chico</option><option value="Mineral del Monte">Mineral del Monte</option><option value="La Misión">La Misión</option><option value="Mixquiahuala de Juárez">Mixquiahuala de Juárez</option><option value="Molango de Escamilla">Molango de Escamilla</option><option value="Nicolás Flores">Nicolás Flores</option><option value="Nopala de Villagrán">Nopala de Villagrán</option><option value="Omitlán de Juárez">Omitlán de Juárez</option><option value="San Felipe Orizatlán">San Felipe Orizatlán</option><option value="Pacula">Pacula</option><option value="Pachuca de Soto">Pachuca de Soto</option><option value="Pisaflores">Pisaflores</option><option value="Progreso de Obregón">Progreso de Obregón</option><option value="Mineral de la Reforma">Mineral de la Reforma</option><option value="San Agustín Tlaxiaca">San Agustín Tlaxiaca</option><option value="San Bartolo Tutotepec">San Bartolo Tutotepec</option><option value="San Salvador">San Salvador</option><option value="Santiago de Anaya">Santiago de Anaya</option><option value="Santiago Tulantepec de Lugo Guerrero">Santiago Tulantepec de Lugo Guerrero</option><option value="Singuilucan">Singuilucan</option><option value="Tasquillo">Tasquillo</option><option value="Tecozautla">Tecozautla</option><option value="Tenango de Doria">Tenango de Doria</option><option value="Tepeapulco">Tepeapulco</option><option value="Tepehuacán de Guerrero">Tepehuacán de Guerrero</option><option value="Tepeji del Río de Ocampo">Tepeji del Río de Ocampo</option><option value="Tepetitlán">Tepetitlán</option><option value="Tetepango">Tetepango</option><option value="Villa de Tezontepec">Villa de Tezontepec</option><option value="Tezontepec de Aldama">Tezontepec de Aldama</option><option value="Tianguistengo">Tianguistengo</option><option value="Tizayuca">Tizayuca</option><option value="Tlahuelilpan">Tlahuelilpan</option><option value="Tlahuiltepa">Tlahuiltepa</option><option value="Tlanalapa">Tlanalapa</option><option value="Tlanchinol">Tlanchinol</option><option value="Tlaxcoapan">Tlaxcoapan</option><option value="Tolcayuca">Tolcayuca</option><option value="Tula de Allende">Tula de Allende</option><option value="Tulancingo de Bravo">Tulancingo de Bravo</option><option value="Xochiatipan">Xochiatipan</option><option value="Xochicoatlán">Xochicoatlán</option><option value="Yahualica">Yahualica</option><option value="Zacualtipán de Ángeles">Zacualtipán de Ángeles</option><option value="Zapotlán de Juárez">Zapotlán de Juárez</option><option value="Zempoala">Zempoala</option><option value="Zimapán">Zimapán</option></select>');
				$('#cp_edo_nac').change(function (){
					var estado=$(this).val();
					$('#div-cp_dom_nac').html('');
					
					if(estado==="Hidalgo"){
						$('#div-cp_dom_nac').html('<select class="required"  name="cp_dom_nac" id="cp_dom_nac" value=""><option value=""></option><option value="Acatlán">Acatlán</option><option value="Acaxochitlán">Acaxochitlán</option><option value="Actopan">Actopan</option><option value="Agua Blanca de Iturbide">Agua Blanca de Iturbide</option><option value="Ajacuba">Ajacuba</option><option value="Alfajayucan">Alfajayucan</option><option value="Almoloya">Almoloya</option><option value="Apan">Apan</option><option value="El Arenal">El Arenal</option><option value="Atitalaquia">Atitalaquia</option><option value="Atlapexco">Atlapexco</option><option value="Atotonilco el Grande">Atotonilco el Grande</option><option value="Atotonilco de Tula">Atotonilco de Tula</option><option value="Calnali">Calnali</option><option value="Cardonal">Cardonal</option><option value="Cuautepec de Hinojosa">Cuautepec de Hinojosa</option><option value="Chapantongo">Chapantongo</option><option value="Chapulhuacán">Chapulhuacán</option><option value="Chilcuautla">Chilcuautla</option><option value="Eloxochitlán">Eloxochitlán</option><option value="Emiliano Zapata">Emiliano Zapata</option><option value="Epazoyucan">Epazoyucan</option><option value="Francisco I. Madero">Francisco I. Madero</option><option value="Huasca de Ocampo">Huasca de Ocampo</option><option value="Huautla">Huautla</option><option value="Huazalingo">Huazalingo</option><option value="Huehuetla">Huehuetla</option><option value="Huejutla de Reyes">Huejutla de Reyes</option><option value="Huichapan">Huichapan</option><option value="Ixmiquilpan">Ixmiquilpan</option><option value="Jacala de Ledezma">Jacala de Ledezma</option><option value="Jaltocán">Jaltocán</option><option value="Juárez Hidalgo">Juárez Hidalgo</option><option value="Lolotla">Lolotla</option><option value="Metepec">Metepec</option><option value="San Agustín Metzquititlán">San Agustín Metzquititlán</option><option value="Metztitlán">Metztitlán</option><option value="Mineral del Chico">Mineral del Chico</option><option value="Mineral del Monte">Mineral del Monte</option><option value="La Misión">La Misión</option><option value="Mixquiahuala de Juárez">Mixquiahuala de Juárez</option><option value="Molango de Escamilla">Molango de Escamilla</option><option value="Nicolás Flores">Nicolás Flores</option><option value="Nopala de Villagrán">Nopala de Villagrán</option><option value="Omitlán de Juárez">Omitlán de Juárez</option><option value="San Felipe Orizatlán">San Felipe Orizatlán</option><option value="Pacula">Pacula</option><option value="Pachuca de Soto">Pachuca de Soto</option><option value="Pisaflores">Pisaflores</option><option value="Progreso de Obregón">Progreso de Obregón</option><option value="Mineral de la Reforma">Mineral de la Reforma</option><option value="San Agustín Tlaxiaca">San Agustín Tlaxiaca</option><option value="San Bartolo Tutotepec">San Bartolo Tutotepec</option><option value="San Salvador">San Salvador</option><option value="Santiago de Anaya">Santiago de Anaya</option><option value="Santiago Tulantepec de Lugo Guerrero">Santiago Tulantepec de Lugo Guerrero</option><option value="Singuilucan">Singuilucan</option><option value="Tasquillo">Tasquillo</option><option value="Tecozautla">Tecozautla</option><option value="Tenango de Doria">Tenango de Doria</option><option value="Tepeapulco">Tepeapulco</option><option value="Tepehuacán de Guerrero">Tepehuacán de Guerrero</option><option value="Tepeji del Río de Ocampo">Tepeji del Río de Ocampo</option><option value="Tepetitlán">Tepetitlán</option><option value="Tetepango">Tetepango</option><option value="Villa de Tezontepec">Villa de Tezontepec</option><option value="Tezontepec de Aldama">Tezontepec de Aldama</option><option value="Tianguistengo">Tianguistengo</option><option value="Tizayuca">Tizayuca</option><option value="Tlahuelilpan">Tlahuelilpan</option><option value="Tlahuiltepa">Tlahuiltepa</option><option value="Tlanalapa">Tlanalapa</option><option value="Tlanchinol">Tlanchinol</option><option value="Tlaxcoapan">Tlaxcoapan</option><option value="Tolcayuca">Tolcayuca</option><option value="Tula de Allende">Tula de Allende</option><option value="Tulancingo de Bravo">Tulancingo de Bravo</option><option value="Xochiatipan">Xochiatipan</option><option value="Xochicoatlán">Xochicoatlán</option><option value="Yahualica">Yahualica</option><option value="Zacualtipán de Ángeles">Zacualtipán de Ángeles</option><option value="Zapotlán de Juárez">Zapotlán de Juárez</option><option value="Zempoala">Zempoala</option><option value="Zimapán">Zimapán</option></select>');
					}else{
						//en caso contrario pedir el municipio escrito en campo text
						$('#div-cp_dom_nac').html('<input  class="required" type="text" name="cp_dom_nac" id="cp_dom_nac" value="">');
					}
				});
			}
		});
  
		$('#cp_edo_nac').change(function (){
			var estado=$(this).val();
			$('#div-cp_dom_nac').html('');
			
			if(estado==="Hidalgo"){
				$('#div-cp_dom_nac').html('<select class="required"  name="cp_dom_nac" id="cp_dom_nac" value=""><option value=""></option><option value="Acatlán">Acatlán</option><option value="Acaxochitlán">Acaxochitlán</option><option value="Actopan">Actopan</option><option value="Agua Blanca de Iturbide">Agua Blanca de Iturbide</option><option value="Ajacuba">Ajacuba</option><option value="Alfajayucan">Alfajayucan</option><option value="Almoloya">Almoloya</option><option value="Apan">Apan</option><option value="El Arenal">El Arenal</option><option value="Atitalaquia">Atitalaquia</option><option value="Atlapexco">Atlapexco</option><option value="Atotonilco el Grande">Atotonilco el Grande</option><option value="Atotonilco de Tula">Atotonilco de Tula</option><option value="Calnali">Calnali</option><option value="Cardonal">Cardonal</option><option value="Cuautepec de Hinojosa">Cuautepec de Hinojosa</option><option value="Chapantongo">Chapantongo</option><option value="Chapulhuacán">Chapulhuacán</option><option value="Chilcuautla">Chilcuautla</option><option value="Eloxochitlán">Eloxochitlán</option><option value="Emiliano Zapata">Emiliano Zapata</option><option value="Epazoyucan">Epazoyucan</option><option value="Francisco I. Madero">Francisco I. Madero</option><option value="Huasca de Ocampo">Huasca de Ocampo</option><option value="Huautla">Huautla</option><option value="Huazalingo">Huazalingo</option><option value="Huehuetla">Huehuetla</option><option value="Huejutla de Reyes">Huejutla de Reyes</option><option value="Huichapan">Huichapan</option><option value="Ixmiquilpan">Ixmiquilpan</option><option value="Jacala de Ledezma">Jacala de Ledezma</option><option value="Jaltocán">Jaltocán</option><option value="Juárez Hidalgo">Juárez Hidalgo</option><option value="Lolotla">Lolotla</option><option value="Metepec">Metepec</option><option value="San Agustín Metzquititlán">San Agustín Metzquititlán</option><option value="Metztitlán">Metztitlán</option><option value="Mineral del Chico">Mineral del Chico</option><option value="Mineral del Monte">Mineral del Monte</option><option value="La Misión">La Misión</option><option value="Mixquiahuala de Juárez">Mixquiahuala de Juárez</option><option value="Molango de Escamilla">Molango de Escamilla</option><option value="Nicolás Flores">Nicolás Flores</option><option value="Nopala de Villagrán">Nopala de Villagrán</option><option value="Omitlán de Juárez">Omitlán de Juárez</option><option value="San Felipe Orizatlán">San Felipe Orizatlán</option><option value="Pacula">Pacula</option><option value="Pachuca de Soto">Pachuca de Soto</option><option value="Pisaflores">Pisaflores</option><option value="Progreso de Obregón">Progreso de Obregón</option><option value="Mineral de la Reforma">Mineral de la Reforma</option><option value="San Agustín Tlaxiaca">San Agustín Tlaxiaca</option><option value="San Bartolo Tutotepec">San Bartolo Tutotepec</option><option value="San Salvador">San Salvador</option><option value="Santiago de Anaya">Santiago de Anaya</option><option value="Santiago Tulantepec de Lugo Guerrero">Santiago Tulantepec de Lugo Guerrero</option><option value="Singuilucan">Singuilucan</option><option value="Tasquillo">Tasquillo</option><option value="Tecozautla">Tecozautla</option><option value="Tenango de Doria">Tenango de Doria</option><option value="Tepeapulco">Tepeapulco</option><option value="Tepehuacán de Guerrero">Tepehuacán de Guerrero</option><option value="Tepeji del Río de Ocampo">Tepeji del Río de Ocampo</option><option value="Tepetitlán">Tepetitlán</option><option value="Tetepango">Tetepango</option><option value="Villa de Tezontepec">Villa de Tezontepec</option><option value="Tezontepec de Aldama">Tezontepec de Aldama</option><option value="Tianguistengo">Tianguistengo</option><option value="Tizayuca">Tizayuca</option><option value="Tlahuelilpan">Tlahuelilpan</option><option value="Tlahuiltepa">Tlahuiltepa</option><option value="Tlanalapa">Tlanalapa</option><option value="Tlanchinol">Tlanchinol</option><option value="Tlaxcoapan">Tlaxcoapan</option><option value="Tolcayuca">Tolcayuca</option><option value="Tula de Allende">Tula de Allende</option><option value="Tulancingo de Bravo">Tulancingo de Bravo</option><option value="Xochiatipan">Xochiatipan</option><option value="Xochicoatlán">Xochicoatlán</option><option value="Yahualica">Yahualica</option><option value="Zacualtipán de Ángeles">Zacualtipán de Ángeles</option><option value="Zapotlán de Juárez">Zapotlán de Juárez</option><option value="Zempoala">Zempoala</option><option value="Zimapán">Zimapán</option></select>');
			}else{
				//en caso contrario pedir el municipio escrito en campo text
				$('#div-cp_dom_nac').html('<input  class="required" type="text" name="cp_dom_nac" id="cp_dom_nac" value="">');
			}
		});
		//$('#cp_edo_nac').val('Hidalgo').change();
	
		
		$('#registrarnew').click(function(e){
			var valid =true;
			if(!valida("#registrarpersona")){
				$.dialog({
					title: "Atención",
					content: "Completa los campos obligatorios para realizar el registro",
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
			}else{
				$('p.errorusername').remove();
				$('#username').removeAttr('style'); 
				$('p.errormail').remove();
				$('#email').removeAttr('style'); 
				$('p.errorpassword').remove();
				$('#password').removeAttr('style'); 
				$('p.errorpassword2').remove();
				$('#password2').removeAttr('style'); 
				$('p.errorusername2').remove();
				$('#username').removeAttr('style'); 
				$('p.errorusername3').remove();
				$('#username').removeAttr('style'); 
				$('p.erroremail').remove();
				$('#email').removeAttr('style'); 
				$('p.erroremail2').remove();
				$('#email').removeAttr('style');

				if($('#username').val().length<4){							
					$('#username').addClass('errorstyle');
					$('#username').after('<p class="errorusername" style="color:red;">El nombre de usuario debe contener al menos 4 caracteres!</p>');
					valid=false;
				}
				
				/*var regex = /[\w-\.]{2,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
                if($('#email').val()!==""){  
                    if (!regex.test($('#email').val().trim())) {
                        $('#email').addClass('errorstyle');
                        $('#email').after('<p class="errormail" style="color:red;">Escribe un correo válido!</p>');
                        valid=false;
                    } 
                }*/
				
				if($('#password').val().length<5){							
					$('#password').addClass('errorstyle');
					$('#password').after('<p class="errorpassword" style="color:red;">El Password debe contener al menos 5 caracteres!</p>');
					valid=false;
				}
				
				if($('#password').val()!==$('#password2').val()){							
					$('#password2').addClass('errorstyle');
					$('#password2').after('<p class="errorpassword2" style="color:red;">El Password y la Confirmación no coinciden!</p>');
					valid=false;
				}
				
				var infoDatac = new FormData();
				infoDatac.append('validarreg','true');
				infoDatac.append('type','validusrexist');
				infoDatac.append('element',$('#username').val());
				var usrexist=obtener_info(infoDatac,false);
				if(usrexist.indexOf("Existe") > -1){
					$('#username').addClass('errorstyle');
					$('#username').after('<p class="errorusername2" style="color:red;">El nombre de usuario ya esta registrado!<br>Favor de intentar con otro.</p>');
					return false;
				}
				
				infoDatac = new FormData();
				infoDatac.append('validarreg','true');
				infoDatac.append('type','validusrname');
				infoDatac.append('element',$('#username').val());
				var usrexist=obtener_info(infoDatac,false);
				if(usrexist.indexOf("Error") > -1){
					$('#username').addClass('errorstyle');
					$('#username').after('<p class="errorusername3" style="color:red;">El nombre de usuario no es válido!<br>Favor de intentar con otro.</p>');
					return false;
				}
				
				infoDatac = new FormData();
				infoDatac.append('validarreg','true');
				infoDatac.append('type','validemail');
				infoDatac.append('element',$('#email').val());
				var usrexist=obtener_info(infoDatac,false);
				if(usrexist.indexOf("Error") > -1){
					$('#email').addClass('errorstyle');
					$('#email').after('<p class="erroremail" style="color:red;">El email no es válido!<br>Favor de intentar con otro.</p>');
					return false;
				}
				
				infoDatac = new FormData();
				infoDatac.append('validarreg','true');
				infoDatac.append('type','validemailexist');
				infoDatac.append('element',$('#email').val());
				var emailexist=obtener_info(infoDatac,false);
				if(emailexist.indexOf("Existe") > -1){
					$('#email').addClass('errorstyle');
					$('#email').after('<p class="erroremail2" style="color:red;">El email ya esta registrado!<br>Favor de intentar con otro.</p>');
					return false;
				}
				
			}
			
			if(!valid){
				return false;
			}
			
			$('#registrarpersona').submit();
		});
		
		function valida(form){
			var valid=true;
			
			$(form+' input.required').each(function(){   
				$(this).removeClass('errorstyle');
				if($(this).val()=="" && $(this).attr('id')){
					$(this).addClass('errorstyle');  
					//$(this).attr('placeholder','Campo Obligatorio'); 
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
		
		function obtener_info(datainfo,evaluar){
			var informacion=null;
			
			$.ajax({
				url: 'form_user_cultuspass',  
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
	
    });
});