<?php

$db = new PDO('sqlite:db.sqlite');
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$tableSQL = "
  CREATE TABLE users (
    user_id INTEGER PRIMARY KEY,
    user_name TEXT NOT NULL,
    email TEXT NOT NULL UNIQUE,
    password TEXT NOT NULL
  );
";

$stmt = $db->prepare($tableSQL);
$stmt->execute();

while ($resultado = $stmt->fetch(PDO::FETCH_ASSOC)) {
  echo $resultado . "<br/>";
}

$usersSQL = "
  INSERT INTO users (user_name, email, password) VALUES 
  ('José Cardoso', 'example@mail.com', '123456'),
  ('Luciano Neto', 'example1@mail.com', '987654'),
  ('Joana Valéria', 'example2@mail.com', '13zasda1');
";

$stmt2 = $db->prepare($usersSQL);
$stmt2->execute();

while ($resultado = $stmt2->fetch(PDO::FETCH_ASSOC)) {
  echo $resultado . "<br/>";
}