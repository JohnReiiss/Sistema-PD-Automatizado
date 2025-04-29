<?php
session_start();
include('includes/db.php');

if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

$produto = '';
$dados = null;

if (isset($_GET['produto'])) {
    $produto = $_GET['produto'];

    $sql = "SELECT * FROM PD_peso WHERE PRODUTO = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $produto);
    $stmt->execute();
    $resultado = $stmt->get_result();
    $dados = $resultado->fetch_assoc();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Sistema PD Automatizado</title>
    <link rel="stylesheet" href="src/styles/global-reset.css">
    <link rel="stylesheet" href="src/styles/index.css">
    <link rel="stylesheet" href="src/styles/index-navbar.css">
    <link rel="stylesheet" href="src/styles/toastbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
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
        <section id="busca-produto">
            <form method="get" action="" class="form-busca-produto">
                <a href="registerProduct.php" class="btn-novo-produto">Cadastrar Novo Produto</a>
                <input type="text" id="produto-busca" name="produto" value="<?= htmlspecialchars($produto) ?>"
                    placeholder="Buscar Produto" required>
                <button type="submit">Buscar</button>
            </form>
        </section>

        <section id="edicao-produto" style="display: <?= $dados ? 'block' : 'none' ?>;">
            <?php if ($dados): ?>
                <form method="POST" action="update.php">
                    <h3>Editar Dados do Produto</h3>

                    <input type="hidden" name="produto" value="<?= $dados['PRODUTO'] ?>">

                    <div class="form-group">
                        <label for="peso-min-menor">PESO MIN CX INNER:</label>
                        <input type="text" id="peso-min-menor" name="PESO_MIN_MENOR"
                            value="<?= $dados['PESO_MIN_MENOR'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="peso-min-maior">PESO MIN CX MASTER:</label>
                        <input type="text" id="peso-min-maior" name="PESO_MIN_MAIOR"
                            value="<?= $dados['PESO_MIN_MAIOR'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="peso-max-menor">PESO MAX CX INNER:</label>
                        <input type="text" id="peso-max-menor" name="PESO_MAX_MENOR"
                            value="<?= $dados['PESO_MAX_MENOR'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="peso-max-maior">PESO MAX CX MASTER:</label>
                        <input type="text" id="peso-max-maior" name="PESO_MAX_MAIOR"
                            value="<?= $dados['PESO_MAX_MAIOR'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="peso-start-menor">PESO INICIAL CX INNER:</label>
                        <input type="text" id="peso-start-menor" name="PESO_START_MENOR"
                            value="<?= $dados['PESO_START_MENOR'] ?>">
                    </div>

                    <div class="form-group">
                        <label for="tamanho-fonte">TAMANHO DA FONTE:</label>
                        <input type="text" id="tamanho-fonte" name="TAMANHO_FONTE" value="<?= $dados['TAMANHO_FONTE'] ?>">
                    </div>

                    <button type="submit">Salvar</button>
                </form>

            <?php elseif ($produto): ?>
                <p class="mensagem-erro">Produto não encontrado.</p>
                <script>
                    document.addEventListener('DOMContentLoaded', function () {
                        showToast('Produto não encontrado.', 'warning');
                    });
                </script>
            <?php endif; ?>
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
            let changed = false;

            if (url.searchParams.has('produto')) {
                url.searchParams.delete('produto');
                changed = true;
            }

            if (changed) {
                window.history.replaceState({}, document.title, url.pathname);
            }
        });
    </script>
</body>

</html>