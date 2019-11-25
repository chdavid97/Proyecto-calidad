<?php

require 'funcs/conexion.php';
require 'funcs/funcs.php';

$errors = array();

if (!empty($_POST)) {
	# code...
	$nombre = $mysqli -> real_escape_string($_POST['nombre']);
	$apellido = $mysqli -> real_escape_string($_POST['apellido']);	
	$FechaNac = $mysqli -> real_escape_string($_POST['FechaNac']);	
	$usuario = $mysqli -> real_escape_string($_POST['usuario']);
	$password = $mysqli -> real_escape_string($_POST['password']);
	$con_password = $mysqli -> real_escape_string($_POST['con_password']);
	$email = $mysqli -> real_escape_string($_POST['email']);
	$captcha = $mysqli -> real_escape_string($_POST['g-recaptcha-response']);
	$celular = $mysqli -> real_escape_string($_POST['celular']);
	$ciudad = $mysqli -> real_escape_string($_POST['ciudad']);
	$genero = $mysqli -> real_escape_string($_POST['genero']);
	$cedula = $mysqli -> real_escape_string($_POST['cedula']);
	$estado = $mysqli -> real_escape_string($_POST['estado']);

	$activo =0;
	$tipo_usuario= 2;
	$secret ='6Lc7wb8UAAAAAPLd1kVCrCXMVHpehBPw9lLRqja-';

	if (!$captcha) {
		# code...
		$errors[]= "por favor verifica el captcha";
	}
	if (isNull($nombre,$apellido,$usuario,$password,$con_password,$email,$celular,$ciudad,$genero,$cedula,$estado)) {
		# code...
		$errors[]= "Debe llenar todos los campos";
	} 
	if (!isEmail($email)) {
		# code...
		$errors[]="Correo no coincide";
	}
	if (!validaPassword($password,$con_password)) {
		# code...
		$errors[]="contraseñas no coinciden";
	}
	if (usuarioExiste($usuario)) {
		# code...
		$errors[]="el nombre del usuario $usuario ya existe ";
	}
	if (emailExiste($email)) {
		# code...
		$errors[]="el correo $email ya existe ";
	}
	if (count($errors) == 0) {
		# code...
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$captcha");
    $arr = json_decode($response,TRUE);
    if ($arr['success']) {
    	# code...
    	$pass_hash = hashPassword($password);
    	$token = generateToken();

    	$registro= registraUsuario($usuario, $pass_hash, $nombre,$apellido, $FechaNac, $email, $activo, $token, $tipo_usuario,$celular,$ciudad,$genero,$estado,$cedula);
    	if ($registro > 0) {
    		# code...
    		$url = 'http://'.$_SERVER["SERVER_NAME"].'/AAA/login/activar.php?id='.$registro.'&val='.$token;

    		$asunto= 'Activar cuenta - Sistema de Usuarios';
    		$cuerpo = "Estimado $nombre $apellido: <br /><br /> Para continuar con el proceso de registro, es indispensable dar click en la siguiente direccion <a href='$url'> Activar Cuenta</a>";

    		if(enviarEmail($email, $nombre, $asunto, $cuerpo)){
				echo	"<div class='overlay active' id='overlay'>;";
			echo "<div class='popup active' id='popup'>";
			echo "<center><label><h3>Estimad@ $nombre, Para terminar el proceso de registro siga las instrucciones que le hemos enviado al correo electronico $email</label>";
			echo "<br><center><a href=  'index.php'>Iniciar sesion</a></center>";
			echo "</div>";
			echo "</div>";
			echo "</center>";
    			
    			
    			exit;

    		} else {
    			$errors[]= "error al enviar correo";
    		}

    	}else {
    		$errors[]="error al registrar";
    	}

    } else{
    	$errors[]= 'Error al comprobar captcha';
    }

	}


}


  ?>
<html>
	<head>
		<title>Registro</title>
		
		<link rel="stylesheet" href="css2/bootstrap.min.css" >
		<link rel="stylesheet" href="css2/bootstrap-theme.min.css" >
		<script src="js/bootstrap.min.js" ></script>
		<script src='https://www.google.com/recaptcha/api.js'></script>
		<script type="text/javascript">
	function noespace() {
		var p1 = document.getElementById("password").value;  //tomamos en una variable lo ingresado en el login nombre

var noValido = /\s/;

if(noValido.test(p1)){ // se chequea el regex de que el string no tenga espacio
     alert ("La contraseña no puede contener espacios en blanco"); 
    return false; 
}
else{
     alert ("Ok"); 
    return true; 
}
}
</script>
<script>

        function prov() {
            var provincia = document.getElementById('sel1');
            var escribe = document.getElementById("provincia");
            escribe.value = provincia.value;
			document.getElementById('provincia').style.display = 'block';
			document.getElementById('sel1').style.display = 'none';
			document.getElementById('provincia').style.display = 'inline'; 
        
        }
		function genero() {
            var genero = document.getElementById('genero');
            var gen = document.getElementById("gen");
            gen.value = genero.value; 
        
        }
		function estado() {
            var estado = document.getElementById('estado');
            var est = document.getElementById("est");
            est.value = estado.value; 
        
		}
		function ciudad() {
            var estado = document.getElementById('ciudad');
            var est = document.getElementById("ciu");
            est.value = estado.value; 
        
        }

</script>
<script>
        function test() {
			document.getElementById('sel1').style.display = 'block';
			document.getElementById('provincia').style.display = 'none';
			document.getElementById('sel1').style.display = 'inline'; 
        
        }
</script>
<script>
function  onFocusValue () {
      this.setSelectionRange(0, 0);
    }
        function muestratel() {
			var provincia = document.getElementById('provincia');
            var telef = document.getElementById("telef");
			var telefono = document.getElementById("telefono");
            telefono.value = provincia.value.concat(telef.value);
			if((telefono.value).length< 9){
				alert("Número de telefono incompleto");
				document.getElementById("telef").focus();
			}else{
			document.getElementById('div2').style.display = 'block';
			document.getElementById('div1').style.display = 'none';
			document.getElementById('div2').style.display = 'inline';  }       
        }
</script>
<script>
        function editaTel() {
			document.getElementById('div1').style.display = 'block';
			document.getElementById('div2').style.display = 'none';
			document.getElementById('div1').style.display = 'inline'; 
        
        }

		
</script>
<script>
        function validarcedula()
        {
         var i;
         var cedula;
		 var acumulado;
		 var cedulaElement=document.getElementById('textocedula');
		 cedula=cedulaElement.value;
         var instancia;
         acumulado=0;
         for (i=1;i<=9;i++)
         {
          if (i%2!=0)
          {
           instancia=cedula.substring(i-1,i)*2;
           if (instancia>9) instancia-=9;
          }
          else instancia=cedula.substring(i-1,i);
          acumulado+=parseInt(instancia);
         }
         while (acumulado>0)
          acumulado-=10;
         if (cedula.substring(9,10)!=(acumulado*-1))
         {
		  cedulaElement.focus({preventScroll:false});
		  cedulaElement.value = "";
		  alert("Cedula no valida!!",cedulaElement.focus({preventScroll:false}));  
          
         }else{
		 
		 }
        }
        </script>
	</head>
	
	<body>
		<div class="container" >
			<div id="signupbox" style="margin-top:50px" class="mainbox col-md-6 col-md-offset-3 col-sm-8 col-sm-offset-2">
				<div class="panel panel-info">
					<div class="panel-heading">
						<div class="panel-title">Reg&iacute;strate</div>
						<div style="float:right; font-size: 85%; position: relative; top:-10px"><a id="signinlink" href="index.php">Iniciar Sesi&oacute;n</a></div>
					</div>  
					
					<div class="panel-body" >
						
						<form onsubmit="return noespace()" id="signupform"  class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
							
							<div id="signupalert" style="display:none" class="alert alert-danger">
								<p>Error:</p>
								<span></span>
							</div>
							
							<div class="form-group">
								<label for="nombre" class="col-md-3 control-label">Nombre:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="nombre" placeholder="Ingrese un Nombre" value="<?php if(isset($nombre)) echo $nombre; ?>" required pattern="^[a-zA-Z]*$" minlength="3" maxlength="15" >
								</div>
							</div>
							
							<div class="form-group">
								<label for="apellido" class="col-md-3 control-label">Apellido:</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="apellido" placeholder="Ingrese un Apellido" value="<?php if(isset($apellido)) echo $apellido; ?>" required pattern="^[a-zA-Z]*$" minlength="3" maxlength="15" >
								</div>
							</div>
						
							<div class="form-group">
								<label for="FechaNac" class="col-md-3 control-label">Fecha de Nacimiento:</label>
								<div class="col-md-9">
									<input type="date" id="FechaNac" name="FechaNac" value="<?php if(isset($FechaNac)) echo $FechaNac; ?>" min="1919-10-28" max="2001-11-14">
								</div>
							</div>		
							<div class="form-group">
								<label for="telefono" class="col-md-3 control-label">Telefono</label>
								<table  id="div1">
								<tr><td><div class="col-md-9">
								<select class="form-control" id="sel1" onchange="prov()">
        						<option value="07">Azuay</option>
						        <option value="03">Bolivar</option>
						        <option value="07">Cañar</option>
						        <option value="06">Carchi</option>
						        <option value="03">Chimborazo</option>
						        <option value="03">Cotopaxi</option>
						        <option value="07">El Oro</option>
						        <option value="06">Esmeraldas</option>
						        <option value="05">Galápagos</option>
						        <option value="04">Guayas</option>
						        <option value="06">Imbabura</option>
						        <option value="07">Loja</option>
						        <option value="05">Los Ríos</option>
						        <option value="05">Manabí</option>
						        <option value="07">Morona Santiago</option>
						        <option value="06">Napo</option>
						        <option value="06">Orellana</option>
						        <option value="03">Pastaza</option>
						        <option value="02">Pichincha</option>
						        <option value="04">Sta Elena</option>
						        <option value="02">Santo Domingo</option>
						        <option value="06">Sucumbios</option>
						        <option value="03">Tungurahua</option>
						        <option value="07">Zamora Chinchipe</option>
							    </select>
								<input type="text" id="provincia" style="display: none" onclick="test()" class="form-control"  required size="2">
								</div>
								</td>
								<td>
								<div class="col-md-6" onclick="prov()">
								<input type="tel" class="form-control" id="telef" name="telef" placeholder="Telefono" value="<?php if(isset($telef)) echo $telef; ?>" required pattern="[0-9]{7}" minlength="7" maxlength="7">
								</div>
								</td>
								</tr>
								</table>
								<div class="form-group" id="div2" style="display: none" onclick="editaTel()">
								<div class="col-md-3">
								<input type="text" class="form-control" size="10" id="telefono" name="telefono" value="<?php if(isset($telefono)) echo $telefono; ?>" required pattern="[0-9]{9}" minlength="9" maxlength="9">
								</div>
								</div>
							</div>
						
							<div class="form-group" onclick="muestratel()">
								<label for="direccion" class="col-md-3 control-label">Direccion</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="direccion" placeholder="Dirección" value="<?php if(isset($direccion)) echo $direccion; ?>" required pattern="^[a-zA-Z0-9 -.]*$" minlength="10" maxlength="40">
								</div>
							</div>
							<div class="form-group" onclick="muestratel()">
								<label for="genero" class="col-md-3 control-label">Genero:</label>
								<div class="col-md-9">
								<select class="form-control" id="genero" name="genero" onchange="genero()" required>
        						<option value="Masculino">Masculino</option>
								<option value="Femenino">Femenino</option>
								<option value="BiGenero">BiGenero</option>
								<option value="Cross–Dresser">Cross–Dresser</option>
								<option value="Drag-King">Drag-King</option>
								<option value="Drag-Queen">Drag-Queen</option>
								<option value="Androgino">Andrógino</option>
								<option value="Femme">Femme</option>
								<option value="Female to male">Female to male </option>
								<option value="Gender Bender">Gender Bender</option>
								<option value="Genderqueer">Genderqueer</option>
								<option value="Male to Female">Male to Female</option>
								<option value="No Op">No Op</option>
								<option value="Hijra">Hijra</option>
								<option value="Pangenero">Pangénero</option>
								<option value="Transexual">Transexual</option>
								<option value="Transpersona">Transpersona</option>
								<option value="Buch">Buch</option>
								<option value="Trans">Trans</option>
								<option value="Agender">Agender</option>
								<option value="Tercer Sexo">Tercer Sexo</option>
								<option value="Genero fluido">Género fluido</option>
								<option value="Transgenero no binario">Transgénero no binario</option>
								<option value="Hermafrodita">Hermafrodita</option>
								<option value="Genero Dotado">Género Dotado</option>
								<option value="Femme Queen">Femme Queen</option>
								<option value="Persona de experiencia Transgenero">Persona de experiencia Transgénero</option>
								</select>
								<input type="hidden" class="form-control" name="gen"  value="<?php if(isset($genero)) echo $genero; ?>">
								</div>
							</div>
							<div class="form-group" onclick="muestratel()">
								<label for="estado" class="col-md-3 control-label">Estado Civil:</label>
								<div class="col-md-9">
								<select class="form-control" id="est" name="estado" onchange="estado()"required>
        						<option value="solter@">Solter@</option>
								<option value="casad@">Casad@</option>
								<option value="divorciad@">Divorciad@</option>
								<option value="viud@">viud@</option>
								<option value="union de hecho">Union de hecho</option>
								</select>
								<input type="hidden" class="form-control" name="est"  value="<?php if(isset($estado)) echo $estado; ?>">
								</div>
							</div>
	<div class="form-group" onclick="muestratel()">
								<label for="celular" class="col-md-3 control-label">Celular</label>
								<div class="col-md-9">
									<input type="text" class="form-control" name="celular" placeholder="Celular" value="<?php if(isset($celular)) echo $celular; ?>" required pattern="^09[0-9]{8}" minlength="10" maxlength="10">
								</div>
							</div>

							<div class="form-group" onclick="muestratel()">
								<label for="estado" class="col-md-3 control-label">Ciudad:</label>
								<div class="col-md-9">
								<select class="form-control" id="ciu" name="ciudad" onchange="ciudad()"required>
        						<option value="Cuenca">Cuenca</option>
								<option value="Guaranda">Guaranda</option>
								<option value="Tulcan">Tulcán</option>
								<option value="Riobamba">Riobamba</option>
								<option value="Machala">Machala</option>
								<option value="Esmeraldas">Esmeraldas</option>
								<option value="Puerto Baquerizo Moreno">Puerto Baquerizo Moreno</option>
								<option value="Guayaquil">Guayaquil</option>
								<option value="Ibarra">Ibarra</option>
								<option value="Loja">Loja</option>
								<option value="Babahoyo">Babahoyo</option>
								<option value="Portoviejo">Portoviejo</option>
								<option value="Macas">Macas</option>
								<option value="Tena">Tena</option>
								<option value="Francisco de Orellana">Francisco de Orellana</option>
								<option value="Puyo">Puyo</option>
								<option value="Quito">Quito</option>
								<option value="Santa Elena">Santa Elena</option>
								<option value="Santo Domingo">Santo Domingo</option>
								<option value="Nueva Loja">Nueva Loja</option>
								<option value="Ambato">Ambato</option>
								<option value="Zamora">Zamora</option>
								
								</select>
								<input type="hidden" class="form-control" name="est"  value="<?php if(isset($estado)) echo $estado; ?>">
								</div>
							</div>
							
							<div class="form-group" onclick="muestratel()" >
								<label for="cedula" class="col-md-3 control-label">Cedula</label>
								<div class="col-md-9">
									<input type="text"  class="form-control" id="textocedula" name="cedula" placeholder="Cedula" value="<?php if(isset($cedula)) echo $cedula; ?>" required pattern="^[0-9]*$" maxlength="10" >
								</div>
							</div>
							<div class="form-group" onclick= "validarcedula()" >
								<label for="usuario" class="col-md-3 control-label">Usuario</label>
								<div class="col-md-9">
									<input type="text"  class="form-control" name="usuario"  placeholder="Usuario" value="<?php if(isset($usuario)) echo $usuario; ?>" required pattern="^[a-zA-Z0-9]*$" minlength="3" maxlength="10">
								</div>
							</div>
							
							<div class="form-group" onclick="muestratel()">
								<label for="password" class="col-md-3 control-label">Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="password" id="password" placeholder="Password" required minlength="5" maxlength="15">
									<!--[a-zA-Z0-9_*-.ñ$#?=¿'!|]-->
								</div>
							</div>
							
							<div class="form-group">
								<label for="con_password" class="col-md-3 control-label">Confirmar Password</label>
								<div class="col-md-9">
									<input type="password" class="form-control" name="con_password" placeholder="Confirmar Password" required minlength="5" maxlength="15" >
								</div>
							</div>
							
							<div class="form-group">
								<label for="email" class="col-md-3 control-label">Email</label>
								<div class="col-md-9">
									<input type="email" class="form-control" name="email" placeholder="Email" value="<?php if(isset($email)) echo $email; ?>" required>
								</div>
							</div>
							<div class="form-group">
								<label for="captcha" class="col-md-3 control-label"></label>
								<div class="g-recaptcha col-md-9" data-sitekey="6Lc7wb8UAAAAABGAHcOh9jjxkNfi83H8JRwltPjm"></div>
							</div>
							<div class="form-group">                                      
								<div class="col-md-offset-3 col-md-9">
									<button id="btn-signup" type="submit" class="btn btn-info"><i class="icon-hand-right"></i>Registrar</button> 
								</div>
							</div>
						</form>
						<?php 
						echo resultBlock($errors);
						 ?>
					</div>
				</div>
				<!--<div class="panel panel-inf" style="margin-top:50px">
				<div class="form-group" style="margin-left:10px">
				<label for="imagen">Escoja una imagen</label>
				<table>
				<tr><td><img src="img/ciudad1.jpg" width="200" height="100"></td>
				<td><img src="img/ciudad3.jpg" width="200" height="100"></td>
				<td><img src="img/ciudad2.jpg" width="200" height="100"></td>
				</tr></table>
				</div>
				</div>-->

			</div>
		</div>
	</body>
</html>													