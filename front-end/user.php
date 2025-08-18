<?php include 'includes/header.php'; ?>

<main>
    <section class="search-card" id="profile-card">
        <h3 id="profile-greeting">Perfil do Usuário</h3>
        
        <form id="profile-form">
            <input type="hidden" id="user-id">
            <div class="form-grid">
                <div class="form-group">
                    <label>Nome de Usuário</label>
                    <input type="text" id="profile-usuario" disabled>
                </div>
                <div class="form-group">
                    <label for="profile-role">Nível de Acesso</label>
                    <select id="profile-role" disabled>
                        <option value="OPERADOR">OPERADOR</option>
                        <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                    </select>
                </div>
                <div class="form-group" style="grid-column: 1 / -1;">
                    <label for="profile-senha">Alterar Senha (deixe em branco para não mudar)</label>
                    <input type="password" id="profile-senha" placeholder="Digite a nova senha" disabled>
                </div>
            </div>
            
            <div class="form-actions">
                <button type="submit" class="btn btn-primary" id="save-profile-button" disabled>
                    <i class="fas fa-save"></i> Salvar Alterações
                </button>
            </div>
        </form>
    </section>
</main>

<script src="assets/js/user-profile.js" defer></script>

<?php include 'includes/footer.php'; ?>