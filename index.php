<?php
session_start();
//session_destroy();

ini_set('display_errors', true);
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

if (empty($_GET['page'])) {
  $_GET['page'] = 'home';
}
if (empty($routes[$_GET['page']])) {
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