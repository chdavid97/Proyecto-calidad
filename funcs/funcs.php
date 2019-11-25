<?php

$rand = range(0,9); 
					shuffle($rand); 
					foreach ($rand as $val) { 
						//echo "$val"; 
}
$g=$rand[3];

	function isNull($nombre,$apellido, $user, $pass, $pass_con, $email){
		if(strlen(trim($nombre)) < 1 ||strlen(trim($apellido)) < 1 || strlen(trim($user)) < 1 || strlen(trim($pass)) < 1 || strlen(trim($pass_con)) < 1 || strlen(trim($email)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	
	function isEmail($email)
	{
		if (filter_var($email, FILTER_VALIDATE_EMAIL)){
			return true;
			} else {
			return false;
		}
	}
	
	function validaPassword($var1, $var2)
	{
		if (strcmp($var1, $var2) !== 0){
			return false;
			} else {
			return true;
		}
	}
	
	function minMax($min, $max, $valor){
		if(strlen(trim($valor)) < $min)
		{
			return true;
		}
		else if(strlen(trim($valor)) > $max)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	
	function usuarioExiste($usuario)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE usuario = ? LIMIT 1");
		$stmt->bind_param("s", $usuario);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;
		}
	}
	
	function emailExiste($email)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id FROM usuarios WHERE correo = ? LIMIT 1");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		$stmt->close();
		
		if ($num > 0){
			return true;
			} else {
			return false;	
		}
	}
	
	function generateToken()
	{
		$gen = md5(uniqid(mt_rand(), false));	
		return $gen;
	}
	
	function hashPassword($password) 
	{
		$hash = password_hash($password, PASSWORD_DEFAULT);
		return $hash;
	}
	
	function resultBlock($errors){
		if(count($errors) > 0)
		{
			echo "<div id='error' class='alert alert-danger' role='alert'>
			<a href='#' onclick=\"showHide('error');\">[X]</a>
			<ul>";
			foreach($errors as $error)
			{
				echo "<li>".$error."</li>";
			}
			echo "</ul>";
			echo "</div>";
		}
	}
	
	function registraUsuario($usuario, $pass_hash, $nombre,$apellido, $FechaNac, $email, $activo, $token, $tipo_usuario,$celular,$ciudad,$genero,$estado,$cedula){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("INSERT INTO usuarios (usuario, password, nombre, apellido, FechaNac, correo, activacion, token, id_tipo,celular,ciudad,genero,estado,cedula) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?)");
		$stmt->bind_param('ssssssisiisssi', $usuario, $pass_hash, $nombre, $apellido, $FechaNac, $email, $activo, $token, $tipo_usuario,$celular,$ciudad,$genero,$estado,$cedula);
		
		if ($stmt->execute()){
			return $mysqli->insert_id;
			} else {
			return 0;	
		}		
	}
	
	function enviarEmail($email, $nombre, $asunto, $cuerpo){
		require 'PHPMailer/PHPMailerAutoload.php';

    //create an instance of PHPMailer
    $mail = new PHPMailer();

    //set a host
    $mail->Host = "smtp.gmail.com";

    //enable SMTP
    $mail->isSMTP();
    //$mail->SMTPDebug = 2;

    //set authentication to true
    $mail->SMTPAuth = true;

    //set login details for Gmail account
    $mail->Username = "@gmail.com";
    $mail->Password = "";

    //set type of protection
    $mail->SMTPSecure = "ssl"; //or we can use TLS

    //set a port
    $mail->Port = '465'; //or 587 if TLS

    //set subject
    $mail->Subject = $asunto;

    //set HTML to true
    $mail->isHTML(true);

    //set body
    $mail->Body = $cuerpo;

    //add attachment
	
/*	$mail->addAttachment('attachment/fbcover.png', 'Facebook cover.png');
	$mail->addAttachment('attachment/fbcover.png', 'Facebook cover.png');*/

    //set who is sending an email
    $mail->setFrom('@gmail.com','Sistema de Usuarios');

    //set where we are sending email (recipients)
    $mail->addAddress($email, $nombre);

	//send an email
	if($mail->send())
		return true;
		else
		return false;
	}
	
	function validaIdToken($id, $token){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token = ? LIMIT 1");
		$stmt->bind_param("is", $id, $token);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			$stmt->bind_result($activacion);
			$stmt->fetch();
			
			if($activacion == 1){
				$msg = "La cuenta ya se activo anteriormente.";
				} else {
				if(activarUsuario($id)){
					$msg = 'Cuenta activada.';
					} else {
					$msg = 'Error al Activar Cuenta';
				}
			}
			} else {
			$msg = 'No existe el registro para activar.';
		}
		return $msg;
	}
	
	function activarUsuario($id)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET activacion=1 WHERE id = ?");
		$stmt->bind_param('s', $id);
		$result = $stmt->execute();
		$stmt->close();
		return $result;
	}
	
	function isNullLogin($usuario, $password){
		if(strlen(trim($usuario)) < 1 || strlen(trim($password)) < 1)
		{
			return true;
		}
		else
		{
			return false;
		}		
	}
	
	function login($usuario, $password)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id, id_tipo, password FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param("ss", $usuario, $usuario);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			
			if(isActivo($usuario)){
				
				$stmt->bind_result($id, $id_tipo, $passwd);
				$stmt->fetch();
				
				$validaPassw = password_verify($password, $passwd);
				
				if($validaPassw){
					
					lastSession($id);
					$_SESSION['id_usuario'] = $id;
					$_SESSION['tipo_usuario'] = $id_tipo;
					
					header("location: welcome.php");
					} else {
					
					$errors = "La contrase&ntilde;a es incorrecta";
				}
				} else {
				$errors = 'El usuario no esta activo';
			}
			} else {
			$errors = "El nombre de usuario o correo electr&oacute;nico no existe";
		}
		return $errors;
	}
	
	function lastSession($id)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET last_session=NOW(), token_password='', password_request=1 WHERE id = ?");
		$stmt->bind_param('s', $id);
		$stmt->execute();
		$stmt->close();
	}
	
	function isActivo($usuario)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param('ss', $usuario, $usuario);
		$stmt->execute();
		$stmt->bind_result($activacion);
		$stmt->fetch();
		
		if ($activacion == 1)
		{
			return true;
		}
		else
		{
			return false;	
		}
	}	
	
	function generaTokenPass($user_id)
	{
		global $mysqli;
		
		$token = generateToken();
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET token_password=?, password_request=1 WHERE id = ?");
		$stmt->bind_param('ss', $token, $user_id);
		$stmt->execute();
		$stmt->close();
		
		return $token;
	}
	
	function getValor($campo, $campoWhere, $valor)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT $campo FROM usuarios WHERE $campoWhere = ? LIMIT 1");
		$stmt->bind_param('s', $valor);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($_campo);
			$stmt->fetch();
			return $_campo;
		}
		else
		{
			return null;	
		}
	}
	
	function getPasswordRequest($id)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT password_request FROM usuarios WHERE id = ?");
		$stmt->bind_param('i', $id);
		$stmt->execute();
		$stmt->bind_result($_id);
		$stmt->fetch();
		
		if ($_id == 1)
		{
			return true;
		}
		else
		{
			return null;	
		}
	}
	
	function verificaTokenPass($user_id, $token){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT activacion FROM usuarios WHERE id = ? AND token_password = ? AND password_request = 1 LIMIT 1");
		$stmt->bind_param('is', $user_id, $token);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($activacion);
			$stmt->fetch();
			if($activacion == 1)
			{
				return true;
			}
			else 
			{
				return false;
			}
		}
		else
		{
			return false;	
		}
	}
	
	function cambiaPassword($password, $user_id, $token){
		
		global $mysqli;
		
		$stmt = $mysqli->prepare("UPDATE usuarios SET password = ?, token_password='', password_request=0 WHERE id = ? AND token_password = ?");
		$stmt->bind_param('sis', $password, $user_id, $token);
		
		if($stmt->execute()){
			return true;
			} else {
			return false;		
		}
	}
	function verification($usuario){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT correo FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param('ss', $usuario, $usuario);
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($_correo);
			$stmt->fetch();
			return $_correo;
		}
		else
		{
			return null;	
		}
	}	
	function guarda_cla($d, $e, $f, $user){
		
		global $mysqli;
		$stmt = $mysqli->prepare("UPDATE claves SET rand_uno = ?, rand_dos = ?, rand_tres = ?, user=?");		
		$stmt->bind_param('iiis', $d, $e, $f, $user);
		
		if($stmt->execute()){
			return true;
			} else {
			return false;		
		}
	}		
	
	function consulta_clave($correo){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT rand_uno,rand_dos,rand_tres FROM claves WHERE user = ? LIMIT 1");
		$stmt->bind_param('s', $correo );
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($r1,$r2,$r3);
			$stmt->fetch();
		
			for ($i=0; $i < 10 ; $i++) { 
				if($r1==$i){
					$file1='img/ln'.$i.'.jpg';
					//echo $file1;
				}
				if( $r2==$i) {
					$file2='img/ln'.$i.'.jpg';
					//$file2="\AAA\login\img\ln".$i.".jpg";
					//echo $file2;
				}
				if ( $r3==$i) {
					$file3='img/ln'.$i.'.jpg';
					//echo $file3;
				}
			}	
		$asunto= 'Verificar inicio de sesion';
    	$cuerpo = "Estimado $correo : <br /><br /> ingrese las siguientes imagenes para su logueo exitoso <br />"/*.'<img src="cid:edificio">'*/;
		//$img=$_FILES[$file1]["name"];
    		if(enviarEmailF($correo, $correo, $asunto, $cuerpo,$file1,$file2,$file3)){
				global $g;
			echo	"<div class='overlay active' id='overlay'>;";
			echo "<div class='popup active' id='popup'>";
			echo "<center><label><h3>Siga las instrucciones que le hemos enviado al correo electrónico $correo:</label>";
			echo "<br><center><a href= 'test.php?id=$correo&rand=$g'>Continuar con verificación</a></center>";
			echo "</div>";
			echo "</div>";
			echo "</center>";
				exit;

    		} else {
    			$errors[]= "error al enviar correo";
    		}
						}
			return $errors;
	}
	function valida_clave($correo){
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT rand_uno,rand_dos,rand_tres FROM claves WHERE user = ? LIMIT 1");
		$stmt->bind_param('s', $correo );
		$stmt->execute();
		$stmt->store_result();
		$num = $stmt->num_rows;
		
		if ($num > 0)
		{
			$stmt->bind_result($r1,$r2,$r3);
			$stmt->fetch();
			
			$clave= array("$r1", "$r2", "$r3");
			
		}
			return $clave;
	}
	function isNullVect($n1,$n2,$n3){
		if(strlen(trim($n1)) < 1 ||strlen(trim($n2)) < 1 || strlen(trim($n3)) < 1)
		{
			return true;
			} else {
			return false;
		}		
	}
	
	function lg($usuario, $password)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id, id_tipo, password, correo FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param("ss", $usuario, $usuario);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			
			if(isActivo($usuario)){
				
				$stmt->bind_result($id, $id_tipo, $passwd,$correo);
				$stmt->fetch();
				
				$validaPassw = password_verify($password, $passwd);
				
				if($validaPassw){
					
					global $rand;
					$d=$rand[0];
					$e=$rand[1];
					$f=$rand[2];

		
					if (guarda_cla($d, $e, $f,$correo)){
						$errors[]= consulta_clave($correo);
						} else {
						$errors[]= "error al guardar la clave";
						}
				} else {
					$errors = "La contrase&ntilde;a es incorrecta";
				}
				} else {
				$errors = 'El usuario no esta activo';
			}
			} else {
			$errors = "El nombre de usuario o correo electr&oacute;nico no existe";
		}
		return $errors;
	}

	function loginFinal($usuario)
	{
		global $mysqli;
		
		$stmt = $mysqli->prepare("SELECT id, id_tipo FROM usuarios WHERE usuario = ? || correo = ? LIMIT 1");
		$stmt->bind_param("ss", $usuario, $usuario);
		$stmt->execute();
		$stmt->store_result();
		$rows = $stmt->num_rows;
		
		if($rows > 0) {
			
			if(isActivo($usuario)){
				
				$stmt->bind_result($id, $id_tipo);
				$stmt->fetch();
									
					lastSession($id);
					$_SESSION['id_usuario'] = $id;
					$_SESSION['tipo_usuario'] = $id_tipo;
					
					header("location: welcome.php");
					
				} else {
				$errors = 'El usuario no esta activo';
			}
			} else {
			$errors = "El nombre de usuario o correo electr&oacute;nico no existe";
		}
		return $errors;
	}
	function enviarEmailF($email, $nombre, $asunto, $cuerpo,$file1,$file2,$file3){
		require 'PHPMailer/PHPMailerAutoload.php';

    //create an instance of PHPMailer
    $mail = new PHPMailer();

    //set a host
    $mail->Host = "smtp.gmail.com";

    //enable SMTP
    $mail->isSMTP();
    //$mail->SMTPDebug = 2;

    //set authentication to true
    $mail->SMTPAuth = true;

    //set login details for Gmail account
    $mail->Username = "@gmail.com";
    $mail->Password = "";

    //set type of protection
    $mail->SMTPSecure = "ssl"; //or we can use TLS

    //set a port
    $mail->Port = '465'; //or 587 if TLS

    //set subject
    $mail->Subject = $asunto;

    //set HTML to true
    $mail->isHTML(true);

    //set body
    $mail->Body = $cuerpo;

    //add attachment
	$mail->addAttachment($file1,'Pieza 1');
	$mail->addAttachment($file2, 'Pieza 2');
	$mail->addAttachment($file3, 'Pieza 3');
/*	$mail->addAttachment('attachment/fbcover.png', 'Facebook cover.png');
	$mail->addAttachment('attachment/fbcover.png', 'Facebook cover.png');*/

    //set who is sending an email
    $mail->setFrom('@gmail.com','Sistema de Usuarios');

    //set where we are sending email (recipients)
    $mail->addAddress($email, $nombre);

	//send an email
	if($mail->send())
		return true;
		else
		return false;
    /*if ($mail->send())
        echo "mail is sent";
    else
        echo $mail->ErrorInfo;*/
		/*require_once 'PHPMailer/PHPMailerAutoload.php';
		
		$mail = new PHPMailer();
		 $mail->isSMTP();
		 $mail->SMTPAuth = true;
		 $mail->SMTPSecure = 'tls';
		 $mail->Host = 'smtp.gmail.com';
		 $mail->Port = '587';
		
		 $mail->Username = 'tu_correo@gmail.com';
		 $mail->Password = 'clave_correo';
		
		$mail->setFrom('tu_correo@gmail.com', 'Sistema de Usuarios');
		$mail->addAddress($email, $nombre);

//		$mail->addAttachment(path '/AAA/login/img/ln1.jpg', name ' london.jpg');
		//$ruta=/AAA/login/img;
//		$mail->addEmbeddedImage(dirname(__FILE__).'/ln1.jpg','edificio');
		

		$mail->Subject = $asunto;
		$mail->Body    = $cuerpo;
//		$mail->addEmbeddedImage(dirname(__FILE__).'/ln1.jpg','edificio');
		$mail->addAttachment('AAA/login/img/ln1.jpg','london.jpg');
//		$mail->addEmbeddedImage('/AAA/login/img/ln1.jpg','edificio');
		$mail->IsHTML(true);
		
		if($mail->send())
		return true;
		else
		return false;*/
	}
	
?>
<html lang="en">
<head>
	
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,400,600|Open+Sans" rel="stylesheet"> 
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.5.0/css/all.css">
	<link rel="stylesheet" href="css2/estilos.css">
	<title>Ventana Emergente Animada</title>
</head>
<body>
<script src="css2/popup.js"></script>
</body>
</html>
