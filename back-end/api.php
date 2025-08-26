<?php
// CORS and Content-Type Headers
$origens_permitidas = [
    'http://localhost:8000',
    'http://10.1.0.35'
];

// Checks if the source of the request is on our whitelist
if (isset($_SERVER['HTTP_ORIGIN']) && in_array($_SERVER['HTTP_ORIGIN'], $origens_permitidas)) {
    header("Access-Control-Allow-Origin: " . $_SERVER['HTTP_ORIGIN']);
}

header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit();
}

include_once __DIR__ . '/controllers/UserController.php';
// Includes controllers
include_once __DIR__ . '/controllers/AuthController.php';
include_once __DIR__ . '/controllers/ProductController.php';

// Analyzes the request to determine the action
$action = isset($_GET['action']) ? $_GET['action'] : '';

// Action-based routing
switch ($action) {
    // --- Authentication Routes ---
    case 'register':
        $controller = new AuthController();
        $controller->register();
        break;

    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    // --- Product Routes ---
    case 'getProduct':
        $controller = new ProductController();
        $controller->getProductByName();
        break;

    case 'createProduct':
        $controller = new ProductController();
        $controller->createProduct();
        break;
        
    case 'updateProduct':
        $controller = new ProductController();
        $controller->updateProduct();
        break;

    case 'deleteProduct':
        $controller = new ProductController();
        $controller->deleteProduct();
        break;

    // --- User Routes ---
    case 'getMyProfile':
        $controller = new UserController();
        $controller->getMyProfile();
        break;

    case 'updateProfileByAdmin':
        $controller = new UserController();
        $controller->updateProfileByAdmin();
        break;

    // Hokage Routes
    case 'getAllUsers':
        $controller = new UserController();
        $controller->getAllUsers();
        break;
    
    case 'createUserByHokage':
        $controller = new UserController();
        $controller->createUserByHokage();
        break;

    case 'deleteUserByHokage':
        $controller = new UserController();
        $controller->deleteUserByHokage();
        break;

    // --- Default Route ---
    default:
        http_response_code(404); // Not Found
        echo json_encode(["message" => "Endpoint não encontrado."]);
        break;
}
?>