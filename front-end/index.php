<?php include 'includes/header.php'; ?>

<main>
    <section class="search-card">
        <form class="search-form" id="search-form">
            <input type="text" id="search-input" placeholder="Buscar Produto por Código" required>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>
    </section>

    <section class="edit-card" id="edit-section">
        <form class="edit-form" id="edit-form">
            <h3>Editar Dados do Produto</h3>
            <input type="hidden" id="edit-produto-original">
            <div class="form-grid">
                <div class="form-group">
                    <label for="edit-peso-min-menor">Peso Mín. Inner</label>
                    <input type="text" id="edit-peso-min-menor">
                </div>
                <div class="form-group">
                    <label for="edit-peso-min-maior">Peso Mín. Master</label>
                    <input type="text" id="edit-peso-min-maior">
                </div>
                <div class="form-group">
                    <label for="edit-peso-max-menor">Peso Máx. Inner</label>
                    <input type="text" id="edit-peso-max-menor">
                </div>
                <div class="form-group">
                    <label for="edit-peso-max-maior">Peso Máx. Master</label>
                    <input type="text" id="edit-peso-max-maior">
                </div>
                <div class="form-group">
                    <label for="edit-peso-start-menor">Peso Inicial Inner</label>
                    <input type="text" id="edit-peso-start-menor">
                </div>
                <div class="form-group">
                    <label for="edit-tamanho-fonte">Tamanho da Fonte</label>
                    <input type="text" id="edit-tamanho-fonte">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">Salvar Alterações</button>
            </div>
        </form>
    </section>
</main>

<?php include 'includes/footer.php'; ?>