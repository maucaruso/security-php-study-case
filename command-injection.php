<!-- ------ ABORDAGEM INSEGURA ------ -->

<?php

$cmd = $_POST["cmd"];

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  echo '<pre>';

  $comando = system($cmd, $retorno);
  
  echo '</pre>';

}

?>

<form method="POST">

  <input type="text" name="cmd">
  <button type="submit">Enviar</button>

</form>

<!-- ------ ABORDAGEM SEGURA ------ -->

<?php

// $cmd = escapeshellcmd($_POST["cmd"]);

// if($_SERVER['REQUEST_METHOD'] === 'POST') {

//   echo '<pre>';

//   $comando = system($cmd, $retorno);
  
//   echo '</pre>';

// }

?>

<!-- <form method="POST">

  <input type="text" name="cmd">
  <button type="submit">Enviar</button>

</form> -->