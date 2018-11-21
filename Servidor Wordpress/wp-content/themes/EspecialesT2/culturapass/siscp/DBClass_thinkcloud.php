<?php
//Version de la Clase: V4.0
//Desarrollo Iniciado por: I.S.C. Edgar Bautista Cuadrilla
//********************************************//
    date_default_timezone_set('Mexico/General');
    header('Content-Type: text/html; charset=utf-8');
    require_once('singleton/db_config_thinkcloud.php');
    require_once('singleton/Database.singleton_thinkcloud.php');
    
//    include( ABSPATH .'wp-includes/class-phpass.php' );
    
    class DBClass_thinkcloud{
        private $link="";
        
        public function __construct(){
            $db = DatabaseTC::obtain(DB_SERVER_TC, DB_USER_TC, DB_PASS_TC, DB_DATABASE_TC);
            $db->connect();
            $db->query("SET NAMES 'utf8'");     
            
            $this->link=$db;            
        }  

        
        //************************************Funciones de control de inicio y cierre de sesiónes*************************************************//
        //Declarar las variables de sesion que sea necesarias para el funcionamiento del sistema $_SESSION['X'] = $record['X'];   
        public function verificarAcceso($usuario, $claveplana)
        {
            $sql ="select * from usuarios where usuario='" . $usuario . "' and password =md5('" . $claveplana . "') LIMIT 1";
    
            $rows = $this->link->query($sql);
            
            $record = mysqli_fetch_array($rows);
            session_start();
            if (isset($record['idusuario']) && $record['idusuario'] !== "" )
            {
                $_SESSION['idusuariocultura'.$this->gettokensystemclass()] = $record['idusuario'];                
                $_SESSION['privilegioscultura'.$this->gettokensystemclass()] = $record['idprivilegio'];
                $_SESSION['usuariocultura'.$this->gettokensystemclass()] = $record['usuario'];
//                $_SESSION['cluesssh'] = $record['clues'];
//                $_SESSION['nombreusuariossh'] = $record['nombre'];
//                $_SESSION['appaternousuariossh'] = $record['appaterno'];
//                $_SESSION['apmaternousuariossh'] = $record['apmaterno'];
                $_SESSION['autorizacioncultura'.$this->gettokensystemclass()] = $record['status'];
                if($record['status']==1){
                    echo "AUTORIZADO";
                }else{
                    echo "NO AUTORIZADO";
                }
                exit;
            }
            else
            {
                echo "NO AUTORIZADO";
                $this->destruirSesion();
            }
        }
        
        public function verificar_WPUsr($usuario,$claveplana){
            $user_name = htmlspecialchars($usuario,ENT_QUOTES);            
             // plain password to compare
            $password = $claveplana;
            
            $hasher = new PasswordHash(8, TRUE);
            $passbd="";
            $idusuario="";
            $usuarion="";
            $display="";
            
            $passq=$this->to_query("select * from wp_users where user_login='" . $user_name . "' LIMIT 1");
            while($passrow=mysqli_fetch_array($passq)){
                $passbd=$passrow['user_pass'];
                $idusuario=$passrow['ID'];
                $usuarion=$passrow['user_login'];       
                $display=$passrow['display_name'];       
            }
            
            session_start();
            if ($hasher->CheckPassword( $password, $passbd )){
                $_SESSION['idusuariocultura'.$this->gettokensystemclass()] = $idusuario;                
//                $_SESSION['privilegioscultura'.$this->gettokensystemclass()] = $record['idprivilegio'];
                $_SESSION['usuariocultura'.$this->gettokensystemclass()] = $usuarion;
//                $_SESSION['cluesssh'] = $record['clues'];
//                $_SESSION['nombreusuariossh'] = $record['nombre'];
//                $_SESSION['appaternousuariossh'] = $record['appaterno'];
//                $_SESSION['apmaternousuariossh'] = $record['apmaterno'];
                $_SESSION['autorizacioncultura'.$this->gettokensystemclass()] = 1;
                $_SESSION['namnecultura'.$this->gettokensystemclass()] = $display;
                
                echo "Login";
            } else {
                echo "Logout";
            }
        }

        //destruir la informacion de todas la variables declaradas en la parte superior
        public function destruirSesion()
        {
            $_SESSION['idusuarioculura'.$this->gettokensystemclass()] = 0;            
//            $_SESSION['privilegiosculura'.$this->gettokensystemclass()] = "No Autorizado";
            $_SESSION['usuarioculura'.$this->gettokensystemclass()] = "No Definido";
            $_SESSION['autorizacionculura'.$this->gettokensystemclass()] = false;           
//            $_SESSION['nombreusuariossh']="";
//            $_SESSION['appaternousuariossh']="";
//            $_SESSION['apmaternousuariossh']="";
            $_SESSION['namnecultura'.$this->gettokensystemclass()] ="";
            session_unset();
            session_destroy();
        }        
        //************************************Funciones de control de inicio y cierre de sesiónes*************************************************//

        //************************************Funciones de Configuración Goblal del Sistema************************************//
        public function getnamesystem(){
            return 'CultusPASS';
        }
        
        public function gettokensystem(){
            return 'autorizacioncultura'.$this->gettokensystemclass();
        }
        
        public function gettokensystemclass(){
            return 'cultuspass';
        }
        
        //************************************Funciones de Configuración Goblal del Sistema************************************//
        
        //************************************Funciones de control de manipulación de BD básicas*************************************************//
        //Query  param: sentencia SQL//
        public function to_query($sql){
            if($primary_id = $this->link->query($sql)){
                return $primary_id;
            }else{
                return 'Error al Ejecutar la Consulta';
            }
        }
        
        //Query  param: sentencia SQL//
        //usar para transacciones
        public function to_query_trans($sql){
            if($primary_id = $this->link->query($sql)){
                return $primary_id;
            }else{
                return $primary_id;
            }
        }

        //insert param: Nombre tabla, información en array $data['campo'] = valor//
        public function to_insert($tabla,$data){
            $primary_id = $this->link->insert($tabla, $data);
            if($primary_id!==false){
                return $primary_id;
            }else{
                return 'Error al Guardar la Información';
            }
        }
        
        //insert param: Nombre tabla, información en array $data['campo'] = valor//
        //usar para transacciones
        public function to_insert_trans($tabla,$data){
            if($primary_id = $this->link->insert($tabla, $data)){
                return $primary_id;
            }else{
                return $primary_id;
            }
        }

        //update param: Nombre tabla, información en array $data['campo'] = valor, condición where//
        public function to_update($tabla,$data,$where){
            if($primary_id = $this->link->update($tabla, $data, $where)){
                return $primary_id;
            }else{
                return 'Error al Actualizar la Información';
            }
        }
        
        //update param: Nombre tabla, información en array $data['campo'] = valor, condición where//
        //usar para transacciones
        public function to_update_trans($tabla,$data,$where){
            if($primary_id = $this->link->update($tabla, $data, $where)){
                return $primary_id;
            }else{
                return $primary_id;
            }            
        }

        //delete param: Nombre tabla, condición Where //
        public function to_delete($tabla,$where){
            if($primary_id = $this->link->query("delete from ".$tabla." where ".$where)){
                return $primary_id;
            }else{
                return 'Error al Eliminar la Información';
            }
        }
        
        //delete param: Nombre tabla, condición Where //
        //usar para transacciones
        public function to_delete_trans($tabla,$where){
            if($primary_id = $this->link->query("delete from ".$tabla." where ".$where)){
                return $primary_id;
            }else{
                return $primary_id;
            }
        }
        //************************************Funciones de control de manipulación de BD básicas*************************************************//
        
        //**********************************Plantillas para los input de formularios******************************************************//
        //Param: $tipo: tipo de input para la plantilla
        //param: $id: ID del elemento HTML
        //param: $atribs: Array con los atributos del campo segun correspondan al tipo de elemento
        //param: $update: bandera que indica la concatenación de 'm' para form de update
        //return: $plantilla DOM HTML construido 
        public function obtener_plantilla($tipo,$id,$atribs,$update){
            $plantilla="";
            switch ($tipo){
                case 'divisor':
                    $plantilla.= '<div class="control-group gutters" id="div'.$id.'">     
                            <h2 class="separadores">'.$atribs['label'].'</h2>
                        </div>';                       
                    break;
                case 'divisor2':
                    $plantilla.= '<div class="all-100" id="div'.$id.'">     
                            <hr>
                        </div>';                       
                    break;
                case 'divisor3':
                    $plantilla.= '<div class="all-';
                        if(isset($atribs['classall'])){
                            $plantilla.= $atribs['classall'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= ' ';
                        if(isset($atribs['class'])){
                            $plantilla.= $atribs['class'];
                        }
                    $plantilla.= '" ';
                        if(isset($atribs['attr'])){
                            $plantilla.= $atribs['attr'];
                        }
                    $plantilla.= ' id="div'.$id.'">     
                        '.$atribs['label'].'
                        </div>';                       
                    break;
                case 'texto':
                    $plantilla.= '<div class="control-group gutters all-';
                        if(isset($atribs['classall'])){
                            $plantilla.= $atribs['classall'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= '" id="div'.$id.'">     
                        <label id="label'.$id.'" for="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '" class="all-%_ancholabel_%">'.$atribs['label'].'</label>
                        <div class="all-%_anchocampo_%">
                            <input  class="all-100 ';
                        if($atribs['obligatorio']){$plantilla.= ' required ';}
                    $plantilla.= '" type="text" id="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '"';
                    if(isset($atribs['maxlengh'])){$plantilla.= '  maxlength="'.$atribs['maxlengh'].'" ';}
                    $plantilla.= '/>
                            </div>
                        </div>';                       
                    break;
                case 'select':                    
                    $plantilla.= '<div class="control-group gutters all-';
                        if(isset($atribs['classall'])){
                            $plantilla.= $atribs['classall'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= '" id="div'.$id.'">                                     
                        <label id="label'.$id.'" for="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '" class="all-%_ancholabel_%" >'.$atribs['label'].'</label>
                        <div style="" class="all-%_anchocampo_%">
                            <select ';
                    if(isset($atribs['attr'])){
                        $plantilla.= $atribs['attr'];
                    }
                    $plantilla.=' class=" all-100 ';
                        if(isset($atribs['class'])){
                            $plantilla.= $atribs['class'];
                        }
                        if($atribs['obligatorio']){$plantilla.= ' required ';}
                    $plantilla.= '" data-placeholder="Seleccione privilegios..." id="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '">';
                    if(isset($atribs['noselecttext'])){
                        $plantilla.= '<option value="">'.$atribs['noselecttext'].'</option> ';
                    }else{
                        $plantilla.= '<option value="">Seleccione...</option> ';
                    }      
                    $plantilla.=$this->obtener_select_data_default($atribs['camposselect'], $atribs['tablaselect'], $atribs['whereselect'], $atribs['defaultselect']);
                    $plantilla.= '
                            </select>
                        </div>
                    </div>'; 
                    break;
                case 'select2':                    
                    $plantilla.= '<div class="control-group gutters all-';
                        if(isset($atribs['classall'])){
                            $plantilla.= $atribs['classall'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= '" id="div'.$id.'">                                     
                        <label id="label'.$id.'" for="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '" class="all-%_ancholabel_%" >'.$atribs['label'].'</label>
                        <div style="" class="all-%_anchocampo_%">
                            <select class=" all-100 ';
                        if($atribs['obligatorio']){$plantilla.= ' required ';}
                    $plantilla.= '" data-placeholder="Seleccione..." id="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '"> <option value="">Seleccione...</option> '; 
                        if($atribs['camposselect']!==""){
                            $dataselects = explode("¬", $atribs['camposselect']);
                            foreach($dataselects as $dataselect){
                                $element=  explode("^", $dataselect);                            
                                $plantilla.= '<option value="'.$element[0].'" ';
                                    if($element[0]===$atribs['defaultselect']){
                                        $plantilla.='selected="true"';
                                    }
                                $plantilla.= '>'.$element[1].'</option>';                          
                            }           
                        }
                    $plantilla.= '
                            </select>
                        </div>
                    </div>'; 
                    break;
                case 'checkbox':
                    $plantilla.= '<div class="control-group gutters all-';
                        if(isset($atribs['classall'])){
                            $plantilla.= $atribs['classall'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= '" id="div'.$id.'">     
                        <label id="label'.$id.'" for="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '" class="all-%_ancholabel_%">'.$atribs['label'].'</label>
                        <div class="all-%_anchocampo_%">
                            <input  class="';
                        if($atribs['obligatorio']){$plantilla.= ' required ';}
                    $plantilla.= '" type="checkbox" id="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '"/>
                            </div>
                        </div>';                       
                    break;
                case 'checkbox2':
                    $plantilla.= '<div class="control-group gutters all-'.$atribs['anchodiv'].'" id="div'.$id.'" >     
                        <label id="label'.$id.'" for="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '" class="all-';
                    if(!isset($atribs['ancholabel'])){
                        $plantilla.= '%_ancholabel_%';
                    }else{
                        $plantilla.= $atribs['ancholabel'];
                    }
                    $plantilla.= '">'.$atribs['label'].'</label>
                        <div class="all-';
                    if(!isset($atribs['anchocampo'])){
                        $plantilla.= '%_anchocampo_%';
                    }else{
                        $plantilla.= $atribs['anchocampo'];
                    }
                    $plantilla.= '">
                            <input  ';
                    if(isset($atribs['attr'])){
                        $plantilla.= $atribs['attr'];
                    }
                    $plantilla.=' class=" ';
                    if(isset($atribs['class'])){
                        $plantilla.= $atribs['class'];
                    }
                        if($atribs['obligatorio']){$plantilla.= ' required ';}
                    $plantilla.= '" type="checkbox" id="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '"/>
                            </div>
                        </div>';                       
                    break;
                case 'password':
                    $plantilla.= '<div class="control-group gutters all-';
                        if(isset($atribs['classall'])){
                            $plantilla.= $atribs['classall'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= '" id="div'.$id.'">     
                        <label id="label'.$id.'" for="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '" class="all-%_ancholabel_%">'.$atribs['label'].'</label>
                        <div class="all-%_anchocampo_%">
                            <input  class="all-100 ';
                        if($atribs['obligatorio']){$plantilla.= ' required ';}
                    $plantilla.= '" type="password" id="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '"/>
                            </div>
                        </div>';                       
                    break;
                case 'date':
                    $plantilla.= '<div class="control-group gutters all-';
                        if(isset($atribs['classall'])){
                            $plantilla.= $atribs['classall'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= '" id="div'.$id.'">     
                        <label id="label'.$id.'" for="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '" class="all-%_ancholabel_%">'.$atribs['label'].'</label>
                        <div class="all-%_anchocampo_%">
                            <input  class="all-100 ';
                        if($atribs['obligatorio']){$plantilla.= ' required ';}
                    $plantilla.= '" type="date" ';
                    if(isset($atribs['attr'])){
                        $plantilla.= $atribs['attr'];
                    }
                    $plantilla.=' id="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '"/>
                            </div>
                        </div>';                       
                    break;
                case 'number':
                    $plantilla.= '<div class="control-group gutters all-';
                        if(isset($atribs['classall'])){
                            $plantilla.= $atribs['classall'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= '" id="div'.$id.'">     
                        <label id="label'.$id.'" for="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '" class="all-%_ancholabel_%">'.$atribs['label'].'</label>
                        <div class="all-%_anchocampo_%">
                            <input  class="all-';
                        if(isset($atribs['classalli'])){
                            $plantilla.= $atribs['classalli'];
                        }else{
                            $plantilla.= '100';
                        }
                    $plantilla.= ' ';
                        if(isset($atribs['class'])){
                            $plantilla.= $atribs['class'];
                        }
                        if($atribs['obligatorio']){$plantilla.= ' required ';}
                    $plantilla.= '" type="number" ';
                        if(isset($atribs['attr'])){
                            $plantilla.= $atribs['attr'];
                        }
                    $plantilla.= ' id="'.$id;
                        if($update){$plantilla.="m";}
                    $plantilla.= '"/>
                            </div>
                        </div>';                       
                    break;
            }
            
            return $plantilla;
                                
        }
        
        //************************************Funciones de control de manipulación de BD consultas adaptadas*************************************************//        
        //select from tabla * //
        public function obtener_datos($tabla){
            if($select = $this->link->query("select * from ".$tabla.";")){                  
                return $select;
            }else{
                return 'Error al obtener la información';
            }
        }  
        
        //select from tabla * condicionado //
        public function obtener_datos_condicion($tabla,$where){                     
            if($select = $this->link->query("select * from ".$tabla." where ".$where.";")){                  
                return $select;
            }else{
                return 'Error al obtener la información';
            }            
        }  
        
        //select columna de usuario segun id
        public function obtener_por_id($tabla, $tablaid, $id, $col){
            if($select = $this->link->query("select ".$col." from ".$tabla." where ".$tablaid."=".$id.";")){
                $row =mysqli_fetch_array($select);
                return $row[$col];
            }else{
                return 'Error al obtener la información';
            }
        }
        
        //select campo1,campo2 from tabla condicionado (param Where opcional) //
        public function obtener_datos_campos($campos, $tabla, $where){
            $wherestring="";
            
            if($where!==""){
                $wherestring = " where ".$where;
            }
            
            if($select = $this->link->query("select ".$campos." from ".$tabla." $wherestring;")){                  
                return $select;
            }else{
                return 'Error al obtener la información';
            }
        }  
        
        //select campo1,campo2 from tabla condicionado Return HTML para SELECT (options) //        
        public function obtener_select_data($campos,$tabla,$where){
            $data="";
            $cont=1;
            if($select = $this->link->query("select $campos from ".$tabla." where ".$where.";")){                  
                while ($row = mysqli_fetch_array($select)){
                    $varextra="";
                    if(isset($row[2])){
                        $varextra=$row[2];
                    }
                    $varextra2="";
                    if(isset($row[3])){
                        $varextra2=$row[3];
                    }
                    
                    $data = $data. '<option value="'.$row[0].'" id-contador="'.$cont.'" attradd="'.$varextra.'" attradd2="'.$varextra2.'" >'.$row[1].'</option>';
                    $cont+=1;
                }
                return $data;
            }else{
                return 'error';
            }         
        }
        
        //select campo1,campo2 from tabla condicionado Return HTML para SELECT (options) //        
        public function obtener_select_data_default($campos,$tabla,$where,$default){
            $data="";
            $cont=1;
            if($select = $this->link->query("select $campos from ".$tabla." where ".$where.";")){                  
                while ($row = mysqli_fetch_array($select)){
                    $varextra="";
                    if(isset($row[2])){
                        $varextra=$row[2];
                    }
                    $varextra2="";
                    if(isset($row[3])){
                        $varextra2=$row[3];
                    }
                    
                    $data = $data. '<option value="'.$row[0].'" id-contador="'.$cont.'" attradd="'.$varextra.'" attradd2="'.$varextra2.'" ';
                        if($row[0]==$default){
                             $data = $data.'selected="true"';
                        }
                    $data = $data. '>'.$row[1].'</option>';
                    $cont+=1;
                }
                return $data;
            }else{
                return 'error';
            }         
        }
      

        //select condicionado (adaptar a necesidad) //                
        public function obtener_datos_multiples($tabla){   
            if($tabla==="usuarios"){
                if($select = $this->link->query("select 1;" )){
                    return $select;
                }else{
                    return 'error';
                }
            }else if($tabla==="confignentregas"){
                $nentregas=0;
                $nentregasq = $this->obtener_datos_campos("valor", "configuraciones", "idconfiguracion=5");
                while($entregan = mysqli_fetch_array($nentregasq)){
                    $nentregas = $entregan['valor'];
                }
                return $nentregas;
            } 
        } 
        
        //************************************Funciones de control de manipulación de BD consultas adaptadas*************************************************//                  
            
        //************Funcionaes Publicas**********////
        public function save_abono($idculturapass,$cantidad,$idusuariosc){
           $fecha_full=date('Y-m-d H:i:s');
           $idmovimiento= $this->genera_id_movimiento($idculturapass);
           
           $movimientodata['idmovimiento']=$idmovimiento;
           $movimientodata['idtipomovimiento']=1;
           $movimientodata['idculturapass']=$idculturapass;
           $movimientodata['idusuariocp']= $this->get_usercp($idculturapass);
           $movimientodata['fecha_hora']=$fecha_full;
           $movimientodata['monto']=$cantidad;
           $movimientodata['idusuariosc']=$idusuariosc;
           $movimientodata['iddispositivo']="1";
           $validador= $this->genera_hash($movimientodata);
           $movimientodata['validador']=$validador;
           
           //Validador de la transacción
            $valid=true;

            //inicio de la transaccion de guardado
            $this->to_query("begin;");
            
            //Guardado de información en la tabla declarada en la variable global $tablabase y la información en forma de Array $data
            if(($insert = $this->to_insert_trans("movimientos", $movimientodata))===false){
                $valid=false;
                echo 'Error al procesar la información<br>';
            }

            if($valid==true){
                $this->to_query("commit;");
                return "commit";      
            }else{
                $this->to_query("rollback;");  
                return "rollback"; 
            }        
           
        }
        
        public function save_cargo($idculturapass,$cantidad,$idservicio,$idevento,$fecha,$hora,$idusuariosc,$cantidadb,$estadistica){
           $fecha_full=date('Y-m-d H:i:s');
           $idmovimiento= $this->genera_id_movimiento($idculturapass);
           
           $estadisticasb= explode("|", $estadistica);
           
           $movimientodata['idmovimiento']=$idmovimiento;
           $movimientodata['idtipomovimiento']=2;
           $movimientodata['idculturapass']=$idculturapass;
           $movimientodata['idusuariocp']= $this->get_usercp($idculturapass);
           $movimientodata['fecha_hora']=$fecha_full;
           $movimientodata['monto']=$cantidad;
           $movimientodata['idusuariosc']=$idusuariosc;
           $movimientodata['iddispositivo']="1";
           $validador= $this->genera_hash($movimientodata);
           $movimientodata['validador']=$validador;
           
           //Validador de la transacción
            $valid=true;

            //inicio de la transaccion de guardado
            $this->to_query("begin;");
            
            //Guardado de información en la tabla declarada en la variable global $tablabase y la información en forma de Array $data
            if(($insertmov = $this->to_insert_trans("movimientos", $movimientodata))===false){
                $valid=false;
                echo 'Error al procesar la información<br>';
            }
            
            $movdescdata['idmovimiento']=$idmovimiento;
            $movdescdata['idtipomovimiento']=2;
            $movdescdata['idservicio']=$idservicio;
            $movdescdata['cantidad']=$cantidadb;
            
            if(($insertdescmov = $this->to_insert_trans("descmovimientos", $movdescdata))===false){
                $valid=false;
                echo 'Error al procesar la información<br>';
            }
            
            foreach ($estadisticasb as $key => $value) {
                $estadisticab= explode(";", $value);
                $movboletodata['idmovimiento']=$idmovimiento;
                $movboletodata['idtipomovimiento']=2;
                $movboletodata['idservicio']=$idservicio;
                $movboletodata['idevento']=$idevento;
                $movboletodata['idgrupoedad']=$estadisticab[0];
                $movboletodata['sexo']=$estadisticab[1];
                $movboletodata['cantidad']=$estadisticab[2];
                $movboletodata['hora']=$hora;
                $movboletodata['fecha']=$fecha;
                
                if(($insertboleto = $this->to_insert_trans("boletos", $movboletodata))===false){
                    $valid=false;
                    echo 'Error al procesar la información<br>';
                }
                
                unset($movboletodata);
            }
            

            if($valid==true){
                $this->to_query("commit;");
                return "commit";      
            }else{
                $this->to_query("rollback;");  
                return "rollback"; 
            }        
        }
        
        public function consulta_saldo($idculturapass){
            $idusuariocp = $this->get_usercp($idculturapass);
            $puntos=0;
            $saldo=0;
            
            $validmovs=$this->validar_movimientos($idusuariocp);
            
            if($validmovs){
                $abonos=0;
                $cargos=0;
                $infocp= $this->to_query("SELECT sum(monto) as abonos from movimientos where idusuariocp='".$idusuariocp."' and idtipomovimiento=1");
                while($infocprow=mysqli_fetch_array($infocp)){
                    $abonos= $infocprow['abonos'];
                }
                
                $infocp= $this->to_query("SELECT sum(monto) as cargos from movimientos where idusuariocp='".$idusuariocp."' and idtipomovimiento=2");
                while($infocprow=mysqli_fetch_array($infocp)){
                    $cargos= $infocprow['cargos'];
                }
                
                $saldo=$abonos-$cargos;
                
                echo'<span id="saldocp_calc1" saldo="'.$saldo.'">Saldo en la Tarjeta: <b>$'. number_format($saldo, 2)."</b></span><br>";
                
                $abonos=0;
                $cargos=0;
                $infocp= $this->to_query("SELECT sum(monto) as abonos from puntos where idusuariocp='".$idusuariocp."' and idtipomovimiento=1");
                while($infocprow=mysqli_fetch_array($infocp)){
                    $abonos= $infocprow['abonos'];
                }
                
                $infocp= $this->to_query("SELECT sum(monto) as cargos from puntos where idusuariocp='".$idusuariocp."' and idtipomovimiento=2");
                while($infocprow=mysqli_fetch_array($infocp)){
                    $cargos= $infocprow['cargos'];
                }
                
                $puntos=$abonos-$cargos;
                //echo'<span id="saldocp_calc2" saldo="'.$saldo.'">Saldo en Puntos: <b>'.$puntos." OPoints</b></span><br>";
            }else{
                echo '<b style="color:red;" class="push-center"><i class="fa fa-warning"></i> Movimientos Corruptos!<br>La tarjeta se desactivará y se comenzará investigación.</b>';
            }
            
            
        }
        
        public function validar_cp_movs($idculturapass){
            $idusuariocp = $this->get_usercp($idculturapass);
                        
            return $validmovs=$this->validar_movimientos($idusuariocp);            
        }
        
        //************Funcionaes Privadas**********////
        private function get_usercp($idculturapass){
            $idusuario=0;
            
            $wpu= $this->to_query("SELECT user_id FROM wp_usermeta WHERE meta_key='cp_id_culturapass' and meta_value='".$idculturapass."'");
            while($wpur=mysqli_fetch_array($wpu)){
                $idusuario=$wpur['user_id'];
            }
            
            return $idusuario;            
        }
        
        
        private function genera_id_movimiento($idculturapass){
            $idmovimiento="";
            
            $fecha=date('ymd');
            $nmov=0;
            $nmovq= $this->to_query("SELECT count(*) as nmovimientos FROM movimientos WHERE idmovimiento like '%".$idculturapass.$fecha."%'");
            while($nmovr=mysqli_fetch_array($nmovq)){
                $nmov=$nmovr['nmovimientos'];
            }
            
            $nmov++;
            $nmov=str_pad($nmov, 2, "0", STR_PAD_LEFT);
            
            $idmovimiento=$idculturapass.$fecha.$nmov;
            
            return $idmovimiento;
            
        }
        
        private function genera_hash($movimientodata){
            $hash="";
            
                        
            // POR MOTIVOS DE SEGURIDAD, SE RETIRÓ EL CÓDIGO QUE SE ENCARGA DE ENCRIPTAR DE MANERA SECUENCIAL
            // MOVIMIENTOS ASOCIADOS A LAS CUENTAS DE CADA USUARIO.
            // SI REQUIERE EL CÓDIGO PARA SU IMPLEMENTACIÓN EN OTRA PRÁCTICA SIMILAR, FAVOR DE CONTACTAR AL CORREO
            // culturadigitalhidalgo@gmail.com O BIEN, COMUNICARSE AL TELÉFONO 771 778 05 38
            // CON EL ING. ELIEL TRIGUEROS.
            
            
            return $hash;
        }
        
        private function validar_movimientos($idusuario) {
            $result=true;
            
            $movimientosq=$this->to_query("select * from movimientos where idusuariocp='$idusuario'");
            while($movimientosr=mysqli_fetch_array($movimientosq)){
                $movimientodata['idmovimiento']=$movimientosr['idmovimiento'];
                $movimientodata['idtipomovimiento']=$movimientosr['idtipomovimiento'];
                $movimientodata['idculturapass']=$movimientosr['idculturapass'];
                $movimientodata['idusuariocp']= $movimientosr['idusuariocp'];
                $movimientodata['fecha_hora']=$movimientosr['fecha_hora'];
                $movimientodata['monto']=$movimientosr['monto'];
                $movimientodata['idusuariosc']=$movimientosr['idusuariosc'];
                $movimientodata['iddispositivo']=$movimientosr['iddispositivo'];
                $validador= $this->genera_hash($movimientodata);
                $validadorbd=$movimientosr['validador'];
                if($validador!==$validadorbd){
                    $invalida['validmov']=0;
                    $this->to_update_trans("movimientos", $invalida, "idmovimiento='".$movimientodata['idmovimiento']."' and idtipomovimiento='".$movimientodata['idtipomovimiento']."'");                    
                    $result =false;
                }
            }
            
            return $result;
        }
        
        //******************Función para carga de Archivos***************
        //Param: $files: Arreglo de archivos
        //param: $identificador: ID referencia (recomendado)
        //return: array con los status de upload de cada archivo.
        public function uploadfiles($files,$identificador){
            $filesupload = array("archivo"=>"");
            $directorio="files/";
            //comprobacion del directorio
            if(!is_dir("files/")){ 
                mkdir("files/", 0777);
            }
            
            foreach ($files as $id=>$key) //Iteramos el arreglo de archivos
            {
                if($key['error'] == UPLOAD_ERR_OK )                     //Si el archivo se paso correctamente Ccontinuamos 
                {
                    $NombreOriginal = $key['name'];                     //Obtenemos el nombre original del archivo
                    $nobrearray = array_reverse(explode(".", $NombreOriginal));
                    $extension = $nobrearray[0];                        //extension del archivo
                    $temporalname = $key['tmp_name'];                   //Obtenemos la ruta Original del archivo
                    $nombrefinal = $id."_".$identificador.".".$extension;   //Creamos el nombre final del archivo
//                    $destino = $directorio.$id."_".$identificador.".".$extension;	//Creamos una ruta de destino con la variable ruta y el nombre original del archivo	
                    
                    $nombreorig = $nombrefinal;   //se verifica que el archivo no existe en caso de ser asi se concatena (n) para evitar duplicados
                    $conunter=0;
                    while(file_exists ( $directorio.$nombrefinal )){
                        $conunter +=1;
                        $nombrefinal = "($conunter)".$nombreorig;
                    }
                    $destino = $directorio.$nombrefinal; // se establece la ruta final
                    
                    if(move_uploaded_file($temporalname, $destino)){   //Movemos el archivo temporal a la ruta especificada	
                        $filesupload[$id]=$nombrefinal;
                    }else{
                        $filesupload[$id]="Error";
                    }
                }else{
                    $filesupload[$id]="Error";
                }
            }
            
            return $filesupload;
        }
        
        //******************Función para carga de Archivo***************
        //Param: $file: Post de un archivo unico
        //param: $directorio: (recomendado, opcional) directorio donde se guardaran los archivos
        //param: $savename: Variable que define si el archivo mantiene el nombre o no
        //param: $comodinnomb: Variable que define si $savename = false define nuevo nombre (se respetara la extensión del archivo)
        //param: $dupli: Variable permitir ronombrar el archivo para evitar sobre escribir
        //return: array con el status de upload del archivo.
        public function uploadfile($file,$directorio,$savename,$comodinnomb,$dupli){
            $filesupload = array("archivo"=>"");
            //verificamos que se cuente con un directorio de parametro
            if($directorio===""){
                $directorio="files/";
            }
            
            //comprobacion del directorio
            if(!is_dir($directorio)){ 
                mkdir($directorio, 0777);
            }
            
            foreach ($file as $id=>$key){ //Iteramos el arreglo de archivos
                //subiendo archivo
                if($key['error'] == UPLOAD_ERR_OK ){                    //Si el archivo se paso correctamente Ccontinuamos             
                    $NombreOriginal = $key['name'];                     //Obtenemos el nombre original del archivo
                    $temporalname = $key['tmp_name'];                   //Obtenemos la ruta Original del archivo
                    $nombreorig = "";
                    $nombrefinal ="";

                    if(!$savename){ //si se reemplazará el nombre del archivo original
                        $nobrearray = array_reverse(explode(".", $NombreOriginal));
                        $extension = $nobrearray[0];                        //extension del archivo

                        $nombrefinal = $comodinnomb.".".$extension;   //Creamos el nombre final del archivo
        //                    $destino = $directorio.$id."_".$identificador.".".$extension;	//Creamos una ruta de destino con la variable ruta y el nombre original del archivo	

                        $nombreorig = $nombrefinal;   //se verifica que el archivo no existe en caso de ser asi se concatena (n) para evitar duplicados
                    }else{
                        $nombreorig=$NombreOriginal;
                        $nombrefinal=$NombreOriginal;
                    }

                    if(!$dupli){
                        $conunter=0;
                        while(file_exists ( $directorio.$nombrefinal )){
                            $conunter +=1;
                            $nombrefinal = "($conunter)".$nombreorig;
                        }
                    }

                    $destino = $directorio.$nombrefinal; // se establece la ruta final

                    if(move_uploaded_file($temporalname, $destino)){   //Movemos el archivo temporal a la ruta especificada	
                        $filesupload['archivo']=$nombrefinal;
                    }else{
                        $filesupload['archivo']="Error";
                    }
                }else{
                    $filesupload['archivo']="Error";
                }
            }
            
            return $filesupload;
        }
    }
