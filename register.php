<?php
session_start();
include('includes/db.php');

$mensagem = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST["usuario"];
    $senha = $_POST["senha"];
    $tipo = "OPERADOR";

    $sql_verifica = "SELECT * FROM PD_usuario WHERE USUARIO = ?";
    $stmt_verifica = $conn->prepare($sql_verifica);
    $stmt_verifica->bind_param("s", $usuario);
    $stmt_verifica->execute();
    $resultado = $stmt_verifica->get_result();

    if ($resultado->num_rows > 0) {
        $_SESSION['mensagem'] = "Usuário já existe!";
    } else {

        $sql = "INSERT INTO PD_usuario (USUARIO, SENHA, TIPO_ACESSO) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $usuario, $senha, $tipo);

        if ($stmt->execute()) {
            $_SESSION['mensagem'] = "Cadastro realizado com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Erro ao cadastrar usuário: " . $conn->error;
        }
    }

    $stmt_verifica->close();
    $conn->close();

    header("Location: register.php");
    exit();
}

if (isset($_SESSION['mensagem'])) {
    $mensagem = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="src/styles/global-reset.css">
    <link rel="stylesheet" href="src/styles/register.css">
    <link rel="stylesheet" href="src/styles/toastbar.css">
</head>

<body>
    <div class="container">
        <header>
            <h2>Sistema PD Automatizado</h2>
        </header>

        <form method="POST" action="">
            <h3>Cadastro de Usuário</h3>
            <p>Por favor, insira suas credenciais.</p>
            <input type="text" name="usuario" placeholder="Usuário" required>
            <input type="password" name="senha" placeholder="Senha" required>
            <button type="submit">Cadastrar</button>
            <p>Já tem cadastro?<a href="login.php"> Faça login</a></p>
        </form>

        <?php if (!empty($mensagem)): ?>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            <?php if (strpos($mensagem, 'sucesso') !== false): ?>
                showToast('<?= addslashes($mensagem) ?>', 'success');
            <?php elseif (strpos($mensagem, 'Erro') !== false): ?>
                showToast('<?= addslashes($mensagem) ?>', 'error');
            <?php else: ?>
                showToast('<?= addslashes($mensagem) ?>', 'warning');
            <?php endif; ?>
        });
    </script>
        <?php endif; ?>

        <footer>
            <p>Desenvolvido pela Eng. Automação</p>
            <p>&copy; Grupo Multi - <span id="ano-atual"></span></p>
        </footer>

    </div>

    <script src="src/js/toastRemove.js"></script>
    <script src="src/js/footerYear.js"></script>
</body>


</html>