<!-- GET: http://localhost:8080/example-crypt-password/secure.php?id=2 -->

<?php
  define('SECRET_IV', pack('a16', 'secretsalt'));
  define('SECRET', pack('a16', 'secretsalt'));

  if(isset($_POST['password']) && isset($_GET["id"])) {
    $password = openssl_encrypt(
      $_POST['password'],
      'AES-128-CBC',
      SECRET,
      0,
      SECRET_IV
    );
    
    $password = base64_encode($password);
    
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
  <input type="text" name="password" placeholder="Senha">
  <button type="submit">Atualizar Senha</button>
</form>

<h3>Meu Cadastro</h3>

<?php
  
  $decodedPassword = openssl_decrypt(
    base64_decode($user['password']),
    'AES-128-CBC',
    SECRET,
    0,
    SECRET_IV
  );
  
?>

<p>Usuário: <?= $user['user_name']; ?></p>
<p>Email: <?= $user['email']; ?></p>
<p>Senha Descriptada: <?= $decodedPassword; ?></p>