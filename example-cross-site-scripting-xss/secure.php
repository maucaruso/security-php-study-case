<form method="post">

  <input type="text" name="busca">
  <button type="submit">Enviar</button>

</form>

<?php

if(isset($_POST['busca']) || isset($_GET['search'])) {
  
  $search = $_POST['busca'] ?? $_GET['search'];

  echo "<p>Você buscou por: </p> <b>";
  
  echo strip_tags($search); // removendo todo html e deixando apenas a string
  echo "<br/><br/>";
	echo strip_tags($search, "<strong><a>"); // removendo todos os elementos que não sejam strong ou a do campo
  echo "<br/><br/>";
  echo htmlentities($search); // convertendo html em string
  echo "<br/><br/>";
  
  echo "</b>";

}

?>