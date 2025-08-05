<?php

require_once __DIR__. '/../config/database.php';
require_once __DIR__. '/../controller/RegController.php';
require_once __DIR__. '/../controller/BookController.php';
require_once __DIR__. '/../middleware/AuthMiddleware.php';
require_once __DIR__ . '/../helpers/ResponseHelper.php';

header('Content-Type: application/json');

$db = (new Database())->connect();
$method = $_SERVER['REQUEST_METHOD'];
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$uri = str_replace('/api', '', $uri);

$regController = new RegController($db);
if ($uri === '/register' && $method === 'POST') {
    $regController->register();
    exit;
}
if ($uri === '/login' && $method === 'POST') {
    $regController->login();
    exit;
}


$bookController = new BookController($db);

 

switch (true) {
    
    // GET all books
    case $uri === '/books' && $method === 'GET':
        $bookController->display();
        break;
    // ADD a book
    case $uri === '/books' && $method === 'POST':
        $bookController->store();
        break;
    // GET book by id
    case preg_match('#^/books/(\d+)$#', $uri, $matches) && $method === 'GET':
        $bookController->show($matches[1]);
        break;
    // GET paginated books
    case $uri === '/book' && $method === 'GET':
        $bookController->index();
        break;

    // UPDATE a book
    case preg_match('#^/books/(\d+)$#', $uri, $matches) && $method === 'PUT':
        $bookController->update($matches[1]);
        break;
    // DELETE a book
    case preg_match('#^/books/(\d+)$#', $uri, $matches) && $method === 'DELETE':
        $bookController->delete($matches[1]);
        break;

    default:
        ResponseHelper::error('Endpoint not found', 404);
        break;
}





