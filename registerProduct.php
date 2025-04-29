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

    // Verificar se o produto já existe
    $sql_check = "SELECT 1 FROM PD_peso WHERE PRODUTO = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("s", $produto);
    $stmt_check->execute();
    $result_check = $stmt_check->get_result();

    if ($result_check->num_rows > 0) {
        // Produto já existe
        $_SESSION['toast_message'] = "Erro: Produto já cadastrado!";
        $_SESSION['toast_type'] = "error";
    } else {
        // Produto não existe, pode cadastrar
        $sql = "INSERT INTO PD_peso (
                PRODUTO, PESO_MIN_MENOR, PESO_MAX_MENOR, PESO_START_MENOR,
                PESO_MIN_MAIOR, PESO_MAX_MAIOR, TAMANHO_FONTE, REVISAO,
                DATA_HORA, USUARIO
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $conn->prepare($sql);
        $stmt->bind_param(
            "ssssssssss",
            $produto,
            $peso_min_menor,
            $peso_max_menor,
            $peso_start_menor,
            $peso_min_maior,
            $peso_max_maior,
            $tamanho_fonte,
            $revisao,
            $data_hora,
            $nome_usuario
        );

        if ($stmt->execute()) {
            $_SESSION['toast_message'] = "Produto cadastrado com sucesso!";
            $_SESSION['toast_type'] = "success";
        } else {
            $_SESSION['toast_message'] = "Erro ao cadastrar o produto.";
            $_SESSION['toast_type'] = "error";
        }
    }

    header("Location: registerProduct.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro de Produto - Sistema PD Automatizado</title>
    <link rel="stylesheet" href="src/styles/global-reset.css">
    <link rel="stylesheet" href="src/styles/index.css">
    <link rel="stylesheet" href="src/styles/register-product.css">
    <link rel="stylesheet" href="src/styles/index-navbar.css">
    <link rel="stylesheet" href="src/styles/toastbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body>
    <header>
        <nav>
            <div class="navbar">
                <div class="user-menu">
                    <a href="user.php" class="user-link">
                        <i class="fa-solid fa-user" id="user-icon"></i>
                    </a>
                </div>
                <div class="logout-menu">
                    <a href="logout.php" class="logout-link">
                        <i class="fa-solid fa-right-from-bracket" id="logout-icon"></i>
                    </a>
                </div>
                <h2 class="navbar-title">Sistema PD Automatizado</h2>
            </div>
        </nav>
    </header>

    <main>
        <section id="cadastro-produto">
            <form method="POST" action="registerProduct.php">
                <h3>Cadastrar Novo Produto</h3>

                <div class="form-group">
                    <label for="produto">Produto:</label>
                    <input type="text" id="produto" name="produto" required>
                </div>

                <div class="form-group">
                    <label for="peso-min-menor">PESO MIN CX INNER:</label>
                    <input type="text" id="peso-min-menor" name="PESO_MIN_MENOR" required>
                </div>

                <div class="form-group">
                    <label for="peso-min-maior">PESO MIN CX MASTER:</label>
                    <input type="text" id="peso-min-maior" name="PESO_MIN_MAIOR" required>
                </div>

                <div class="form-group">
                    <label for="peso-max-menor">PESO MAX CX INNER:</label>
                    <input type="text" id="peso-max-menor" name="PESO_MAX_MENOR" required>
                </div>

                <div class="form-group">
                    <label for="peso-max-maior">PESO MAX CX MASTER:</label>
                    <input type="text" id="peso-max-maior" name="PESO_MAX_MAIOR" required>
                </div>

                <div class="form-group">
                    <label for="peso-start-menor">PESO INICIAL CX INNER:</label>
                    <input type="text" id="peso-start-menor" name="PESO_START_MENOR" required>
                </div>

                <div class="form-group">
                    <label for="tamanho-fonte">TAMANHO DA FONTE:</label>
                    <input type="text" id="tamanho-fonte" name="TAMANHO_FONTE" required>
                </div>

                <div class="form-group">
                    <label for="revisao">Revisão:</label>
                    <input type="text" id="revisao" name="REVISAO" required>
                </div>

                <button type="submit">Cadastrar Produto</button>
            </form>
        </section>
    </main>

    <footer>
        <p>Desenvolvido pela Eng. Automação</p>
        <p>&copy; Grupo Multi - <span id="ano-atual"></span></p>
    </footer>

    <script src="/PD_Automatizado_Login/src/js/toastRemove.js"></script>
    <script src="/PD_Automatizado_Login/src/js/footerYear.js"></script>

    <?php if (isset($_SESSION['toast_message'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                showToast('<?= addslashes($_SESSION['toast_message']) ?>', '<?= $_SESSION['toast_type'] ?>');
            });
        </script>
        <?php unset($_SESSION['toast_message'], $_SESSION['toast_type']); ?>
    <?php endif; ?>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const url = new URL(window.location);
            if (url.search.length > 0) {
                window.history.replaceState({}, document.title, url.pathname);
            }
        });
    </script>

</body>

</html>