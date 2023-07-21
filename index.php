<?php
$request_path = $_SERVER['REQUEST_URI'];

$request_path = trim($request_path, '/');

$segments = explode('/', $request_path);

$folder = isset($segments[0]) ? $segments[0] : 'default-folder';
$file = isset($segments[1]) ? $segments[1] : 'default-file.php';

$file_path = __DIR__ . '/' . $folder . '/' . $file;

if (file_exists($file_path) && is_file($file_path)) {
    include($file_path);
} else {
    header("HTTP/1.0 404 Not Found");
    echo "404 Not Found";
}
