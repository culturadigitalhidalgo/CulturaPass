var filesn=0;                   //variable de control para los id de div 
var filesname = new Array();    //arreglo de control (nombre de los archivos)	 

$(document).ready(function(){
    //se cargan los elementos html al div contentfiles
    var divfiles='<div class="fileinputs" id="fileinputs">'+
                '<div id="divfile0">'+
                    '<input type="file" id="file0" class="hide-all arch" name="archivos[]"/>'+
                    '<div class="content-left">'+
                        '<label id="addarch0" class="ink-button green" for="file0" style="font-size:0.8em;padding:0 0.5em;">Examinar...</label>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div id="listfiles">'+
            '</div>'+
            '<br/>'+
            '<div id="mensajes" class="ink-label error large-100 small-100"></div>'+             
            '<br/>';
    $('#contentfiles').html(divfiles);                    
    $('#mensajes').hide();
    
    //funcion para detectar que se a seleccionado un archivo y agregar uno nuevo
    $('#contentfiles').on('change','input.arch',function(){  
        $('#mensajes').hide();
        var condicion=false;
        for (var i = 0; i < this.files.length; i++)
        {
            var name=this.files[i].name;
            //verificar si el archivo ya esta cargado en el arreglo de control
            if(filesname.indexOf(name)!=-1){
                $('#mensajes').show();
                $('#mensajes').html('El archivo ya esta agregado elija otro por favor');
            }else{ //si no esta cargado se agrega al arreglo de control y se agrega a la lista de archivos con un boton para quitarlo
                filesname[filesn]=name;
                $('#addarch'+filesn).remove();
                $('#listfiles').html($('#listfiles').html()+
                        "<div id='divfilename"+filesn+"' class='large-100'><div class='large-60 small-100' style='padding-left:5px;'>"+name+"</div>"+
                            "<div class='large-40 filestat content-right' id='divfilestat"+filesn+"'>"+
                                "<button id='removefile"+filesn+"' class='ink-button removefile' value='"+filesn+"' style='font-size:0.8em;font-weight:normal;padding:0.3em 0.5em;'>Eliminar</button>"+
                            "</div>"+
                        "</div>"); 
                condicion=true;
            }
        }      
        if(condicion){ //si se agrego un elemento a la lista de archivos se crea un nuevo div y un nuevo input:file
            filesn=filesn+1;
            var item='<div id="divfile'+filesn+'">'+
                        '<input type="file" id="file'+filesn+'" class="hide-all arch" name="archivos[]"/>'+
                        '<div class="content-left">'+
                            '<label id="addarch'+filesn+'" class="ink-button green" for="file'+filesn+'" style="font-size:0.8em;padding:0 0.5em;">Examinar...</label>'+
                        '</div>'+
                    '</div>';

            $('#fileinputs').append(item);  
        }                        
    });

    //funcion para remover los archivos de la lista
    $('#contentfiles').on('click','button.removefile',function(e){
        e.preventDefault();
        var filen=$(this).val();
        $('#divfile'+filen).remove(); //se remueve del dom el input
        $('#divfilename'+filen).remove(); //se remueve de la lista de archivos
        filesname[filen] = ""; //se elimina del arreglo de control
    });
    
    $('#contentfiles').on('click','button.reintentarup',function(e){
        e.preventDefault();
        var filen=$(this).val();        
        $('#divfilestat'+filen).html("Reintentando...");
        reintentarupload(filen);
    });
});

function errorajax(){
    $('#mensajes').show();
    $('div.filestat').html('Error');
    $('#mensajes').removeClass('success');
    $('#mensajes').removeClass('error');
    $('#mensajes').removeClass('info');
    $('#mensajes').addClass('error');
    $('#mensajes').html('Error en la operación. Reintente por favor');
    $('button.creartarea').attr("disabled", false);
}

function escondemensajes(){
    $('#mensajes').hide();
}

function prepararenvio(){
    $(':button.creartarea').attr("disabled", true);
    $('div.filestat').html('Subiendo...');  
    $('#mensajes').show();
    $('#mensajes').removeClass('success');
    $('#mensajes').removeClass('error');
    $('#mensajes').removeClass('info');
    $('#mensajes').addClass('info');
    $('#mensajes').html('Preparando Archivos. Espere por favor...');
}

function errorguardadodatos(){
    $('#mensajes').show();
    $('div.filestat').html('Error');
    $('#mensajes').removeClass('success');
    $('#mensajes').removeClass('error');
    $('#mensajes').removeClass('info');
    $('#mensajes').addClass('error');
    $('#mensajes').html('Error en la operación. Reintente por favor');
    $(':button.creartarea').attr("disabled", false);
}

function errorsubida(){
    $('#mensajes').show();    
    $('#mensajes').removeClass('success');
    $('#mensajes').removeClass('error');
    $('#mensajes').removeClass('info');
    $('#mensajes').addClass('error');
    $('#mensajes').html('Error al subir algun archivo. Reintente por favor');
}

function errorservidor(){
    $('#mensajes').show();    
    $('div.filestat').html('Error');
    $('#mensajes').removeClass('success');
    $('#mensajes').removeClass('error');
    $('#mensajes').removeClass('info');
    $('#mensajes').addClass('error');
    $('#mensajes').html('Error al guardar la información. Reintente por favor');
    $(':button.creartarea').attr("disabled",false);
}

function verificarsubida(data){ 
    var inicio=data.indexOf('[{"');
    var fin= data.indexOf('}]');    
    if(data.indexOf("errordb")!=-1){
        errorservidor();
        return false();
    }else if(inicio!=-1 && fin!=-1){
        var datafiles = data.substring(inicio,fin+2); 
        var ok = true; //variable de control (error en la carga de archivos)
        var json = eval("(" + datafiles + ")");                      
        jQuery.each(json, function(){ //se verifica la variable de cada archivo en base al nombre y un status
            var fileindex = filesname.indexOf(this.file); 
            if(this.status=="success"){ //si el status del archivo es success se informa al usuario y se continua 
                $('#divfilestat'+fileindex).html("El archivo se cargo correctamente");
            }else if(this.status=="error"){//si es error el status se avisa al usuario q reintente la carga
                var reintentar='<button class="ink-button red reintentarup" value="'+this.index+'">Reintentar Subir</button>'+
                                '';
                $('#idtareaseg').val(this.idtareaseg);
                $('#divfilestat'+fileindex).html("Error al cargar el archivo "+reintentar);
                $(':button.creartarea').attr("disabled", true);
                ok=false; //se modifica la variable de control para evitar continuar 
            }
        });
        if(ok){ //si no existe errores en la carga de los archivos              
            return true;
        }else{
            errorsubida();
            return false();
        }        
    }else if(data.indexOf("[]")!=-1){
        return true;
    }
}

function resetform(reload){
    $('#mensajes').show(); 
    $('#mensajes').removeClass('error');
    $('#mensajes').removeClass('success');
    $('#mensajes').removeClass('info');
    $('#mensajes').addClass('success');
    $('#mensajes').html('La información se agregó correctamente'); //se notifica al usuario que la tarea termino 

    filesn=0; //reset de la variable de control de numero de archivos
    filesname.length=0; //reset del arreglo de control con el nombre de los archivos
    //se agrega de nuevo el div con elementos de carga vacio
    var html=divfiles='<div class="fileinputs" id="fileinputs">'+
                '<div id="divfile0">'+
                    '<input type="file" id="file0" class="hide-all arch" name="archivos[]"/>'+
                    '<div class="content-left">'+
                        '<label id="addarch0" class="ink-button green" for="file0" style="font-size:0.8em;padding:0 0.5em;">Examinar...</label>'+
                    '</div>'+
                '</div>'+
            '</div>'+
            '<div id="listfiles">'+
            '</div>'+
            '<br/>'+
            '<div id="mensajes" class="ink-label error large-100 small-100"></div>'+             
            '<br/>';
    $('#contentfiles').delay(2000).fadeOut('slow',function(){
        if(reload=="reload"){
            location.reload();
        }else{
            $('#formdata').each (function(){
                this.reset();                                    
            });           
            $(".chosen-select").val('').trigger("chosen:updated");
            $('#contentfiles').html(html).fadeIn('slow');
            $("#mensajes").hide();
            $(':button.creartarea').attr("disabled",false);
        }
    });        
}

function reintentarupload(indexfile){
    escondemensajes();                    

    //se crea la variable de envio como un nuevo FormData
    //con esto se cargan los archivos
    var formData = new FormData($('#formdata')[0]);     
    //se agregan al arreglo las variables extras aparte de los archivos
    var tipoform=$('#formtype').val();
    var idtarea=$('#idtareaseg').val();
    formData.append('idtareareup',idtarea);
    formData.append('indexfile',indexfile);
    formData.append('tipoform',tipoform)
    
    $.ajax({
        url: 'reintentarcarga.php',  
        type: 'POST',
        // Form data
        //datos del formulario
        data: formData,
        //necesario para subir archivos via ajax
        cache: false,
        contentType: false,
        processData: false,
        //mientras enviamos el archivo
        beforeSend: function(){ 
            $('#divfilestat'+indexfile).html("Reintentando subir...");             
        },
        //una vez finalizado correctamente
        success: function(data){ 
            if(data!=""){
                if(data=="error"){ //verificamos que el servidor no mande una respuesta con error por guardar la informacion en la BD
                    errorguardadodatos();
                }else{ //si no existe respuesta de error de guardado de datos comprobamos que no exista error en la carga de algun archivo
                    if(verificarsubida(data)){//si no existe error en la subida del archivo 
                        if ($('button.reintentarup').length){
                            $('#mensajes').show(); 
                            $('#mensajes').removeClass('error');
                            $('#mensajes').removeClass('success');
                            $('#mensajes').removeClass('info');
                            $('#mensajes').addClass('error');
                            $('#mensajes').html('Existen archivos sin subir, Reintente por favor');                                                  
                       }else{                            
                           resetform("");
                       }
                    }                              
                }  
            }else{ //si no existe respuesta de error de guardado de datos comprobamos que no exista error en la carga de algun archivo
                errorajax();                            
            } 

        },
        //si ha ocurrido un error se notifica al usuario
        error: function(e){ alert(e);
            errorajax();
        }
    });  
}