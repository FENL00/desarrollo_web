<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);


//verificar si existe el usuario
$sql = $dbConn->prepare("SELECT * FROM paciente where ID= ?");
$sql->execute([
    $_POST['id']
]);
$result = $sql->rowCount();

if ($result<=0) {
   $res = array("ID ". $_POST['id'] => "no exite registro");

  echo json_encode($res);

} else {
  
   $dato =$sql->fetch(PDO::FETCH_OBJ);

    $sql = "UPDATE paciente SET CEDULA =?,INGRESO = ? ,FECHA_SALIDA = ?,FK_URGENCIA = ?,PESO = ?,EMAIL = ? ,NOMBRE = ?  WHERE id= ? ";

    $statement = $dbConn->prepare($sql);
    $statement->execute([
    $_POST['cedula'],
    $_POST['ingreso'],
    $_POST['fecha_salida'],
    $_POST['fk_urgencia'],
    $_POST['peso'],
    $_POST['email'],
    $_POST['nombre'],
    $_POST['id'],
    ]);

    header("HTTP/1.1 200 OK");

    
    //busca el los datos del fk 
    $sql1 = $dbConn->prepare("SELECT * FROM urgencia where id= ?");
    $sql1->execute([$_POST['fk_urgencia']]);

    $fk =$sql1->fetch(PDO::FETCH_OBJ);

    $res = array(
        'mensaje'=> 'Registro Actualizado satisfactoriamente',
        'data' => array(
            'id' =>  $_POST['id'] ,
            'nombre' =>  $_POST['nombre'],
            'cedula' =>  $_POST['cedula'],
            'email' =>  $_POST['email'], 
            'peso' =>  $_POST['peso'],
            'fecha_ingreso' =>  $_POST['ingreso'],
            'fecha_salida' =>  $_POST['fecha_salida'], 
            "data_fk"=> array(
              'id' =>  $fk->ID ,
              'triage' =>  $fk->TRIAGE,
              'sintomas' =>  $fk->SINTOMAS,
              'medico' =>  $fk->MEDICO 
              )
            )
    );

echo json_encode($res);
exit();
}
