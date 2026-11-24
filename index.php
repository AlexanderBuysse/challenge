<?php

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
if ($method !== 'GET' && $method !== 'HEAD') {
  http_response_code(403);
  header('Content-Type: text/plain; charset=utf-8');
  exit('Speed Bakers is a read-only demo. This action is disabled.');
}

$page = $_GET['page'] ?? 'home';
$choice = $_GET['choice'] ?? 'all';
$actionDisabled = in_array($page, ['login', 'upload', 'logout', 'register'], true)
  || ($page === 'feed' && $choice === 'personal');

$template = 'index';
if ($page === 'rules') {
  $template = 'rules';
} elseif ($page === 'feed' || $actionDisabled) {
  $template = 'feed';
  $videos = require __DIR__ . '/view/demo-attempts.php';
  $ranking = array_values($videos);
  usort($ranking, fn($a, $b) => [$a['time'], $a['id']] <=> [$b['time'], $b['id']]);
  $places = array_flip(array_column($ranking, 'id'));

  $sort = $_GET['sort'] ?? 'id';
  if ($sort === 'time') {
    $attempts = $ranking;
  } elseif ($sort === 'popular') {
    $attempts = array_values($videos);
    usort($attempts, fn($a, $b) => [$b['likes'], $b['id']] <=> [$a['likes'], $a['id']]);
  } else {
    $attempts = array_reverse($videos);
  }

  $id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);
  $attempt = $choice === 'video' ? ($videos[$id] ?? null) : null;
  if ($choice === 'video' && $attempt === null) {
    http_response_code(404);
  }
}

function escape(string $text): string {
  return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

ob_start();
require __DIR__ . '/view/pages/' . $template . '.php';
$content = ob_get_clean();
require __DIR__ . '/view/layout.php';
