<!-- TODO: Register or updade an user with a xss and then show the user details in the screen without treatative -->

<form method="post">

  <input type="text" name="busca">
  <button type="submit">Enviar</button>

</form>

<?php

if(isset($_POST['busca'])) {

  echo $_POST['busca'];

}

?>