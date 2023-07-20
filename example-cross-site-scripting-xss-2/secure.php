<!-- TODO: Register or updade an user with a xss -->

<form method="post">

  <input type="text" name="busca">
  <button type="submit">Enviar</button>

</form>

<?php

if(isset($_POST['busca'])) {

  echo strip_tags($_POST['busca']); // removendo todo html e deixando apenas a string
	echo strip_tags($_POST['busca'], "<strong><a>"); // removendo todos os elementos que não sejam strong ou a do campo
  echo htmlentities($_POST['busca']); // convertendo html em string

}

?>