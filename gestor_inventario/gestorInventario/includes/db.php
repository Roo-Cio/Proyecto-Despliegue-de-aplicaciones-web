<?php
// includes/db.php
$config = require __DIR__ . '/config.php';

$db = $config['db'];
$dsn = "mysql:host={$db['host']};dbname={$db['name']};charset={$db['charset']}";

$options = [
  PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
  PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
  PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
  $pdo = new PDO($dsn, $db['user'], $db['pass'], $options);
} catch (PDOException $e) {
  http_response_code(500);
  echo "Error de conexión a BD. Revisa includes/config.php";
  exit;
}
