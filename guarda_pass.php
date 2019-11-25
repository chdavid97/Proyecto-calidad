<?php 

require 'funcs/conexion.php';
require 'funcs/funcs.php';

$user_id= $mysqli->real_escape_string($_POST['user_id']);
$token= $mysqli->real_escape_string($_POST['token']);
$password= $mysqli->real_escape_string($_POST['password']);
$con_password= $mysqli->real_escape_string($_POST['con_password']);

if (validaPassword($password, $con_password)) {
	
	$pass_hash= hashPassword($password);

	if (cambiaPassword($pass_hash, $user_id, $token)) {
		# code...
		echo "password modificado";
		echo "<br> <a href='index.php' > Iniciar Sesion</a>";

	}else {
		echo "Error al modificar el password";
	}
}else {
	echo 'Los password no coinciden';
}

 ?>