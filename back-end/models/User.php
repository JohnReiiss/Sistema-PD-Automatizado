<?php
class User {
    private $conn;
    private $table_name = "PD_usuario";

    public $id;
    public $usuario;
    public $senha;
    public $tipo_acesso;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function create() {
        $check_query = "SELECT ID FROM " . $this->table_name . " WHERE USUARIO = ? LIMIT 1";
        $stmt_check = $this->conn->prepare($check_query);
        $this->usuario = htmlspecialchars(strip_tags($this->usuario));
        $stmt_check->bind_param("s", $this->usuario);
        $stmt_check->execute();
        $stmt_check->store_result();

        if ($stmt_check->num_rows > 0) {
            return "existe";
        }

        $query = "INSERT INTO " . $this->table_name . " (USUARIO, SENHA, TIPO_ACESSO) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);

        $this->senha = htmlspecialchars(strip_tags($this->senha));
        $this->tipo_acesso = "OPERADOR";

        $hashed_password = password_hash($this->senha, PASSWORD_BCRYPT);

        $stmt->bind_param("sss", $this->usuario, $hashed_password, $this->tipo_acesso);

        if ($stmt->execute()) {
            return "sucesso";
        }

        return "falha";
    }

    public function findByUsername($username) {
        $query = "SELECT ID, USUARIO, SENHA, TIPO_ACESSO FROM " . $this->table_name . " WHERE USUARIO = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function updatePassword($username, $hashed_password) {
        $query = "UPDATE " . $this->table_name . " SET SENHA = ? WHERE USUARIO = ?";
        $stmt = $this->conn->prepare($query);

        $stmt->bind_param("ss", $hashed_password, $username);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function findById($id) {
        $query = "SELECT ID, USUARIO, TIPO_ACESSO FROM " . $this->table_name . " WHERE ID = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return null;
    }

    public function updateProfile($id, $new_password, $new_role) {
        $query_parts = [];
        $params = [];
        $types = "";

        if (!empty($new_password)) {
            $query_parts[] = "SENHA = ?";
            $params[] = password_hash($new_password, PASSWORD_BCRYPT);
            $types .= "s";
        }
        if (!empty($new_role)) {
            $query_parts[] = "TIPO_ACESSO = ?";
            $params[] = $new_role;
            $types .= "s";
        }

        if (empty($query_parts)) {
            return true;
        }

        $query = "UPDATE " . $this->table_name . " SET " . implode(", ", $query_parts) . " WHERE ID = ?";
        $params[] = $id;
        $types .= "i";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param($types, ...$params);

        return $stmt->execute();
    }

    public function getAll() {
        $query = "SELECT ID, USUARIO, TIPO_ACESSO FROM " . $this->table_name;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function deleteById($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE ID = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
?>