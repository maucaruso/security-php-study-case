<!-- GET: http://localhost:8080/example-command-injection/secure.php -->

<?php

// $cmd = escapeshellarg($_POST["cmd"]) ?? null;
$cmd = escapeshellcmd($_POST["cmd"]) ?? null;

if($_SERVER['REQUEST_METHOD'] === 'POST') {

  echo '<pre>';
  
  $command = "mkdir -p user-folders/{$cmd}";

  $command = system($command, $return);
  
  echo '</pre>';

}

?>

<h2>Formulário Seguro</h2>

<form method="POST">
  
  <input type="text" name="cmd">
  <button type="submit">Enviar</button>

</form>