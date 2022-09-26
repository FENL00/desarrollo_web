<?php

include "./Config/config.php";
include "./Config/utils.php";

$dbConn =  connect($db);

$input = $_POST;
$sql = "INSERT INTO paciente
      (CEDULA,INGRESO,FECHA_SALIDA,FK_URGENCIA,PESO,EMAIL,NOMBRE) VALUES (:cedula, :ingreso, :fecha_salida, :fk_urgencia, :peso, :email, :nombre)";
$statement = $dbConn->prepare($sql);
bindAllValues($statement, $input);
$statement->execute();
$postId = $dbConn->lastInsertId();

//buscamos los campos del registro insertado
$sql = $dbConn->prepare("SELECT * FROM paciente where id= ?");
$sql->execute([$postId]);
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
echo json_encode($res);


