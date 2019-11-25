<?php
session_start();
//unset($_COOKIE['access_error']);
$cero=1;
setcookie('access_error', 1 , time() + 365 * 24 * 60 * 60);

require 'funcs/conexion.php';
require 'funcs/funcs.php';
define( 'MAX_SESSION_TIEMPO', 10 * 1 );

// Controla cuando se ha creado y cuando tiempo ha recorrido 
if ( isset( $_SESSION[ 'ULTIMA_ACTIVIDAD' ] ) && 
     ( time() - $_SESSION[ 'ULTIMA_ACTIVIDAD' ] > MAX_SESSION_TIEMPO ) ) {

    // Si ha pasado el tiempo sobre el limite destruye la session
    destruir_session();
}

$_SESSION[ 'ULTIMA_ACTIVIDAD' ] = time();

// Función para destruir y resetear los parámetros de sesión
function destruir_session() {

    $_SESSION = array();
    if ( ini_get( 'session.use_cookies' ) ) {
        $params = session_get_cookie_params();
        setcookie(
            session_name(),
            '',
            time() - MAX_SESSION_TIEMPO,
            $params[ 'path' ],
            $params[ 'domain' ],
            $params[ 'secure' ],
            $params[ 'httponly' ] );
    }

    @session_destroy();
}
if (isset($_GET["id"])) {

	# code...
    $correo = $_GET['id'];
    $randmag = $_GET['rand'];
    $vectorClaves=valida_clave($correo);
    
    /*for ($i=0; $i < 10 ; $i++) { 
        if($vectorClaves[0]==$i){
            $file1="<img src=\"\AAA\login\img\ln".$i.".jpg\" width=\"150\" height=\"150\"/>";
            echo $file1;
        }
        if( $vectorClaves[1]==$i) {
            $file2="<img src=\"\AAA\login\img\ln".$i.".jpg\" width=\"150\" height=\"150\"/>";
            echo $file2;
        }
        if ( $vectorClaves[2]==$i) {
            $file3="<img src=\"\AAA\login\img\ln".$i.".jpg\" width=\"150\" height=\"150\"/>";
            echo $file3;
        }
    }*/
    //$file1="<img src=\"\AAA\login\img\ln4.jpg\" width=\"150\" height=\"150\"/>";
    /* foreach ($vectorClaves as $clave) {
        echo "$clave";
    }*/ 
if ($_POST){
if (!empty($_POST)) {
	# code...
	$n1 = (int)($_POST['caja_valor']);
	$n2 = (int)($_POST['caja_valor2']);
    $n3 = (int)($_POST['caja_valor3']);
    
    if ( $n1 == $vectorClaves[0] && $n2 == $vectorClaves[1] && $n3 == $vectorClaves[2] ) {
        $reset=0;
        setcookie ('access_error',$reset,time()-1);
        $errors[]= loginFinal($correo);
        
        
        
        //session_destroy();
    } else{
        
if (isset($_COOKIE['access_error']) && $_COOKIE['access_error'] == 3 ){
    echo "<script type=\"text/javascript\">alert(\"demasiados intentos\");</script>";
    $zero=0;
    setcookie('access_error',$zero);
    session_destroy();    
    header("location:index.php");    
} elseif (isset($_COOKIE['access_error']) && $_COOKIE['access_error'] < 3 ){

     //$_COOKIE['access_error'];
        setcookie('access_error',$_COOKIE['access_error']+1);
        $cont=$_COOKIE['access_error'];
        $contador= 3-$cont;
        echo "<script type=\"text/javascript\">alert(\"Se permite $contador intento(s) más \");</script>";
        }
        
          
        }
           
} else {
    echo "Datos vacios";
}
}

}else{

    header("location:index.php");
}
/*$rand = range(0,9); 
shuffle($rand); 
foreach ($rand as $val) { 
    echo "$val"; 
}*/
?>
<html>
<head>
<style>
.objects {
    display:inline-block;
    border: #DFBC6A 1px solid;
    width: 80px; 
    height: 80px;
    box-shadow: 2px 2px 2px #999;
    cursor: move;
    margin: 10px;
}
div[id ^='1']:after {content: " " }
div[id ^='2']:after {content: " " }
div[id ^='3']:after {content: " " }
div[id ^='4']:after {content: " " }
div[id ^='5']:after {content: " " }
div[id ^='6']:after {content: " " }
div[id ^='7']:after {content: " " }
div[id ^='8']:after {content: " " }
div[id ^='9']:after {content: " " }
div[id ^='0']:after {content: " " }
#dz1 {
    /*background-color: #EEE;*/
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln1.jpg');
    background-size: cover;
    
}
#dz2 {
    /*background-color: #EEE;*/
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln2.jpg');
    background-size: cover;
}
#dz3 {
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln3.jpg');
    background-size: cover;
}
#dz4 {
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln4.jpg');
    background-size: cover;
}
#dz5 {
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln5.jpg');
    background-size: cover;
}
#dz6 {
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln6.jpg');
    background-size: cover;
}
#dz7 {
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln7.jpg');
    background-size: cover;
}
#dz8 {
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln8.jpg');
    background-size: cover;
}
#dz9 {
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln9.jpg');
    background-size: cover;
}
#dz0 {
    border: #999 1px solid;
    width: 110px; 
    height: 110px;
    background-image: url('/AAA/login/img/ln0.jpg');
    background-size: cover;
}
#container {
    background-color: -webkit-linear-gradient(to right, #333333, #dd1818); 
    border: #999 1px solid;
    width: 530px; 
    height: 210px;
    margin: 50px;
}
#container2 {
    background-image: url('/AAA/login/img/Londres-e.jpg');
    background-repeat: no-repeat;
    background-position: center;
    width: 583px;
    height: 291px;
    border: 2px dashed #333;
}
div[id ^='dz1'] div[id ^='1'] {background-image: url('/AAA/login/img/ln1.jpg'); 
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='1']:after {font-size: 20px;                }
div[id ^='dz1'] div[id ^='2'] {background-image: url('/AAA/login/img/ln1.jpg'); 
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='2']:after {font-size: 20px;            }
div[id ^='dz1'] div[id ^='3'] {background-image: url('/AAA/login/img/ln1.jpg'); 
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='3']:after {font-size: 20px;            }
div[id ^='dz1'] div[id ^='4'] {background-image: url('/AAA/login/img/ln1.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='4']:after {font-size: 20px;            }
div[id ^='dz1'] div[id ^='5'] {background-image: url('/AAA/login/img/ln1.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='5']:after {font-size: 20px;           }
div[id ^='dz1'] div[id ^='6'] {background-image: url('/AAA/login/img/ln1.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='6']:after {font-size: 20px;           }
div[id ^='dz1'] div[id ^='7'] {background-image: url('/AAA/login/img/ln1.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='7']:after {font-size: 20px;           }
div[id ^='dz1'] div[id ^='8'] {background-image: url('/AAA/login/img/ln1.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='8']:after {font-size: 20px;            }
div[id ^='dz1'] div[id ^='9'] {background-image: url('/AAA/login/img/ln1.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='9']:after {font-size: 20px;            }
div[id ^='dz1'] div[id ^='0'] {background-image: url('/AAA/login/img/ln1.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz1'] div[id ^='0']:after {font-size: 20px;           }
/*zona2*/
div[id ^='dz2'] div[id ^='1'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='1']:after {font-size: 20px;            }
div[id ^='dz2'] div[id ^='2'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='2']:after {font-size: 20px;            }
div[id ^='dz2'] div[id ^='3'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='3']:after {font-size: 20px;            }
div[id ^='dz2'] div[id ^='4'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='4']:after {font-size: 20px;            }
div[id ^='dz2'] div[id ^='5'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='5']:after {font-size: 20px;            }
div[id ^='dz2'] div[id ^='6'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz2'] div[id ^='7'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz2'] div[id ^='8'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz2'] div[id ^='9'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz2'] div[id ^='0'] {background-image: url('/AAA/login/img/ln2.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz2'] div[id ^='0']:after {font-size: 20px;               }
/* zona3*/
div[id ^='dz3'] div[id ^='1'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='1']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='2'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='2']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='3'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='3']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='4'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='4']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='5'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='5']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='6'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='7'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='8'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='9'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz3'] div[id ^='0'] {background-image: url('/AAA/login/img/ln3.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz3'] div[id ^='0']:after {font-size: 20px;               }
/*zona 4*/
div[id ^='dz4'] div[id ^='1'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 111px;                 height: 111px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='1']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='2'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 111px;                 height: 111px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='2']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='3'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 111px;                 height: 111px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='3']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='4'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 111px;                 height: 111px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='4']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='5'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 111px;                 height: 111px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='5']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='6'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 111px;                 height: 111px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='7'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 111px;                 height: 111px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='8'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='9'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz4'] div[id ^='0'] {background-image: url('/AAA/login/img/ln4.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz4'] div[id ^='0']:after {font-size: 20px;               }
/* ZONA 5*/
div[id ^='dz5'] div[id ^='1'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='1']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='2'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='2']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='3'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='3']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='4'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='4']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='5'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='5']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='6'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='7'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='8'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='9'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz5'] div[id ^='0'] {background-image: url('/AAA/login/img/ln5.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz5'] div[id ^='0']:after {font-size: 20px;               }
            /*ZONA 6*/
div[id ^='dz6'] div[id ^='1'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='1']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='2'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='2']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='3'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='3']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='4'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='4']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='5'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='5']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='6'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='7'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='8'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='9'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz6'] div[id ^='0'] {background-image: url('/AAA/login/img/ln6.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz6'] div[id ^='0']:after {font-size: 20px;               }
/* ZONA 7*/
div[id ^='dz7'] div[id ^='1'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='1']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='2'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='2']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='3'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='3']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='4'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='4']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='5'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='5']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='6'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='7'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='8'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='9'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz7'] div[id ^='0'] {background-image: url('/AAA/login/img/ln7.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz7'] div[id ^='0']:after {font-size: 20px;               }
            /*zona 8*/
div[id ^='dz8'] div[id ^='1'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='1']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='2'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='2']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='3'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='3']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='4'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='4']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='5'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='5']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='6'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='7'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='8'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='9'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz8'] div[id ^='0'] {background-image: url('/AAA/login/img/ln8.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz8'] div[id ^='0']:after {font-size: 20px;               }
/* zona 9*/
div[id ^='dz9'] div[id ^='1'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='1']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='2'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='2']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='3'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='3']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='4'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='4']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='5'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='5']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='6'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='7'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='8'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='9'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz9'] div[id ^='0'] {background-image: url('/AAA/login/img/ln9.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz9'] div[id ^='0']:after {font-size: 20px;               }
            /*zona 0*/
div[id ^='dz0'] div[id ^='1'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='1']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='2'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='2']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='3'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='3']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='4'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='4']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='5'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='5']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='6'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='6']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='7'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='7']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='8'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='8']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='9'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='9']:after {font-size: 20px;               }
div[id ^='dz0'] div[id ^='0'] {background-image: url('/AAA/login/img/ln0.jpg');background-size: cover;
                width: 110px;                 height: 110px;                margin: 0px;            }
            div[id ^='dz0'] div[id ^='0']:after {font-size: 20px;                }

</style>
<script>
function _(id){
   return document.getElementById(id);	
}
var droppedIn = false;
function drag_start(event) {
    event.dataTransfer.dropEffect = "move";
    event.dataTransfer.setData("text", event.target.getAttribute('id') );
}
function drag_drop(event) {
    event.preventDefault(); /* Prevent undesirable default behavior while dropping */
    var elem_id = event.dataTransfer.getData("text");
    event.target.appendChild( _(elem_id) );
    _(elem_id).style.cursor = "default";
}
function readDropZone(){

    var x= <?php echo $vectorClaves[0];?>;
  var y= <?php echo $vectorClaves[1];?>;
  var z= <?php echo $vectorClaves[2];?>;
  var mag= <?php echo $randmag;?>;
  
  var div='dz';
  var divx=div+x;
  var divy=div+y;
  var divz=div+z;
  var divmag=div+mag;

     let a = 0;
     let b = 0;
     let c = 0;
     let vect=[];
    for(var i=0; i < _(divx).children.length; i++){
        a= _(divx).children[i].id;
        if (a.length > 1  ) {
        alert("coloque una sola pieza");
        location.reload();
        }       else{
        vect[0] = a; }
    } 
    for(var i=0; i < _(divy).children.length; i++){
        b= _(divy).children[i].id;
        if ( b.length > 1  ) {
        alert("coloque una sola pieza");
        location.reload();
        }       else{
            vect[1] = b; }
    }  
    /*for(var i=0; i < _("dz2").children.length; i++){
        b= _("dz2").children[i].id;
        if (b.length < 1 || b.length > 1  ) {
        alert("ingrese 1 valor");
        location.reload();
        }       else{
            vect[1] = b; }
    } */
    for(var i=0; i < _(divz).children.length; i++){
        c= _(divz).children[i].id;
        if (c.length > 1  ) {
        alert("coloque una sola pieza");
        location.reload();
        }       else{
            vect[2] = c; }
    }
    if (vect.length < 3 || vect.length > 3  ) {
        console.log(vect);
        alert("ingrese las tres piezas correspondientes");
        location.reload();
        }       else{
        _("caja_valor").value = vect[0];
        _("caja_valor2").value = vect[1];
        _("caja_valor3").value = vect[2];
        document.getElementById('oculto').style.display = 'block';
        _('btn_1').style.display = 'none';
        _('btn-login').style.display = 'inline'; 
        }
}
function allowDrop(event) {
  event.preventDefault();
}
function aparece() {
  var x= <?php echo $vectorClaves[0];?>;
  var y= <?php echo $vectorClaves[1];?>;
  var z= <?php echo $vectorClaves[2];?>;
  var mag= <?php echo $randmag;?>;
  
  var div='dz';
  var divx=div+x;
  var divy=div+y;
  var divz=div+z;
  var divmag=div+mag;


    _(divx).style.backgroundImage="url('/AAA/login/img/incognita.jpg')";
    _(divy).style.backgroundImage="url('/AAA/login/img/incognita.jpg')";
    _(divz).style.backgroundImage="url('/AAA/login/img/incognita.jpg')";
    _(divmag).style.backgroundImage="url('/AAA/login/img/incognita.jpg')";

    
}
</script>

</head>
<body onload="aparece()">
<h1 align="center">Verificación de Seguridad</h1>
<center>
<section id="container2" >
<table>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td><div id="dz1" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
        <td><div id="dz2" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
        <td><div id="dz3" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
        <td><div id="dz4" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
        <td><div id="dz5" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
    </tr>
    <tr>
        <td><br></td>
    </tr>
    <tr>
        <td><div id="dz6" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
        <td><div id="dz7" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
        <td><div id="dz8" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
        <td><div id="dz9" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
        <td><div id="dz0" ondrop="drag_drop(event)" ondragover="allowDrop(event)" ></div></td>
    </tr>
</table>
</section>
<br>
<hr>

<button align="center" id="btn_1" onclick="readDropZone()">Guardar</button>
<form id="loginform" class="form-horizontal" role="form" action="<?php $_SERVER['PHP_SELF'] ?>" method="POST" autocomplete="off">
<input type="hidden" name="caja_valor" id="caja_valor" value="" size="1">
<input type="hidden" name="caja_valor2" id="caja_valor2" value="" size="1">
<input type="hidden" name="caja_valor3" id="caja_valor3" value="" size="1">
<div id="oculto" style="display: none">
<button id="btn-login" type="submit" class="btn btn-success">Verificar</button>
</div>
<hr>
<section id="container" ondrop="drag_drop(event)" ondragover="allowDrop(event)" >
<table>
    <tr>
        <td><div id="<?php echo $rand[0]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[0]; ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"></div></td>
        <td><div id="<?php echo $rand[1]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[1] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
        <td><div id="<?php echo $rand[2]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[2] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
        <td><div id="<?php echo $rand[3]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[3] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
        <td><div id="<?php echo $rand[4]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[4] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
    </tr>
    <tr>
        <td><div id="<?php echo $rand[5]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[5] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
        <td><div id="<?php echo $rand[6]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[6] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
        <td><div id="<?php echo $rand[7]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[7] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
        <td><div id="<?php echo $rand[8]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[8] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
        <td><div id="<?php echo $rand[9]; ?>" style="background-image: url('/AAA/login/img/ln<?php echo $rand[9] ?>.jpg'); background-size: cover;" class="objects" draggable="true" ondragstart="drag_start(event)"  ></div></td>
    </tr>
</table>
</section>
</center>
</body>
</html>