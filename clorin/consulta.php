
    <?php
       $db_host = "localhost";
       $db_name = "clorin_hek";
       $db_user = "root";
       $db_password = "5678";
       $connection = mysqli_connect($db_host, $db_user, $db_password) or die("Connection Error: " . mysqli_error());
        mysqli_select_db($connection, $db_name) or die("Error al seleccionar la base de datos:".mysqli_error());
          @mysqli_query("SET NAMES 'utf8'");


if (!empty($_POST)) {
    //preguntamos si el ussuario y la contraseña esta vacia
    //sino muere
    if (empty($_POST['user'])) {
        
        // creamos el JSON
        $response["success"] = 0;
        $response["message"] = "Por  usuairo y el password";
        
        die(json_encode($response));
    }
   
    $sql_query = "SELECT * FROM escaneo WHERE user= :user ";
    $query_params = array(
        ':user' => $_POST['user']
        );
    $result = mysqli_query($connection, $sql_query);
    $rows = array();
while($r = mysqli_fetch_assoc($result)) {
  $rows[] = $r;
}
print json_encode($rows);
} else {
?>
 <h1>Consulta</h1> 
 <form action="consulta.php" method="post"> 
      User:<br /> 
     <input type="text" name="user" value="" /> 
     <br /><br /> 
     <input type="submit" value="Cosulta" /> 
 </form>
 <?php
}

?>
