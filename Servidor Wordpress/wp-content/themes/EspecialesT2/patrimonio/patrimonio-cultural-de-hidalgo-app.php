<?php
/*
* Patrimonio
* Name: patrimonio cultural de hidalgo app
* Author's: Eliel Trigueros Hernandez
* Author URI: http://cultura.hidalgo.gob.mx
* @since Versión 1.0, revisión 1 Febrero/2018
*/
?>
<html>
	<head>
		<meta charset="utf-8">
		<link rel="stylesheet" type="text/css" href="../wp-content/themes/EspecialesT2/patrimonio/assets/style_android.css">
		<?php wp_head(); ?>

		<script type="text/javascript">
		function mostrar(){
			var div3 = document.getElementById('filter');
			if(div3.style.display == 'block'){
		          div3.style.display = 'none';
		          jQuery('#filtros').prop('value', 'Buscar'); 
		          
		       }else{
		          div3.style.display = 'block';
		          jQuery('#filtros').prop('value', 'Ocultar'); 
		         }
		   }
		</script>

		<script type="text/javascript">
		jQuery(document).on('ready', function() {
			
			jQuery(".interfaz").click(function(event){
					event.preventDefault();
					var ruta = jQuery(".interfaz").attr("src");
					if (ruta == "../wp-content/themes/EspecialesT2/patrimonio/box.png"){
						var nuevaImagen = "../wp-content/themes/EspecialesT2/patrimonio/assets/list.png";
					}else{
						var nuevaImagen = "../wp-content/themes/EspecialesT2/patrimonio/assets/box.png";
						}
					jQuery(".interfaz").attr("src", nuevaImagen);
			});			
			getMunicipios();
		});
		
		function getMunicipios () {
			jQuery.ajax({
		            url:   '../wp-content/themes/EspecialesT2/patrimonio/ajax/get_municipios.php',
		            type:  'post',
		            success:  function (response) {
		                    jQuery("#selMunicipio").html(response);
		                    getRiesgo();
		                    getAmbito();
		                    getAo();
		            }
		    });
		}
		function getRiesgo () {
			jQuery.ajax({
		        url:   '../wp-content/themes/EspecialesT2/patrimonio/ajax/get_riesgo.php',
		        type:  'post',
		        success:  function (response) {
		                jQuery("#selRiesgo").html(response);
		                var Ruta = "../wp-content/themes/EspecialesT2/patrimonio/assets/box.png";
						get_list_box_ajax(Ruta);
		        }
		    });
		}

		function getAmbito () {
			jQuery.ajax({
		        url:   '../wp-content/themes/EspecialesT2/patrimonio/ajax/get_ambito.php',
		        type:  'post',
		        success:  function (response) {
		                jQuery("#selAmbito").html(response);
		                var Ruta = "../wp-content/themes/EspecialesT2/patrimonio/assets/box.png";
						get_list_box_ajax(Ruta);
		        }
		    });
		}
		
		function getAo () {
			jQuery.ajax({
		        url:   '../wp-content/themes/EspecialesT2/patrimonio/ajax/get_ao.php',
		        type:  'post',
		        success:  function (response) {
		                jQuery("#selAo").html(response);
		                var Ruta = "../wp-content/themes/EspecialesT2/patrimonio/assets/box.png";
						get_list_box_ajax(Ruta);
		        }
		    });
		}

		function get_Bread(){
			var Texto = jQuery( "#txtTexto" ).val()
			var Municipio = jQuery( "#selMunicipio option:selected" ).text();
			var Riesgo = jQuery( "#selRiesgo option:selected" ).text();
			var Ambito = jQuery( "#selAmbito option:selected" ).text();
			var Ao = jQuery( "#selAo option:selected" ).text();
			if(Texto==''){
  				jQuery( '#bread' ).html(Municipio+' / '+Riesgo+' / '+Ambito);
			} else {
  				//jQuery( "#bread" ).html(Municipio+" / "+Riesgo+" / "+Ambito+" / "+Ao);
				jQuery( '#bread' ).html('"'+Texto+'" / '+Municipio+' / '+Riesgo+' / '+Ambito);
			}
		}
		function get_list_box_ajax(Ruta) {
			var Texto = jQuery( "#txtTexto" ).val();
			var Municipio = jQuery( "#selMunicipio option:selected" ).val();
			var Riesgo = jQuery( "#selRiesgo option:selected" ).val();
			var Ambito = jQuery( "#selAmbito option:selected" ).val();
			var Ao = jQuery( "#selAo option:selected" ).val();
			if (Ruta == "../wp-content/themes/EspecialesT2/patrimonio/assets/box.png"){
				var Vista = "box";
			}else{
				var Vista = "list";
			}
					
			var parametros = {
				"Texto" : Texto,
				"Municipio" : Municipio,
				"Riesgo" : Riesgo,
				"Ambito" : Ambito,
				"Ao" : Ao
			};
		       jQuery.ajax({
		                type: "POST",		                	                
		                <?php
		                if (isset($ios)){
			            echo 'url: "../wp-content/themes/EspecialesT2/patrimonio/ajax/list_box_ajax2.php/?ios=1",';
						}else{
			            echo 'url: "../wp-content/themes/EspecialesT2/patrimonio/ajax/list_box_ajax2.php",';
						}
						?>		                
		                data: parametros,
		                 beforeSend: function () {
							var div3 = document.getElementById('filter');
		            	},		                
		                success: function(response){ 
		                    jQuery('#list_box2').html(response).fadeIn();
		                }
		        });
		        jQuery.ajax({
		                type: "POST",		                	                
		                <?php
		                if (isset($ios)){
			            echo 'url: "../wp-content/themes/EspecialesT2/patrimonio/ajax/list_box_ajax.php/?ios=1",';
						}else{
			            echo 'url: "../wp-content/themes/EspecialesT2/patrimonio/ajax/list_box_ajax.php",';
						}
						?>
		                
		                data: parametros,
		                beforeSend: function () {
							var div3 = document.getElementById('filter');
					        div3.style.display = 'none';
		                    jQuery("#list_box").html("<div class='msj_error'>Procesando, espere por favor...</div>");
		            	},
		                success: function(response){
					        jQuery('#filtros').prop('value', 'Buscar'); 
		                    jQuery('#list_box').html(response).fadeIn();
		                }
		        });
		           
		                
		    }
		</script>       
	</head>
	<body>
		<div class="filter_box">
		   <div class="header_box">
			   <img class="logo" src="../wp-content/themes/EspecialesT2/patrimonio/assets/gob.png" />
			   <img class="escudo" src="../wp-content/themes/EspecialesT2/patrimonio/assets/escudo.png" />
			   <img class="interfaz" src="../wp-content/themes/EspecialesT2/patrimonio/assets/list.png" onclick="get_list_box_ajax(jQuery('.interfaz').attr('src'));" style="cursor:pointer;" title="		Cambiar vista"/>
			   <input class="btn_filtrar" type="submit" name="submit" onclick="mostrar()" value="Buscar" id="filtros">
			</div>
			<div id="filter" style="display:none;">
				<input id="txtTexto" placeholder="Buscar">
		   		<select id="selMunicipio" name="selMunicipio"></select>
				<select id="selRiesgo" name="selRiesgo"></select>
				<select id="selAmbito" name="selAmbito"></select>
				<select id="selAo" name="selAo" style="visibility:hidden"></select>
				<input type="submit" name="submit" value="Buscar" id="submit" onclick="
				var Ruta = jQuery('.interfaz').attr('src');
				if (Ruta == '../wp-content/themes/EspecialesT2/patrimonio/assets/box.png'){
					Ruta = '../wp-content/themes/EspecialesT2/patrimonio/assets/list.png';
				}else{
					Ruta = '../wp-content/themes/EspecialesT2/patrimonio/assets/box.png';
				}
				get_list_box_ajax(Ruta);
				get_Bread();
				">
		   </div>   
		</div>
        
        
        
	<div class="BreadCrombs">
		<span id="list_box2"></span>
		<span id="bread">Todos los municipios / Todos los riesgos / Todos los ámbitos</span>
		<!--<span id="bread">Todos los municipios / Todos los riesgos / Todos los ámbitos / Todos los años</span>-->
	</div>
    
	<div id="list_box"></div>	

	</body>
</html>