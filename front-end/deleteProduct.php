<?php include 'includes/header.php'; ?>

<main>
    <section class="search-card">
        <form class="edit-form" id="delete-form">
            <h3>Excluir Produto</h3>
            <p style="text-align: center; margin-bottom: 20px;">Digite o código do produto que deseja excluir. Esta ação
                não pode ser desfeita.</p>

            <div class="form-group" style="grid-column: 1 / -1;">
                <label for="delete-produto">Código do Produto</label>
                <input type="text" id="delete-produto" required>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-danger">
                    <i class="fas fa-trash"></i> Excluir Produto
                </button>
            </div>
        </form>
    </section>
</main>

<script src="assets/js/product-delete.js" defer></script>

<?php include 'includes/footer.php'; ?>