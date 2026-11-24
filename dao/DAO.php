<?php

class DAO {
  private static $sharedPDO;
  protected $pdo;

  public function __construct() {
    if (!self::$sharedPDO) {
      $path = getenv('CHALLENGE_DB') ?: dirname(__DIR__, 5) . '/.challenge/challenge.sqlite';
      self::$sharedPDO = new PDO('sqlite:' . $path, null, null, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
      ]);
      self::$sharedPDO->exec('PRAGMA busy_timeout = 5000');
      self::$sharedPDO->exec('PRAGMA foreign_keys = ON');
    }
    $this->pdo = self::$sharedPDO;
  }
}
