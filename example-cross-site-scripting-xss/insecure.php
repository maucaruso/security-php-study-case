<form method="post">

  <input type="text" name="busca">
  <button type="submit">Enviar</button>

</form>

<?php

if(isset($_POST['busca']) || isset($_GET['search'])) {

  $search = $_POST['busca'] ?? $_GET['search'];
  
  echo "<p>Você buscou por: </p> <b>" . $search . "</b>";

}

?>