function calculaCURP() {
    var paterno1st = document.getElementById('aPaterno').value; 

        paterno1st = paterno1st.replace("LAS","");
        paterno1st = paterno1st.replace("DEL","");
        
    var paterno  = paterno1st.replace("LA","");
        paterno = paterno.replace("DE","");
        paterno = paterno.replace("Y","");   
     
    while(paterno[0] == " "){
        paterno = paterno.substr(1, paterno.length - 1);
    }
    
    var materno1st = document.getElementById('aMaterno').value;
    var materno1st = materno1st.replace("LAS","");
        materno1st = materno1st.replace("DEL","");
        materno1st = materno1st.replace("DE","");
        
    var materno  = materno1st.replace("LA","");
        materno = materno.replace("Y","");
                
    while(materno[0] == " "){
        materno = materno.substr(1, materno.length - 1);
    }
    
    var nombre = document.getElementById('nombre').value.toUpperCase();
    var op_paterno = paterno.length;
    var vocales = /^[aeiou]/i;
    var consonantes = /^[bcdfghjklmnñpqrstvwxyz]/i;
    
    var s1 = '';
    var s2 = '';
    var s8 = '';

    var i = 0;
    var x= true;
    var z = true;

    while(i < op_paterno){
        if((x != false)){
            s1 = s1 + paterno[i];
            paterno = paterno.replace(paterno[i],"");
            x=false;
        }
        
        if((vocales.test(paterno[i]) == true) & (z != false)){
            s2 = s2 + paterno[i];
            paterno = paterno.replace(paterno[i],"");
            z=false;
        }
        i++;
    }

    var ix=0;
    var y = true;
    var nparteno = paterno.length;
    
    while( ix < nparteno){
        if((consonantes.test(paterno[ix]) == true) & (y != false)){
            s8 = s8 + paterno[ix];
            y=false;
        }
        ix++;
    }

    //calculos apellido materno
    var maternosize = materno.length;
    var j = 1;
    var s9 = '';
    var xm = true;
    var ym = true;
    
    while(j < maternosize){
        if((consonantes.test(materno[j]) == true) && (xm != false)){
            s9 = s9.replace(materno[j],"");
            xm = false;
        }
        
        if((consonantes.test(materno[j]) == true) && (ym != false)){
            s9 = s9 + materno[j];
            ym = false;
        }
        
        j++;
    }
    
    var nombresize = nombre.length;
    var im = 1;
    var s10= '';
    var wx = true;
    var wz = true;
    
    while(im < nombresize){
        
        if((consonantes.test(nombre[im]) == true)&& (wz != false)){
            s10 = s10 + nombre[im];
            nombre = nombre.replace(nombre[im],"");
            wz = false;
        }
        im++;
    }
    
    var sexo = $('input[name="sexo"]:checked').val();
	      if( sexo == 'Hombre'){ sexo = 'H';}else{ sexo ='M';}
       

    var edo = document.getElementById('edoNacimiento').options[document.getElementById('edoNacimiento').selectedIndex].text.toUpperCase();
    
    switch(edo){
        case "AGUASCALIENTES": edo="AS"; break;
        case "BAJA CALIFORNIA":edo="BC"; break;
        case "BAJA CALIFORNIA SUR": edo="BS"; break;
        case "CAMPECHE": edo="CC"; break;
        case "COAHUILA DE ZARAGOZA": edo="CL"; break;
        case "COLIMA": edo="CM"; break;
        case "CHIAPAS": edo="CS"; break;
        case "CHIHUAHUA": edo="CH"; break;
        case "DISTRITO FEDERAL": edo="DF"; break;
        case "DURANGO": edo="DG"; break;
        case "GUANAJUATO": edo="GT"; break;
        case "GUERRERO": edo="GR"; break;
        case "HIDALGO": edo="HG"; break;
        case "JALISCO": edo="JC"; break;
        case "MÉXICO": edo="MC"; break;
        case "MICHOACÁN DE OCAMPO": edo="MN"; break;
        case "MORELOS": edo="MS"; break;
        case "NAYARIT": edo="NT"; break;
        case "NUEVO LEÓN": edo="NL"; break;
        case "OAXACA": edo="OC"; break;
        case "PUEBLA": edo="PL"; break;
        case "QUERÉTARO": edo="QT"; break;
        case "QUINTANA ROO": edo="QR"; break;
        case "SAN LUIS POTOSÍ": edo="SP"; break;
        case "SINALOA": edo="SL"; break;
        case "SONORA": edo="SR"; break;
        case "TABASCO": edo="TC"; break;
        case "TAMAULIPAS": edo="TS"; break;
        case "TLAXCALA": edo="TL"; break;
        case "VERACRUZ DE IGNACIO DE LA LLAVE": edo="VZ"; break;
        case "YUCATÁN": edo="YN"; break;
        case "ZACATECAS": edo="ZS"; break;
    }
    
    var s3 = materno[0];
    var s4 = nombre[0];
    
    var fecha = document.getElementById("fNacimiento").value;
    var fechaSplit = fecha.split("-");
    console.log(fechaSplit);
    var s5 = fechaSplit[0][2]+fechaSplit[0][3];
    var s6 = fechaSplit[1];
    var s7 = fechaSplit[2];
    var curpFinal = s1+s2+s3+s4+s5+s6+s7+sexo+edo+s8+s9+s10;
    document.getElementById('curp').value = curpFinal.toUpperCase();
}