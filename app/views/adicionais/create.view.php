<div class="card">
    <div class="card-header"><h5>Cadastrar Adicional</h5></div>
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
        <form method="post" action="<?= route('adicionais.store') ?>">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Descrição</label>
                    <?php $fieldErrs = $errors['descricao'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="descricao" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['descricao'] ?? '') ?>" placeholder="Ex: Bebida, Serviço de Limpeza">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Ícone (opcional)</label>
                    <input name="icone" class="form-control" value="<?= htmlspecialchars($old['icone'] ?? '') ?>" placeholder="Ex: fas fa-wine-glass">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Valor de Referência (R$)</label>
                    <?php $fieldErrs = $errors['valor_referencia'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="valor_referencia" type="text" class="form-control<?= $isInvalid?>" required placeholder="0.00" value="<?= htmlspecialchars($old['valor_referencia'] ?? '') ?>">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Disponível</label>
                    <div class="form-check">
                        <input name="disponivel" type="checkbox" class="form-check-input" id="disponivel" value="1" <?= !empty($old['disponivel']) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="disponivel">Marque para disponibilizar este adicional</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="<?= route('adicionais.index') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
