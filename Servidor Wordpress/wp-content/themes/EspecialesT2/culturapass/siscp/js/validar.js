 /*if(!  //validarnvatarea() || //validarseguimiento() //segun sea el caso){
        return;
    }    
 Agregar a la pagina antes de enviar 
*/
$(document).ready(function(){
    
});

function validarnvatarea(){
    $('p.tip').remove();
    var valid=true;
    $("div.chosen-container").removeAttr('style');
    $("div.chosen-container").css('width','409px');
    
    $('#formdata input:text').each(function(){   
        $(this).removeAttr('style');
        if($(this).val()=="" && $(this).attr('id') && $(this).attr('id')!="ndocumento"){
            mostrarerror($(this).attr('id'));
            valid=false;
        }
    }); 
    
    var c=0;
    $('#turnar option:selected').each(function(){
            c=c+1;
    });
    if(c<=0){
         mostrarerror('turnar');
         valid=false;
    }
    
    if($('#descripcion').val()==""){
        mostrarerror('descripcion');
        valid=false;
    }
    
    return valid;
}

function validarseguimiento(){
    $('p.tip').remove();
    var valid=true;
     
    $('#fproceso').removeAttr('style');
    if($('#fproceso').val()==""){
        mostrarerror('fproceso');
        valid=false;         
    }
    
    if($('#descripcion').val()==""){
        mostrarerror('descripcion');
        valid=false;
    }
    
    return valid;
}

function mostrarerror(id){
    if(id=='turnar'){
        $("div.chosen-container").css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.1),0 0 10px rgba(200,10,16,0.5)');
        $("div.chosen-container").css('border','1px solid rgba(200,10,16,0.5)');
        $("#"+id).before('<p class="tip error">Campo Requerido</p>');  
    }else{
        $("#"+id).css('box-shadow','inset 0 1px 3px rgba(0,0,0,0.1),0 0 10px rgba(200,10,16,0.5)');
        $("#"+id).css('border','1px solid rgba(200,10,16,0.5)');
        $("#"+id).before('<p class="tip error">Campo Requerido</p>');  
    }          
}