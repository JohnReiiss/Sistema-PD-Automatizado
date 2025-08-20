<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../models/Product.php';

class ProductController {
    private $db;
    private $product;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->product = new Product($this->db);
    }
    
    private function getAuthenticatedUser() {
        $secret_key = $_ENV['JWT_SECRET'];
        $headers = getallheaders();

        if (!isset($headers['Authorization'])) {
            return null;
        }

        $authHeader = $headers['Authorization'];
        list($jwt) = sscanf($authHeader, 'Bearer %s');

        if ($jwt) {
            try {
                $decoded = JWT::decode($jwt, new Key($secret_key, 'HS256'));
                return (array) $decoded->data;
            } catch (Exception $e) {
                return null;
            }
        }
        
        return null;
    }

    public function getProductByName() {
        if (!isset($_GET['produto'])) {
            http_response_code(400);
            echo json_encode(["message" => "Nome do produto não fornecido."]);
            return;
        }

        $product_name = $_GET['produto'];
        $product_data = $this->product->findByName($product_name);

        if ($product_data) {
            http_response_code(200);
            echo json_encode($product_data);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Produto não encontrado."]);
        }
    }

    public function createProduct() {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            http_response_code(401);
            echo json_encode(["message" => "Acesso negado. Token inválido ou não fornecido."]);
            return;
        }

        if (!in_array($user['role'], ['ADMINISTRADOR', 'HOKAGE'])) {
            http_response_code(403);
            echo json_encode(["message" => "Seu nível de acesso não te permite essa ação!"]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->produto)) {
            http_response_code(400);
            echo json_encode(["message" => "Dados do produto incompletos."]);
            return;
        }

        $this->product->produto = $data->produto;
        $this->product->peso_min_menor = $data->PESO_MIN_MENOR;
        $this->product->peso_max_menor = $data->PESO_MAX_MENOR;
        $this->product->peso_start_menor = $data->PESO_START_MENOR;
        $this->product->peso_min_maior = $data->PESO_MIN_MAIOR;
        $this->product->peso_max_maior = $data->PESO_MAX_MAIOR;
        $this->product->tamanho_fonte = $data->TAMANHO_FONTE;
        $this->product->revisao = $data->REVISAO;
        $this->product->usuario = $user['usuario'];

        if ($this->product->create()) {
            http_response_code(201);
            echo json_encode(["message" => "Produto cadastrado com sucesso."]);
        } else {
            http_response_code(409);
            echo json_encode(["message" => "Não foi possível cadastrar o produto. Ele já existe."]);
        }
    }
    
    public function updateProduct() {
        $user = $this->getAuthenticatedUser();
        if (!$user) {
            http_response_code(401);
            echo json_encode(["message" => "Acesso negado."]);
            return;
        }
        
        if (!in_array($user['role'], ['ADMINISTRADOR', 'HOKAGE'])) {
            http_response_code(403);
            echo json_encode(["message" => "Seu nível de acesso não te permite essa ação!"]);
            return;
        }
        
        $data = json_decode(file_get_contents("php://input"));
        
        if (empty($data->produto)) {
            http_response_code(400);
            echo json_encode(["message" => "Dados do produto incompletos."]);
            return;
        }
        
        $this->product->produto = $data->produto;
        $this->product->peso_min_menor = $data->PESO_MIN_MENOR;
        $this->product->peso_max_menor = $data->PESO_MAX_MENOR;
        $this->product->peso_start_menor = $data->PESO_START_MENOR;
        $this->product->peso_min_maior = $data->PESO_MIN_MAIOR;
        $this->product->peso_max_maior = $data->PESO_MAX_MAIOR;
        $this->product->tamanho_fonte = $data->TAMANHO_FONTE;
        $this->product->revisao = $data->REVISAO;
        $this->product->usuario = $user['usuario'];
        
        if ($this->product->update()) {
            http_response_code(200);
            echo json_encode(["message" => "Produto atualizado com sucesso."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Não foi possível atualizar o produto."]);
        }
    }

    public function deleteProduct() {
        $user = $this->getAuthenticatedUser();
        if (!$user || !in_array($user['role'], ['ADMINISTRADOR', 'HOKAGE'])) {
            http_response_code(403);
            echo json_encode(["message" => "Ação não permitida."]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->produto)) {
            http_response_code(400);
            echo json_encode(["message" => "Código do produto não fornecido."]);
            return;
        }

        if ($this->product->deleteByName($data->produto)) {
            http_response_code(200);
            echo json_encode(["message" => "Produto excluído com sucesso."]);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Produto não encontrado ou não pôde ser excluído."]);
        }
    }
}
?>