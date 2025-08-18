<?php
require_once __DIR__ . '/../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/..');
$dotenv->load();

use Firebase\JWT\JWT;

include_once __DIR__ . '/../config/Database.php';
include_once __DIR__ . '/../models/User.php';

class AuthController {
    private $db;
    private $user;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
        $this->user = new User($this->db);
    }

    public function register() {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->usuario) || empty($data->senha)) {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos. Por favor, envie usuário e senha."]);
            return;
        }

        $this->user->usuario = $data->usuario;
        $this->user->senha = $data->senha;

        $result = $this->user->create();

        if ($result === "sucesso") {
            http_response_code(201);
            echo json_encode(["message" => "Usuário cadastrado com sucesso."]);
        } elseif ($result === "existe") {
            http_response_code(409);
            echo json_encode(["message" => "Usuário já existe."]);
        } else {
            http_response_code(503);
            echo json_encode(["message" => "Não foi possível cadastrar o usuário."]);
        }
    }

    public function login() {
        $data = json_decode(file_get_contents("php://input"));

        if (empty($data->usuario) || empty($data->senha)) {
            http_response_code(400);
            echo json_encode(["message" => "Dados incompletos."]);
            return;
        }

        $user_data = $this->user->findByUsername($data->usuario);

        if (!$user_data) {
            http_response_code(401);
            echo json_encode(["message" => "Login falhou. Verifique suas credenciais."]);
            return;
        }

        $password_is_valid = false;
        $password_needs_upgrade = false;
        
        // detects if the password is hashed
        if (strlen($user_data['SENHA']) === 60 && strpos($user_data['SENHA'], '$2y$') === 0) {
            // if the password is hashed, usa password_verify
            if (password_verify($data->senha, $user_data['SENHA'])) {
                $password_is_valid = true;
            }
        } else {
            // if not hash compare with plain text
            if ($data->senha === trim($user_data['SENHA'])) {
                $password_is_valid = true;
                $password_needs_upgrade = true; // update password
            }
        }

        if ($password_is_valid) {
            // If the password is old, update it to the secure hashed format
            if ($password_needs_upgrade) {
                $new_hashed_password = password_hash($data->senha, PASSWORD_BCRYPT);
                $this->user->updatePassword($data->usuario, $new_hashed_password);
            }

            // JWT token generation
            $secret_key = $_ENV['JWT_SECRET'];
            $issuer_claim = "http://sua-api.com";
            $audience_claim = "http://seu-frontend.com";
            $issuedat_claim = time();
            $expire_claim = $issuedat_claim + 3600;

            $token_payload = [
                "iss" => $issuer_claim, "aud" => $audience_claim, "iat" => $issuedat_claim, "exp" => $expire_claim,
                "data" => [ 
                    "id" => $user_data['ID'], 
                    "usuario" => $user_data['USUARIO'],
                    "role" => $user_data['TIPO_ACESSO']
                ]
            ];

            $jwt = JWT::encode($token_payload, $secret_key, 'HS256');

            http_response_code(200);
            echo json_encode([
                "message" => "Login bem-sucedido.",
                "token" => $jwt,
                "expiresIn" => $expire_claim
            ]);

        } else {
            // If the password is invalid, it returns the error
            http_response_code(401);
            echo json_encode(["message" => "Login falhou. Verifique suas credenciais."]);
        }
    }
}
?>