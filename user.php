<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];

$sql = "SELECT USUARIO, TIPO_ACESSO FROM PD_usuario WHERE ID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 1) {
    $usuario = $result->fetch_assoc();
} else {
    echo "Usuário não encontrado.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Painel do Usuário</title>
    <link rel="stylesheet" href="src/styles/global-reset.css">
    <link rel="stylesheet" href="src/styles/user-navbar.css">
    <link rel="stylesheet" href="src/styles/user.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <div class="header-left">
            <div class="user-menu">
                <a href="user.php" class="user-link">
                    <i class="fa-solid fa-user" id="user-icon"></i>
                    <span class="sr-only">Perfil</span>
                </a>
            </div>
            <div class="saudacao">
                <h2 id="saudacao"><span id="nome-usuario"><?php echo htmlspecialchars($usuario['USUARIO']); ?></span>!
                </h2>
            </div>
        </div>
        <div class="header-center">
            <h1>Sistema PD Automatizado</h1>
        </div>
        <div class="header-right">
            <div class="logout-menu">
                <a href="logout.php" class="logout-link">
                    <i class="fa-solid fa-right-from-bracket" id="logout-icon"></i>
                </a>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="user-info">
            <i class="fa-solid fa-user section-icon" aria-hidden="true"></i>
            <h2 class="titulo">Painel do Usuário</h2>
            <p class="descricao">Bem-vindo ao seu painel.</p>

            <div class="informacoes-usuario">
                <h4>Informações do Usuário</h4>
                <p><strong>Nome:</strong> <?php echo htmlspecialchars($usuario['USUARIO']); ?></p>
                <p><strong>Tipo de Acesso:</strong> <?php echo htmlspecialchars($usuario['TIPO_ACESSO']); ?></p>
            </div>
        </section>
    </main>

    <footer>
        <p>Desenvolvido pela Eng. Automação</p>
        <p>&copy; Grupo Multi - <span id="ano-atual"></span></p>
    </footer>

    <script src="src/js/saudacao.js"></script>
    <script src="src/js/footerYear.js"></script>
</body>

</html>