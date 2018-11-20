<?php  
/* 
* @category Riesgo
* @author Eliel Trigueros Hernandez
* @since Versión 1.0, revisión 1. Febrero/2018
* @versión 1.0 
*/
require ('../../../../../wp-load.php');
$field = get_field_object('field_5a2aba9ab0426');
$choices = $field['choices'];
echo '<option value="0">Todos los riesgos</option>';
foreach ($choices as $key => $valor) {
   echo '<option value="'.$key.'">'.$valor.'</option>';
}
?>
