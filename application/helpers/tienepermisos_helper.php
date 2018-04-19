<?php

function tienePermisos($permisos)	{
	$tienePermiso = false;
	
	if(!is_array($permisos) && $permisos != null)
	    $permisos = [$permisos];

	array_push($permisos, 'ADMIN');

	foreach ($permisos as $permiso){
		$check = in_array($permiso, $_SESSION['usuario']['permisos']);
		if($check){
		    $tienePermiso = true;
		    break;
		}
	}

	return $tienePermiso;
}