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

    $sql = "UPDATE urgencia SET TRIAGE= ? , SINTOMAS = ? , MEDICO = ?  WHERE id= ? ";

    $statement = $dbConn->prepare($sql);
    $statement->execute([
    $_POST['triage'],
    $_POST['sintomas'],
    $_POST['medico'],
    $_POST['id'],
    ]);

    header("HTTP/1.1 200 OK");

    $res = array(
        'mensaje'=> 'Registro actualizado satisfactoriamente',
        'data' => array(
            'id' =>  $_POST['id'] ,
            'triage' =>  $_POST['triage'],
            'sintomas' =>  $_POST['sintomas'],
            'medico' =>  $_POST['medico'] 
        )
    );

echo json_encode($res);
exit();
}
