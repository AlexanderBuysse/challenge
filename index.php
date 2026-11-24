<?php
session_start([
  'cookie_httponly' => true,
  'cookie_secure' => !empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off',
  'cookie_samesite' => 'Lax',
  'cookie_path' => rtrim(dirname($_SERVER['SCRIPT_NAME']), '/') . '/'
]);

ini_set('display_errors', '0');
error_reporting(E_ALL);

$routes = array(
  'home' => array(
    'controller' => 'Pages',
    'action' => 'index'
  ),
  'rules' => array(
    'controller' => 'Pages',
    'action' => 'rules'
  ),
    'login' => array(
    'controller' => 'Pages',
    'action' => 'login'
  ),
    'feed' => array(
    'controller' => 'Pages',
    'action' => 'feed'
  ),
    'upload' => array(
    'controller' => 'Pages',
    'action' => 'upload'
  ),
    'logout' => array(
    'controller' => 'Pages',
    'action' => 'logout'
  )
);

if (($_GET['page'] ?? null) === 'upload' && $_SERVER['REQUEST_METHOD'] === 'POST') {
  http_response_code(403);
  header('Content-Type: text/plain; charset=utf-8');
  exit('Nieuwe video’s uploaden is uitgeschakeld.');
}

if (empty($_GET['page'])) {
  $_GET['page'] = 'home';
}
if (!is_string($_GET['page']) || empty($routes[$_GET['page']])) {
  header('Location: index.php');
  exit();
}

$route = $routes[$_GET['page']];
$controllerName = $route['controller'] . 'Controller';

require_once __DIR__ . '/controller/' . $controllerName . ".php";

$controllerObj = new $controllerName();
$controllerObj->route = $route;
$controllerObj->filter();
$controllerObj->render();