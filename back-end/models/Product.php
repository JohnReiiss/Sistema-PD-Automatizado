<?php
class Product {
    private $conn;
    private $table_name = "PD_peso";

    public $produto;
    public $peso_min_menor;
    public $peso_max_menor;
    public $peso_start_menor;
    public $peso_min_maior;
    public $peso_max_maior;
    public $tamanho_fonte;
    public $revisao;
    public $data_hora;
    public $usuario;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByName($name) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE PRODUTO = ? LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $name);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            return $result->fetch_assoc();
        }

        return null;
    }

    public function create() {
        if ($this->findByName($this->produto)) {
            return false;
        }
        
        $query = "INSERT INTO " . $this->table_name . " 
                    (PRODUTO, PESO_MIN_MENOR, PESO_MAX_MENOR, PESO_START_MENOR, PESO_MIN_MAIOR, PESO_MAX_MAIOR, TAMANHO_FONTE, REVISAO, DATA_HORA, USUARIO) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->conn->prepare($query);

        $this->data_hora = date('Y-m-d H:i:s');

        $stmt->bind_param(
            "ssssssssss",
            $this->produto, $this->peso_min_menor, $this->peso_max_menor, $this->peso_start_menor,
            $this->peso_min_maior, $this->peso_max_maior, $this->tamanho_fonte, $this->revisao,
            $this->data_hora, $this->usuario
        );

        return $stmt->execute();
    }
    
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET
                    PESO_MIN_MENOR = ?, PESO_MAX_MENOR = ?, PESO_START_MENOR = ?,
                    PESO_MIN_MAIOR = ?, PESO_MAX_MAIOR = ?, TAMANHO_FONTE = ?,
                    REVISAO = ?, DATA_HORA = ?, USUARIO = ?
                  WHERE PRODUTO = ?";

        $stmt = $this->conn->prepare($query);

        $this->data_hora = date('Y-m-d H:i:s');
        
        $stmt->bind_param(
            "ssssssssss",
            $this->peso_min_menor, $this->peso_max_menor, $this->peso_start_menor,
            $this->peso_min_maior, $this->peso_max_maior, $this->tamanho_fonte, $this->revisao,
            $this->data_hora, $this->usuario, $this->produto
        );

        return $stmt->execute();
    }

    public function deleteByName($name) {
        $query = "DELETE FROM " . $this->table_name . " WHERE PRODUTO = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $name);
        if ($stmt->execute()) {
            return $stmt->affected_rows > 0;
        }
        return false;
    }
}
?>