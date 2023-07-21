<!-- GET: http://local.com/example-file-upload/insecure.php -->

<?php
  if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["imagemAvatar"])) {    
    $file = explode('.', $_FILES["imagemAvatar"]["name"]);
    
    $fileExtension = end($file);
    $fileName = uniqid() . '.' . $fileExtension;
    $filePath = './uploads/';
    
    $savePath  = $filePath . $fileName;
    
    move_uploaded_file($_FILES["imagemAvatar"]["tmp_name"], $savePath);
  }
?>

<h2>Atualizar Avatar</h2>

<form method="post" enctype="multipart/form-data">
  <input type="file" name="imagemAvatar" placeholder="Avatar" accept="image/png, image/jpeg">
  
  <button type="submit">Atualizar Foto de Perfil</button>

</form>