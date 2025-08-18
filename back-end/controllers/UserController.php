<?php
require_once __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../models/User.php';

class UserController {
    private $db;
    private $user_model;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user_model = new User($this->db);
    }
    
    private function getAuthenticatedUser() {
        $secret_key = $_ENV['JWT_SECRET'];
        $headers = getallheaders();
        if (!isset($headers['Authorization'])) return null;
        list($jwt) = sscanf($headers['Authorization'], 'Bearer %s');
        if ($jwt) {
            try { return (array) JWT::decode($jwt, new Key($secret_key, 'HS256'))->data; }
            catch (Exception $e) { return null; }
        }
        return null;
    }

    public function getMyProfile() {
        $actor = $this->getAuthenticatedUser();
        if (!$actor) {
            http_response_code(401);
            echo json_encode(["message" => "Acesso não autorizado."]);
            return;
        }

        $user_data = $this->user_model->findById($actor['id']);
        if ($user_data) {
            http_response_code(200);
            echo json_encode($user_data);
        } else {
            http_response_code(404);
            echo json_encode(["message" => "Usuário não encontrado."]);
        }
    }

    // Endpoint for an ADMIN or HOKAGE to update a profile.
   
    public function updateProfileByAdmin() {
        $actor = $this->getAuthenticatedUser();
        // The verification and condition remains the same: it must be ADMIN or HOKAGE
        if (!$actor || !in_array($actor['role'], ['ADMINISTRADOR', 'HOKAGE'])) {
            http_response_code(403);
            echo json_encode(["message" => "Você não tem permissão para esta ação."]);
            return;
        }

        $data = json_decode(file_get_contents("php://input"));
        
        $user_id_to_update = $data->id;
        $new_password = $data->senha ?? null;
        $new_role = $data->tipo_acesso ?? null;

        // --- SAFETY RULE ---
        if (!empty($new_role)) {
            if ($actor['role'] !== 'HOKAGE') {
                http_response_code(403);
                echo json_encode(["message" => "Acesso negado! Seu nível de acesso não permite esta ação, por favor acione a automação."]);
                return;
            }
        }

        if ($this->user_model->updateProfile($user_id_to_update, $new_password, $new_role)) {
            http_response_code(200);
            echo json_encode(["message" => "Perfil atualizado com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Não foi possível atualizar o perfil."]);
        }
    }

    public function getAllUsers() {
        $actor = $this->getAuthenticatedUser();
        if (!$actor || $actor['role'] !== 'HOKAGE') {
            http_response_code(403);
            echo json_encode(["message" => "Acesso Negado! Seu nível de acesso não permite esta ação."]);
            return;
        }
        $result = $this->user_model->getAll();
        $users = $result->fetch_all(MYSQLI_ASSOC);
        http_response_code(200);
        echo json_encode($users);
    }

    public function createUserByHokage() {
        $actor = $this->getAuthenticatedUser();
        if (!$actor || $actor['role'] !== 'HOKAGE') {
            http_response_code(403);
            echo json_encode(["message" => "Acesso Negado! Seu nível de acesso não permite esta ação, por favor acione a automação."]);
            return;
        }
        
        $data = json_decode(file_get_contents("php://input"));
        $this->user_model->usuario = $data->usuario;
        $this->user_model->senha = $data->senha;
        $this->user_model->tipo_acesso = $data->tipo_acesso ?? 'OPERADOR';

        $result_status = $this->user_model->create();
        
        if ($result_status === "sucesso") {
            http_response_code(201);
            echo json_encode(["message" => "Usuário criado com sucesso."]);
        } elseif ($result_status === "existe") {
            http_response_code(409);
            echo json_encode(["message" => "Usuário já existe."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao criar usuário."]);
        }
    }

    public function deleteUserByHokage() {
        $actor = $this->getAuthenticatedUser();
        if (!$actor || $actor['role'] !== 'HOKAGE') {
            http_response_code(403);
            echo json_encode(["message" => "Acesso Negado! Seu nível de acesso não permite esta ação."]);
            return;
        }
        $data = json_decode(file_get_contents("php://input"));
        $user_id_to_delete = $data->id;

        if ($actor['id'] == $user_id_to_delete) {
            http_response_code(400);
            echo json_encode(["message" => "Você não pode excluir a si mesmo."]);
            return;
        }

        if ($this->user_model->deleteById($user_id_to_delete)) {
            http_response_code(200);
            echo json_encode(["message" => "Usuário excluído com sucesso."]);
        } else {
            http_response_code(500);
            echo json_encode(["message" => "Erro ao excluir usuário."]);
        }
    }
}
?>