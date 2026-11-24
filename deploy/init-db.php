<?php

umask(0077);
$pdo = new PDO('sqlite:' . $argv[1], null, null, [
  PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
$pdo->exec('PRAGMA busy_timeout = 5000');
$pdo->exec(file_get_contents(__DIR__ . '/schema.sql'));
