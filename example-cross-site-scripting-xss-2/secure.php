<!-- GET: http://local.com/example-cross-site-scripting-xss-2/secure.php?id=2 -->

<?php
  if(isset($_POST['user_name']) && isset($_POST['email']) && isset($_GET["id"])) {
    $userName = strip_tags($_POST['user_name']);
    $email = strip_tags($_POST['email']);
    
    $db = new PDO('sqlite:./../db/db.sqlite');
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = "UPDATE users SET user_name = :user_name, email = :email WHERE user_id = :id";
    
    $stmt = $db->prepare($sql);
    
    $stmt->bindValue(':id', $_GET["id"], PDO::PARAM_INT);
    $stmt->bindValue(':user_name', $userName, PDO::PARAM_STR);
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    
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

  <input type="text" name="user_name" placeholder="Nome de usuário" value="<?= strip_tags($user['user_name']); ?>">
  <input type="text" name="email" placeholder="Email" value="<?= strip_tags($user['email']); ?>">
  
  <button type="submit">Atualizar Usuário</button>

</form>

<h3>Meu Cadastro</h3>

<p>Usuário: <?= strip_tags($user['user_name']); ?></p>
<p>Email: <?= strip_tags($user['email']); ?></p>