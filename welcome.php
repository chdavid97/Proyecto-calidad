<?php



require 'funcs/conexion.php';
require 'funcs/funcs.php';

require_once 'timeout.php';    

if ( isset( $_SESSION['id_usuario'] ) ) {

   // Sesión activa


$idUsuario = $_SESSION['id_usuario'];

$sql = "SELECT id, nombre FROM usuarios WHERE id = '$idUsuario'";
$result = $mysqli->query($sql);

$row = $result->fetch_assoc();	
}
else{

   // Sesión inactiva  
   header('Location: index.php');
}

if (!isset($_SESSION['id_usuario'])) {
	# code...
	header("Location: index.php");
}


?>

<html>
	<head>
		<title>Welcome</title>
		
		<link rel="stylesheet" href="css/bootstrap.min.css" >
		<link rel="stylesheet" href="css/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		
		<style>
			body{
				padding-top: 20px;
				padding-bottom: 20px;
			}
		</style>
	</head>
	
	<body>
		
		<div class="container">    
			<nav class='navbar navbar-default'>
				<div class="container-fluid">
					<div class='navbar-header'>
						<button type='button' class='navbar-toggle collapsed' data-toggle='collapse' data-target='#navbar' aria-expanded='false' aria-controls='navbar'>
							<span class='sr-only'>Men&uacute;</span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
							<span class='icon-bar'></span>
						</button>    
					</div>
					<div id='navbar' class='navbar-collapse collapse'>
						<ul class='nav navbar-nav'>
							<li class='active'><a href='welcome.php'>Inicio</a></li>
						</ul>
						<?php if ($_SESSION['tipo_usuario']==1) { ?>
							<ul class='nav navbar-nav'>
								<li><a href='#'>Administrar Usuarios</a></li>
							</ul>
						<?php }  ?>

						<ul class='nav navbar-nav navbar-right'>
							<li><a href='logout.php' onclick="session_destroy();">Cerrar Sesi&oacute;n</a></li>
						</ul>
					</div>
				</div>
    
			</nav>
			<div class="jumbotron">
				<h1><?php echo 'Bienvenid@   ' .utf8_decode($row['nombre']); ?></h1>
				<br />
			</div>
		</div>
	</body>
</html>
