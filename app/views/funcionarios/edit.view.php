<div class="card">
    <div class="card-header"><h5>Editar Funcionário</h5></div>
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
            
            $isObject = is_object($funcionario);
            $get = function($key) use ($funcionario, $isObject, $old) {
                if (!empty($old[$key])) return $old[$key];
                if ($isObject) return $funcionario->$key ?? null;
                return $funcionario[$key] ?? null;
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
        <form method="post" action="<?= route('funcionarios.update')->setParamns(['id' => $funcionario->id]) ?>">
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label class="form-label">Login</label>
                    <?php $fieldErrs = $errors['login'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="login" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($get('login') ?? '') ?>" placeholder="username">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">Senha (deixe em branco para manter)</label>
                    <?php $fieldErrs = $errors['senha'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="senha" type="password" class="form-control<?= $isInvalid?>" placeholder="Mínimo 6 caracteres">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">Cargo</label>
                    <?php $fieldErrs = $errors['cargos_id'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <select name="cargos_id" class="form-control<?= $isInvalid?>" required>
                        <option value="">Selecione um cargo</option>
                        <?php foreach ($cargos as $c): ?>
                            <option value="<?= $c->id ?>" <?= ($get('cargos_id') ?? '') == $c->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c->nome) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Nome</label>
                    <?php $fieldErrs = $errors['nome'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="nome" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($get('nome') ?? '') ?>" placeholder="Nome completo">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Email</label>
                    <?php $fieldErrs = $errors['email'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="email" type="email" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($get('email') ?? '') ?>" placeholder="email@example.com">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label class="form-label">CPF</label>
                    <?php $fieldErrs = $errors['cpf'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="cpf" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($get('cpf') ?? '') ?>" placeholder="12345678900">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">RG</label>
                    <input name="rg" class="form-control" value="<?= htmlspecialchars($get('rg') ?? '') ?>" placeholder="RG">
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">Telefone</label>
                    <input name="telefone" class="form-control" value="<?= htmlspecialchars($get('telefone') ?? '') ?>" placeholder="(11) 99999-9999">
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Nível de Acesso</label>
                    <input name="nivel_acesso" type="number" class="form-control" value="<?= htmlspecialchars($get('nivel_acesso') ?? '') ?>" placeholder="1">
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Ativo</label>
                    <div class="form-check">
                        <input name="ativo" type="checkbox" class="form-check-input" id="ativo" value="1" <?= !empty($get('ativo')) ? 'checked' : '' ?>>
                        <label class="form-check-label" for="ativo">Marque para ativar este funcionário</label>
                    </div>
                </div>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="<?= route('funcionarios.index') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
