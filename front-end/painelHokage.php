<?php include 'includes/header.php'; ?>

<main>
    <section class="search-card" id="hokage-panel-card">
        
        <div class="panel-header">
            <img class="panel-logo" src="assets/images/logo-painel-hokage.png" alt="Logo Painel do Hokage">
            <h3>Painel do Hokage</h3>
        </div>

        <p style="text-align: center; margin-top: -15px; margin-bottom: 20px;">Total de usuários cadastrados: <span id="total-users">Carregando...</span></p>

        <div class="tabs">
            <button class="tab-link active" data-tab="tab-create">Cadastrar</button>
            <button class="tab-link" data-tab="tab-edit-delete">Editar / Excluir</button>
        </div>

        <div id="tab-create" class="tab-content active">
            <form id="create-user-form" class="edit-form" style="margin-top: 20px;">
                <h4>Cadastrar Novo Usuário</h4>
                <div class="form-grid">
                    <div class="form-group"><label for="new-user-name">Usuário</label><input type="text" id="new-user-name" required></div>
                    <div class="form-group"><label for="new-user-password">Senha</label><input type="password" id="new-user-password" required></div>
                    <div class="form-group full-width"><label for="new-user-role">Nível de Acesso</label><select id="new-user-role"><option value="OPERADOR">OPERADOR</option><option value="ADMINISTRADOR">ADMINISTRADOR</option><option value="HOKAGE">HOKAGE</option></select></div>
                </div>
                <div class="form-actions"><button type="submit" class="btn btn-primary">Cadastrar</button></div>
            </form>
        </div>

        <div id="tab-edit-delete" class="tab-content">
            <form id="edit-user-form" class="edit-form" style="margin-top: 20px;">
                <h4>Editar ou Excluir Usuário</h4>
                <div class="form-grid">
                    <div class="form-group full-width"><label for="select-user">Selecione um Usuário</label><select id="select-user"><option value="">Carregando...</option></select></div>
                    
                    <div class="form-group grid-col-1"><label for="edit-user-name">Novo Nome</label><input type="text" id="edit-user-name" disabled></div>
                    <div class="form-group grid-col-2"><label for="edit-user-password">Nova Senha (deixe em branco para não alterar)</label><input type="password" id="edit-user-password"></div>

                    <div class="form-group full-width"><label for="edit-user-role">Novo Nível de Acesso</label><select id="edit-user-role"><option value="OPERADOR">OPERADOR</option><option value="ADMINISTRADOR">ADMINISTRADOR</option><option value="HOKAGE">HOKAGE</option></select></div>
                </div>
                <div class="form-actions">
                    <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    <button type="button" id="delete-user-button" class="btn btn-danger">Excluir Usuário</button>
                </div>
            </form>
        </div>
    </section>
</main>

<script src="assets/js/hokage-panel.js" defer></script>
<?php include 'includes/footer.php'; ?>