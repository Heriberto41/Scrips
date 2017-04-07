<?php

/*
siempre tener en cuenta "config.inc.php" 
*/
require("config.inc.php");

//if posted data is not empty
if (!empty($_POST)) {
    //preguntamos si el ussuario y la contraseña esta vacia
    //sino muere
    if (empty($_POST['metal']) || empty($_POST['fecha'])) {
        
        // creamos el JSON
        $response["success"] = 0;
        $response["message"] = "";
        
        die(json_encode($response));
    }
    
    //si no hemos muerto (die), nos fijamos si exist en la base de datos
    $query        = " SELECT 1 FROM escaneo WHERE id_escaneo = :id_escaneo";
    
    //acutalizamos el :user
    $query_params = array(
        ':id_escaneo' => $_POST['id_escaneo']
    );
    
    //ejecutamos la consulta
    try {
        // estas son las dos consultas que se van a hacer en la bse de datos
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // solo para testing
        //die("Failed to run query: " . $ex->getMessage());
        
        $response["success"] = 0;
        $response["message"] = "Database Error1. Please Try Again!";
        die(json_encode($response));
    }
    
    //buscamos la información
    //como sabemos que el usuario ya existe lo matamos
    $row = $stmt->fetch();
    if ($row) {
        // Solo para testing
        //die("This username is already in use");
        
        $response["success"] = 0;
        $response["message"] = "";
        die(json_encode($response));
    }
    
    //Si llegamos a este punto, es porque el usuario no existe
    //y lo insertamos (agregamos)
    $query = "INSERT INTO escaneo (fecha, metal, user) VALUES (:fecha, :metal, :user) ";
    
    //actualizamos los token
    $query_params = array(
        ':fecha' => $_POST['fecha'],
        ':metal' => $_POST['metal'],
        ':user' => $_POST['user']
    );
    
    //ejecutamos la query y creamos el usuario
    try {
        $stmt   = $db->prepare($query);
        $result = $stmt->execute($query_params);
    }
    catch (PDOException $ex) {
        // solo para testing
        //die("Failed to run query: " . $ex->getMessage());
        
        $response["success"] = 0;
        $response["message"] = "Error base de datos2. Porfavor vuelve a intentarlo";
        die(json_encode($response));
    }
    
    //si hemos llegado a este punto
    //es que el usuario se agregado satisfactoriamente
    $response["success"] = 1;
    $response["message"] = "Datos registrados correctamente";
    echo json_encode($response);
    
    //para cas php tu puedes simpelmente redireccionar o morir
    //header("Location: login.php"); 
    //die("Redirecting to login.php");
    
    
} else {
?>
 <h1>Register</h1> 
 <form action="escaneo.php" method="post"> 
      ID:<br /> 
     <input type="text" name="id_escaneo" value="" /> 
     <br /><br /> 
     Fecha:<br /> 
     <input type="text" name="fecha" value="" /> 
     <br /><br /> 
     metal:<br /> 
     <input type="text" name="metal" value="" /> 
     <br /><br /> 
     User:<br /> 
     <input type="text" name="user" value="" /> 
     <br /><br /> 
     <input type="submit" value="Register New User" /> 
 </form>
 <?php
}

?>