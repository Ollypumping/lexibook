<?php
// Get the rewritten path from the URL
$requestedPath = $_GET['url'] ?? '';

// Trick the routes/api.php file into thinking it was accessed directly
$_SERVER['REQUEST_URI'] = '/api/' . $requestedPath;


// Forward the request to the main route handler
require_once  './routes/api.php';