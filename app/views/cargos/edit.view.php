<div class="card">
    <div class="card-header"><h5>Editar Cargo</h5></div>
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
            
            $isObject = is_object($cargo);
            $get = function($key) use ($cargo, $isObject, $old) {
                if (!empty($old[$key])) return $old[$key];
                if ($isObject) return $cargo->$key ?? null;
                return $cargo[$key] ?? null;
            };
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
        <form method="post" action="<?= route('cargos.update')->setParamns(['id' => $cargo->id]) ?>">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Nome</label>
                    <?php $fieldErrs = $errors['nome'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="nome" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($get('nome') ?? '') ?>" placeholder="Ex: Gerente, Recepcionista">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Nível de Acesso</label>
                    <?php $fieldErrs = $errors['nivel_acesso'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="nivel_acesso" type="number" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($get('nivel_acesso') ?? '') ?>" placeholder="1">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição (opcional)</label>
                <textarea name="descricao" class="form-control" placeholder="Descrição do cargo" rows="3"><?= htmlspecialchars($get('descricao') ?? '') ?></textarea>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="<?= route('cargos.index') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
