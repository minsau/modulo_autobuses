<?php
session_start();
$path = 'lib/';

function agregarCamion($path,$id,$nombre,$lugares,$horario){
  require_once($path."baseDatos/conexion.php");
  $sql = "INSERT INTO Autobus VALUES (null,'$id','$nombre','$lugares',now(),'$horario')";
  $res = mysqli_query($conexion, $sql) or die ("error al insertar "+mysqli_error($conexion));
  $data = [];
  if($res){
    $data['hecho'] = 1;
    $data['mensaje'] = "Autobus agregado";
  }else{
    $data['hecho'] = -1;
    $data['mensaje'] = "Hubo un problema al guardar los datos";
  }
  return $data;
}

function obtenerSesion($path){
  require_once($path."baseDatos/conexion.php");
  $data = [];
  if(!$_SESSION){
    $data['hecho'] = -1;
    $data['mensaje'] = 'Usted no esta logueado,sera redireccionado';
  }else{
    $data['hecho'] = 1;
    $data['mensaje'] = 'Bienvenido';
    $data['id'] = $_SESSION['id'];
    $data['user'] = $_SESSION['user'];
    $sql = "SELECT * FROM Usuario WHERE id = '".$data['id']."'";
    $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_connect_error());
    if($reg = mysqli_fetch_array($res)){
      $data['nombre'] = $reg['nombre']." ".$reg['aPaterno']." ".$reg['aMaterno'];
    }
  }

  return $data;
}

function login($path,$user,$pass){
  date_default_timezone_set('America/Mexico_City');
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT * FROM Usuario WHERE user = '$user' and password = '$pass'";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_connect_error());
  $data = [];
  if(mysqli_num_rows($res)==1){
    if($reg = mysqli_fetch_array($res)){
      $data['hecho'] = 1;
      $data['mensaje'] = 'Se ha logueado correctamente';
      $_SESSION['id'] = $reg['id'];
      $_SESSION['user'] = $user;
    }
  }else{
    $data['hecho'] = -1;
    $data['mensaje'] = 'No se encontro la combinación usuario/contraseña';
  }

  return $data;
}

function validarSesion($idLugar,$idUsuario){
  require_once("static/conexion.php");
  $sql = "SELECT * FROM Permiso WHERE idLugar = '$idLugar' and idUsuario = '$idUsuario'";
  $res = mysqli_query($con, $sql) or die ("error al consultar "+mysqli_connect_error());
  $data = [];
  if($reg = mysqli_fetch_array($res)){
    if($reg['estado'] == 0){
      $data['permitido'] = -1;
    }else{
      $data['permitido'] = 1;
    }
  }

  return $data;
}

function obtenerMisAutobuses($path,$id){
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT * FROM Autobus WHERE propietario = '$id'";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];

  while($reg = mysqli_fetch_assoc($res)){
    $data[] = $reg;
  }

  return $data;
}

function personas($path,$id){
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT * FROM Usuario WHERE id != '$id'";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];

  while($reg = mysqli_fetch_assoc($res)){
    $data[] = $reg;
  }

  return $data;
}
function addInteraccion($path,$bus,$emisor,$receptor,$tipo){
  require_once($path."baseDatos/conexion.php");
  $sql = "INSERT INTO Interaccion (id,userEmisor,userReceptor,autobus,tipo,fechaCreacion,fechaActualizacion) VALUES (null,'$emisor','$receptor','$bus','$tipo',now(),now())";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];
  if($res){
    $data['hecho'] = 1;
    $data['mensaje'] = "interacion guardada";
  }else{
    $data['hecho'] = -1;
    $data['mensaje'] = "Hubo un problema al guardar los datos";
  }
  return $data;
}

function getTripulantes($path,$bus,$id){
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT a.id as inte,a.autobus,b.id,b.nombre,b.aPaterno,b.aMaterno,a.estado,a.tipo FROM Interaccion as a, Usuario as b WHERE a.autobus = '$bus' and  (a.userEmisor = b.id or a.userReceptor=b.id) and b.id != '$id'";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];

  while($reg = mysqli_fetch_assoc($res)){
    $data[] = $reg;
  }

  return $data;
}

function buscar($path,$cadena){
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT * FROM Usuario WHERE nombre LIKE '%".$cadena."%' or aPaterno  LIKE '%".$cadena."%' or aPaterno  LIKE '%".$cadena."%' ";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];

  while($reg = mysqli_fetch_assoc($res)){
    $data[] = $reg;
  }

  return $data;
}

function getNumeroSolicitudes($path,$id){
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT count(id) as s FROM Interaccion WHERE userReceptor = '$id' and  tipo = 'Solicitud' and estado='Pendiente'";
  //echo "$sql";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];
  if($res){
    if($reg = mysqli_fetch_assoc($res)){
      $data[] = $reg;
      $data['hecho'] = 1;
      $data['mensaje'] = "Solicitudes obtenidas";
    }

  }else{
    $data['hecho'] = -1;
    $data['mensaje'] = "Hubo un problema al guardar los datos";
  }

  return $data;
}

function getNumeroInvitaciones($path,$id){
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT count(id) as s FROM Interaccion WHERE userReceptor = '$id' and  tipo = 'Invitacion' and estado='Pendiente'";
  //echo "$sql";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];
  if($res){
    if($reg = mysqli_fetch_assoc($res)){
      $data[] = $reg;
      $data['hecho'] = 1;
      $data['mensaje'] = "Solicitudes obtenidas";
    }

  }else{
    $data['hecho'] = -1;
    $data['mensaje'] = "Hubo un problema al guardar los datos";
  }

  return $data;
}

function getSolicitudes($path,$id){
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT a.id as inte,a.autobus,b.id,b.nombre,b.aPaterno,b.aMaterno,a.estado,a.tipo FROM Interaccion as a, Usuario as b WHERE  a.userEmisor=b.id and a.userReceptor='$id' and b.id != '$id' and a.tipo = 'Solicitud' and a.estado='Pendiente'";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];
  if($res){
    while($reg = mysqli_fetch_assoc($res)){
      $data[] = $reg;
    }
  }else{
    $data['hecho'] = -1;
    $data['mensaje'] = "Hubo un problema al guardar los datos";
  }

  return $data;
}

function getInvitaciones($path,$id){
  require_once($path."baseDatos/conexion.php");
  $sql = "SELECT a.id as inte,a.autobus,b.id,b.nombre,b.aPaterno,b.aMaterno,a.estado,a.tipo FROM Interaccion as a, Usuario as b WHERE  a.userEmisor=b.id and a.userReceptor='$id' and b.id != '$id' and a.tipo = 'Invitacion' and a.estado='Pendiente'";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];
  if($res){
    while($reg = mysqli_fetch_assoc($res)){
      $data[] = $reg;
    }
  }else{
    $data['hecho'] = -1;
    $data['mensaje'] = "Hubo un problema al guardar los datos";
  }

  return $data;
}

function cambiarEstado($path,$id,$estado){
  require_once($path."baseDatos/conexion.php");
  $sql = "UPDATE Interaccion set estado = '$estado' WHERE id = '$id'";
  $res = mysqli_query($conexion, $sql) or die ("error al consultar "+mysqli_error($conexion));
  $data = [];
  if($res){
      $data['hecho'] = 1;
      $data['mensaje'] = "Solicitud aprobada";
  }else{
    $data['hecho'] = -1;
    $data['mensaje'] = "Hubo un problema al guardar los datos";
  }

  return $data;
}

function destruir(){
  $data['mensaje'] = "Sesion destruida";
  session_destroy();
  return $data;
}



$data = json_decode(file_get_contents('php://input'), true);

$op = $data['op'];
if($op == 0){
  $id = $data['propietario'];
  $nombre = $data['nombre'];
  $lugares = $data['lugares'];
  $horario = $data['horario'];
  $resultado = agregarCamion($path,$id,$nombre,$lugares,$horario);
  print  json_encode($resultado);
}

if($op == 1){
  $resultado = obtenerSesion($path);
  print  json_encode($resultado);
}

if($op == 2){
  $user = $data['user'];
  $clave = $data['clave'];
  $resultado = login($path,$user,$clave);
  print json_encode($resultado);
}

if($op == 3){
  $id = $data['id'];
  $resultado = obtenerMisAutobuses($path,$id);
  print json_encode($resultado);
}



if($op == 4){
  $resultado = destruir();
  print json_encode($resultado);
}

if($op == 5){
  $id = $data['id'];
  $resultado = personas($path,$id);
  print json_encode($resultado);
}

if($op == 6){
  $bus = $data['autobus'];
  $emisor = $data['emiter'];
  $receptor = $data['receiver'];
  $tipo = $data['type'];
  $resultado = addInteraccion($path,$bus,$emisor,$receptor,$tipo);
  print json_encode($resultado);
}

if($op == 7){
  $bus = $data['autobus'];
  $id = $data['id'];
  $resultado = getTripulantes($path,$bus,$id);
  print json_encode($resultado);
}

if($op == 8){
  $id = $data['id'];
  $resultado = getNumeroSolicitudes($path,$id);
  print json_encode($resultado);
}

if($op == 13){
  $id = $data['id'];
  $resultado = getNumeroInvitaciones($path,$id);
  print json_encode($resultado);
}

if($op == 9){
  $id = $data['id'];
  $resultado = getSolicitudes($path,$id);
  print json_encode($resultado);
}

if($op == 12){
  $id = $data['id'];
  $resultado = getInvitaciones($path,$id);
  print json_encode($resultado);
}

if($op == 10){
  $id = $data['id'];
  $estado = $data['estado'];
  $resultado = cambiarEstado($path,$id,$estado);
  print json_encode($resultado);
}

if($op == 11){
  $cadena = $data['search'];
  $resultado = buscar($path,$cadena);
  print json_encode($resultado);
}
?>
