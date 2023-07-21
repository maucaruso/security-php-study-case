<!-- GET: http://localhost:8080/example-cross-site-scripting-xss-2/insecure.php?id=2 -->

<?php
  if(isset($_POST['user_name']) && isset($_POST['email']) && isset($_GET["id"])) {
    $db = new PDO('sqlite:./../db/db.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "UPDATE users SET user_name = :user_name, email = :email WHERE user_id = :id";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bindValue(':id', $_GET["id"], PDO::PARAM_INT);
    $stmt->bindValue(':user_name', $_POST['user_name'], PDO::PARAM_STR);
    $stmt->bindValue(':email', $_POST['email'], PDO::PARAM_STR);
    
    $stmt->execute();
  }
?>

<?php
  $id = (isset($_GET["id"])) ? $_GET["id"] : 1; 

  $db = new PDO('sqlite:./../db/db.sqlite');
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  
  $sql = "SELECT * FROM users WHERE user_id = :id";
  
  $stmt = $db->prepare($sql);
  $stmt->bindValue(':id', $id, PDO::PARAM_INT);
  $stmt->execute();
  
  $user = [];
  
  while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $user = $resultado;
  }
?>

<h2>Atualizar Usuário</h2>

<form method="post">

  <input type="text" name="user_name" placeholder="Nome de usuário" value="<?= $user['user_name']; ?>">
  <input type="text" name="email" placeholder="Email" value="<?= $user['email']; ?>">
  
  <button type="submit">Atualizar Usuário</button>

</form>

<h3>Meu Cadastro</h3>

<p>Usuário: <?= $user['user_name']; ?></p>
<p>Email: <?= $user['email']; ?></p>