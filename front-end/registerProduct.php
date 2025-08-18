<?php include 'includes/header.php'; ?>

<main>
    <section class="search-card">
        <form class="edit-form" id="register-form">
            <h3>Cadastrar Novo Produto</h3>
            
            <div class="form-grid">
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="reg-produto">Código do Produto</label>
                    <input type="text" id="reg-produto" required>
                </div>
                <div class="form-group">
                    <label for="reg-peso-min-menor">Peso Mín. Inner</label>
                    <input type="text" id="reg-peso-min-menor" required>
                </div>
                <div class="form-group">
                    <label for="reg-peso-min-maior">Peso Mín. Master</label>
                    <input type="text" id="reg-peso-min-maior" required>
                </div>
                <div class="form-group">
                    <label for="reg-peso-max-menor">Peso Máx. Inner</label>
                    <input type="text" id="reg-peso-max-menor" required>
                </div>
                <div class="form-group">
                    <label for="reg-peso-max-maior">Peso Máx. Master</label>
                    <input type="text" id="reg-peso-max-maior" required>
                </div>
                <div class="form-group">
                    <label for="reg-peso-start-menor">Peso Inicial Inner</label>
                    <input type="text" id="reg-peso-start-menor" required>
                </div>
                <div class="form-group">
                    <label for="reg-tamanho-fonte">Tamanho da Fonte</label>
                    <input type="text" id="reg-tamanho-fonte" required>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Cadastrar Produto
                </button>
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </section>
</main>

<script src="assets/js/product-register.js" defer></script>

<?php include 'includes/footer.php'; ?>