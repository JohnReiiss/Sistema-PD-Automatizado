<?php
// CORS and Content-Type Headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST, GET, PUT");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
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