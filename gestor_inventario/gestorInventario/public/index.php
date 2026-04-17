<?php
require __DIR__ . '/../includes/db.php';
require __DIR__ . '/../includes/functions.php';

// Listado
$stmt = $pdo->query("SELECT id, nombre, cantidad, ubicacion, created_at FROM productos ORDER BY id DESC");
$productos = $stmt->fetchAll();

$flash = $_GET['m'] ?? null;
?>
<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Gestor de Inventario</title>
  <link rel="stylesheet" href="assets/styles.css" />
</head>
<body>
  <main class="container">
    <header class="header">
      <h1>Gestor de Inventario</h1>
      <p>inventario.local (HTTPS + acceso restringido)</p>
    </header>

    <?php if ($flash): ?>
      <div class="alert"><?= e($flash) ?></div>
    <?php endif; ?>

    <section class="card">
      <h2>Registrar producto</h2>
      <form method="post" action="store.php" autocomplete="off">
        <input type="hidden" name="csrf" value="<?= e(csrf_token()) ?>">
        <div class="grid">
          <label>Nombre
            <input name="nombre" required maxlength="120" placeholder="Ej: Portátiles" />
          </label>
          <label>Cantidad
            <input name="cantidad" required inputmode="numeric" pattern="\d+" placeholder="Ej: 5" />
          </label>
          <label>Ubicación
            <input name="ubicacion" required maxlength="80" placeholder="Ej: Almacén A" />
          </label>
        </div>
        <button type="submit">Guardar</button>
      </form>
      <p class="hint">SQLi: mitigado con consultas preparadas. XSS: mitigado con escape de salida.</p>
    </section>

    <section class="card">
      <h2>Listado</h2>
      <?php if (!$productos): ?>
        <p>No hay productos todavía.</p>
      <?php else: ?>
        <table>
          <thead>
            <tr>
              <th>ID</th><th>Nombre</th><th>Cantidad</th><th>Ubicación</th><th>Alta</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($productos as $p): ?>
              <tr>
                <td><?= e((string)$p['id']) ?></td>
                <td><?= e($p['nombre']) ?></td>
                <td><?= e((string)$p['cantidad']) ?></td>
                <td><?= e($p['ubicacion']) ?></td>
                <td><?= e((string)$p['created_at']) ?></td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      <?php endif; ?>
    </section>
  </main>
</body>
</html>
