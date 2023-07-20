<!-- GET: http://localhost:3000/2 -->

<?php

// Obtendo ID do usuário
$id = (isset($_GET["id"])) ? $_GET["id"] : 1; 

$db = new PDO('sqlite:./../db/db.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$sql = "SELECT * FROM users WHERE user_id = :id";

$stmt = $db->prepare($sql);

$stmt->bindValue(':id', $id, PDO::PARAM_INT);

$stmt->execute();

echo '<pre>';
while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
  print_r($resultado);
}
echo '</pre>';

?>
