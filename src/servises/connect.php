<?php
namespace services;
use PDO;
use PDOException;

class Connect
{
  private static $host = '127.0.0.1'; 
  private static $port = '3306';
  private static $user = 'root';
  private static $password = '';
  private static $db = 'u24mag6o_krsk';
  private static $pdo = null;

  public static function connect()
  {
    if (self::$pdo === null) {
      try {
        self::$pdo = new PDO(
          "mysql:host=" . self::$host . ";dbname=" . self::$db . ";port=" . self::$port,
          self::$user,
          self::$password
        );
      } catch (PDOException $e) {
        echo 'Ошибка соединения с БД: ' . $e->getMessage();
      }
    }
    return self::$pdo;
  }
}
