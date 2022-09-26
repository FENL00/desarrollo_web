<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

//verificar si existe el usuario
$sql = $dbConn->prepare("SELECT * FROM paciente where id= ?");
$sql->execute([$_GET['id']]);
$result = $sql->rowCount();

if ($result<=0) {
   $res = array("ID ". $_GET['id'] => "no exite este registro");

  echo json_encode($res);

}else{

  //Mostrar lista de post
  $sql = $dbConn->prepare("SELECT * FROM paciente WHERE ID = ?");
  $sql->execute([$_GET['id']]);
  
  $dato = $sql->fetch(PDO::FETCH_OBJ);   

 //busca el los datos del fk 
 $sql1 = $dbConn->prepare("SELECT * FROM urgencia where id= ?");
 $sql1->execute([$dato->FK_URGENCIA]);

 $fk =$sql1->fetch(PDO::FETCH_OBJ);

 $res =  array(
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
      );

header("HTTP/1.1 200 OK");
  echo json_encode( $res  );

}


  exit();
