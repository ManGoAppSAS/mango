<?php  
//genero el color del avatar
$pla = ord(strtolower($avatar_nombre[0]));
$ula = ord(substr($avatar_nombre, -1));
$lca = strlen($avatar_nombre);

$sca = $pla + $ula + $lca + $avatar_id;
$sca = $sca << 5;

//valores de hue, saturation y lightnin

//backgound
$ab_hue = $sca;
$ab_sat = "50%";
$ab_lig = "80%";

//texto
$at_hue = $sca;
$at_sat = "80%";
$at_lig = "30%";
?>