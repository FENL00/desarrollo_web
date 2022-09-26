<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

//Mostrar lista de post
$sql = $dbConn->prepare("SELECT * FROM paciente");
$sql->execute();
//$sql->setFetchMode(PDO::FETCH_ASSOC);

$res =array();

foreach ($sql->fetchAll(PDO::FETCH_OBJ) as $key => $dato) {
  
#print_r($dato);

//busca el los datos del fk 
$sql1 = $dbConn->prepare("SELECT * FROM urgencia where id= ?");
$sql1->execute([$dato->FK_URGENCIA]);
$fk =$sql1->fetch(PDO::FETCH_OBJ);

array_push($res,array(
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
  ))
);

}

header("HTTP/1.1 200 OK");
echo json_encode( $res  );
exit();
