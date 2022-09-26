<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

 //verificar si existe el usuario
 $sql = $dbConn->prepare("SELECT * FROM paciente where id= ?");
 $sql->execute([$_POST['id']]);
 $result = $sql->rowCount();

 if ($result<=0) {
    $res = array("ID ". $_POST['id'] => "no exite registro");

   echo json_encode($res);

 } else {
   
    $dato =$sql->fetch(PDO::FETCH_OBJ);

    //busca el los datos del fk 
    $sql1 = $dbConn->prepare("SELECT * FROM urgencia where id= ?");
    $sql1->execute([$dato->FK_URGENCIA]);

    $fk =$sql1->fetch(PDO::FETCH_OBJ);

    
$id = $_POST['id'];
$statement = $dbConn->prepare("DELETE FROM paciente where id=:id");
$statement->bindValue(':id', $id);
$statement->execute();
header("HTTP/1.1 200 OK");

$res = array(
    'mensaje'=> 'Registro eliminado satisfactoriamente',
    'data' => array(
        'id' =>  $dato->ID ,
        'nombre' =>  $dato->NOMBRE,
        'cedula' =>  $dato->CEDULA,
        'email' =>  $dato->EMAIL, 
        'peso' =>  $dato->PESO,
        'fecha_ingreso' =>  $dato->INGRESO,
        'fecha_salida' =>  $dato->FECHA_SALIDA, 
        "data_fk"=> array(
          'id' =>  $fk->ID ,
          'triage' =>  $fk->TRIAGE,
          'sintomas' =>  $fk->SINTOMAS,
          'medico' =>  $fk->MEDICO 
          )
        )
);
/* 
$res = "{
 'mensaje': 'Registro eliminado satisfactoriamente',
 'data': {
   'id' : " . $dato->ID .",
   'triage' : " . $dato->TRIAGE .",
   'sintomas' : " . $dato->SINTOMAS .",
   'medicos': " . $dato->MEDICO ."
 }";
 */
   echo json_encode($res);
   exit();
 }