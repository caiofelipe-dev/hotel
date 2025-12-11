<div class="card">
    <div class="card-header"><h5>Cadastrar Hóspede</h5></div>
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
        <form method="post" action="<?= route('hospedes.store') ?>">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Nome</label>
                    <?php $fieldErrs = $errors['nome'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="nome" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['nome'] ?? '') ?>" placeholder="Nome completo">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <?php $fieldErrs = $errors['email'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="email" type="email" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['email'] ?? '') ?>" placeholder="email@example.com">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label class="form-label">Telefone</label>
                    <?php $fieldErrs = $errors['telefone'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="telefone" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['telefone'] ?? '') ?>" placeholder="(11) 99999-9999">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">CPF</label>
                    <?php $fieldErrs = $errors['cpf'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="cpf" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['cpf'] ?? '') ?>" placeholder="12345678900">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">Data de Nascimento</label>
                    <?php $fieldErrs = $errors['data_nascimento'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="data_nascimento" type="date" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['data_nascimento'] ?? '') ?>">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Nacionalidade</label>
                    <?php $fieldErrs = $errors['nacionalidade'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="nacionalidade" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($old['nacionalidade'] ?? '') ?>" placeholder="Brasileira">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Endereço</label>
                <?php $fieldErrs = $errors['endereco'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                <textarea name="endereco" class="form-control<?= $isInvalid?>" required placeholder="Rua, número, complemento, cidade"><?= htmlspecialchars($old['endereco'] ?? '') ?></textarea>
                <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                    <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                <?php endforeach; endif; ?>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Salvar</button>
                <a href="<?= route('hospedes.index') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
