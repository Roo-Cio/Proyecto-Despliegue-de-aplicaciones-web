<?php
// includes/functions.php

function e(string $value): string {
  return htmlspecialchars($value, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

function require_post_fields(array $fields): array {
  $data = [];
  foreach ($fields as $f) {
    if (!isset($_POST[$f]) || trim($_POST[$f]) === '') {
      throw new RuntimeException("Falta el campo: $f");
    }
    $data[$f] = trim((string)$_POST[$f]);
  }
  return $data;
}

function validate_int(string $value, string $field, int $min = 0, int $max = 100000000): int {
  if (!preg_match('/^\d+$/', $value)) {
    throw new RuntimeException("El campo $field debe ser un número entero.");
  }
  $n = (int)$value;
  if ($n < $min || $n > $max) {
    throw new RuntimeException("El campo $field está fuera de rango.");
  }
  return $n;
}

function csrf_token(): string {
  if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  if (empty($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(random_bytes(16));
  }
  return $_SESSION['csrf'];
}

function csrf_verify(): void {
  if (session_status() !== PHP_SESSION_ACTIVE) session_start();
  $ok = isset($_POST['csrf'], $_SESSION['csrf']) && hash_equals($_SESSION['csrf'], (string)$_POST['csrf']);
  if (!$ok) {
    throw new RuntimeException("CSRF inválido. Recarga la página e inténtalo otra vez.");
  }
}
