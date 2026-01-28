<?php
class DB {
  private static $pdo = null;
  public static function conn() {
    if (!self::$pdo) {
      $dsn = 'mysql:host=localhost;dbname=sistema_ceaa;charset=utf8mb4';
      self::$pdo = new PDO($dsn, 'root', '', [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
      ]);
    }
    return self::$pdo;
  }
}
