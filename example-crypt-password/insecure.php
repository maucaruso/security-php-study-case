<!-- GET: http://localhost:8080/example-crypt-password/insecure.php?id=2 -->

<?php
  if(isset($_POST['password']) && isset($_GET["id"])) {
    $password = md5($_POST['password']);
    
    $db = new PDO('sqlite:./../db/db.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "UPDATE users SET password = :password WHERE user_id = :id";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bindValue(':id', $_GET["id"], PDO::PARAM_INT);
    $stmt->bindValue(':password', $password, PDO::PARAM_STR);
    
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

<h2>Atualizar Senha</h2>

<form method="post">
  <input type="password" name="password" placeholder="Senha">
  <button type="submit">Atualizar Senha</button>
</form>

<h3>Meu Cadastro</h3>

<p>Usuário: <?= $user['user_name']; ?></p>
<p>Email: <?= $user['email']; ?></p>