<div class="card">
    <div class="card-header"><h5>Cadastrar Cargo</h5></div>
    <div class="card-body">
        <?php
            $errors = session_get('errors', []);
            $old = session_get('old', []);
            $flatErrors = [];
            foreach($errors as $k => $v){
                if (is_array($v)) {
                    $flatErrors = array_merge($flatErrors, $v);
                } else {
                    $flatErrors[] = $v;
                }
            }
            session_forget('errors');
            session_forget('old');
        ?>
        <?php if (!empty($flatErrors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach($flatErrors as $err): ?>
                        <li><?= htmlspecialchars($err) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>
        <form method="post" action="<?= route('cargos.store') ?>">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Nome</label>
                    <?php $fieldErrs = $errors['nome'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="nome" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['nome'] ?? '') ?>" placeholder="Ex: Gerente, Recepcionista">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Nível de Acesso</label>
                    <?php $fieldErrs = $errors['nivel_acesso'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="nivel_acesso" type="number" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['nivel_acesso'] ?? '') ?>" placeholder="1">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição (opcional)</label>
                <textarea name="descricao" class="form-control" placeholder="Descrição do cargo" rows="3"><?= htmlspecialchars($old['descricao'] ?? '') ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="<?= route('cargos.index') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
