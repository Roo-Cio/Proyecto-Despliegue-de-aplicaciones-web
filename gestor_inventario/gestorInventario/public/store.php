<?php
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/functions.php';

try {
  csrf_verify();

  $data = require_post_fields(['nombre', 'cantidad', 'ubicacion']);

  $nombre = $data['nombre'];
  $cantidad = validate_int($data['cantidad'], 'cantidad', 0, 1000000);
  $ubicacion = $data['ubicacion'];

  $sql = "INSERT INTO productos (nombre, cantidad, ubicacion) VALUES (:nombre, :cantidad, :ubicacion)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ':nombre' => $nombre,
    ':cantidad' => $cantidad,
    ':ubicacion' => $ubicacion,
  ]);

  header("Location: /?m=" . urlencode("Producto guardado"));
  exit;
} catch (Throwable $e) {
  header("Location: /?m=" . urlencode("Error: " . $e->getMessage()));
  exit;
}
