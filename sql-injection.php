<!-- GET: http://localhost:3000/2 -->


<!-- ------ ABORDAGEM INSEGURA ------ -->

<?php

// Obtendo ID do usuário
$id = (isset($_GET["id"])) ? $_GET["id"] : 1; 

$conn = mysqli_connect("localhost", "root", "", "dbphp7");

// Montando SELECT com base do ID
$sql = "SELECT * FROM tb_usuarios WHERE id_usuario = $id";

$exec = mysqli_query($conn, $sql);

while ($resultado = mysqli_fetch_object($exec)) {

  echo $resultado->des_login."<br/>";

}

?>

<!-- ------ ABORDAGEM SEGURA ------ -->
