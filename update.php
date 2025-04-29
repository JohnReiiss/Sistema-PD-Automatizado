<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $produto = $_POST['produto'];
    $peso_min_menor = $_POST['PESO_MIN_MENOR'];
    $peso_max_menor = $_POST['PESO_MAX_MENOR'];
    $peso_start_menor = $_POST['PESO_START_MENOR'];
    $peso_min_maior = $_POST['PESO_MIN_MAIOR'];
    $peso_max_maior = $_POST['PESO_MAX_MAIOR'];
    $tamanho_fonte = $_POST['TAMANHO_FONTE'];
    $revisao = $_POST['REVISAO'];
    $usuario_id = $_SESSION['usuario_id'];
    $data_hora = date('Y-m-d H:i:s');

    $sql_usuario = "SELECT USUARIO FROM PD_usuario WHERE id = ?";
    $stmt_usuario = $conn->prepare($sql_usuario);
    $stmt_usuario->bind_param("i", $usuario_id);
    $stmt_usuario->execute();
    $resultado_usuario = $stmt_usuario->get_result();
    $usuario_data = $resultado_usuario->fetch_assoc();
    $nome_usuario = $usuario_data['USUARIO'];

    $sql = "UPDATE PD_peso SET 
            PESO_MIN_MENOR = ?, 
            PESO_MAX_MENOR = ?, 
            PESO_START_MENOR = ?, 
            PESO_MIN_MAIOR = ?, 
            PESO_MAX_MAIOR = ?, 
            TAMANHO_FONTE = ?, 
            REVISAO = ?,
            DATA_HORA = ?,
            USUARIO = ?
            WHERE PRODUTO = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "ssssssssss",
        $peso_min_menor,
        $peso_max_menor,
        $peso_start_menor,
        $peso_min_maior,
        $peso_max_maior,
        $tamanho_fonte,
        $revisao,
        $data_hora,
        $nome_usuario,
        $produto
    );

    if ($stmt->execute()) {
        $_SESSION['toast_message'] = "Produto atualizado com sucesso!";
        $_SESSION['toast_type'] = "success";
    } else {
        $_SESSION['toast_message'] = "Erro ao atualizar o produto.";
        $_SESSION['toast_type'] = "error";
    }

    header("Location: index.php?produto=" . urlencode($produto));
    exit();
} else {
    header("Location: index.php");
    exit();
}