<div class="card mb-4">
    <div class="card-header"><h5>Editar Quarto</h5></div>
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
            // limpar sessão (flash)
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
        <form method="post" action="<?= route('quartos.update')->setParamns(['id' => $quarto->id ?? '']) ?>">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Descrição</label>
                    <?php $fieldErrs = $errors['descricao'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="descricao" class="form-control<?= $isInvalid?>" value="<?= htmlspecialchars($old['descricao'] ?? $quarto->descricao ?? '') ?>" required placeholder="Ex: Suíte Luxo, Descrição breve do quarto">
                    <div class="form-text">Informe o nome/descrição do quarto (ex: Suíte Luxo).</div>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-2">
                    <label class="form-label">Nº do Quarto</label>
                    <?php $fieldErrs = $errors['numero'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="numero" class="form-control<?= $isInvalid?>" value="<?= htmlspecialchars($old['numero'] ?? $quarto->numero ?? $quarto->id ?? '') ?>" required placeholder="Ex: 101">
                    <div class="form-text">Identificação numérica do quarto (ex: 101).</div>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-2">
                    <label class="form-label">Camas Casal</label>
                    <?php $fieldErrs = $errors['qtd_camas_casal'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="qtd_camas_casal" type="number" min="0" class="form-control<?= $isInvalid?>" value="<?= htmlspecialchars($old['qtd_camas_casal'] ?? $quarto->qtd_camas_casal ?? 0) ?>" required placeholder="Ex: 1">
                    <div class="form-text">Quantidade de camas de casal disponíveis no quarto.</div>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-2">
                    <label class="form-label">Camas Solteiro</label>
                    <?php $fieldErrs = $errors['qtd_camas_solteiro'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="qtd_camas_solteiro" type="number" min="0" class="form-control<?= $isInvalid?>" value="<?= htmlspecialchars($old['qtd_camas_solteiro'] ?? $quarto->qtd_camas_solteiro ?? 0) ?>" required placeholder="Ex: 2">
                    <div class="form-text">Quantidade de camas de solteiro disponíveis no quarto.</div>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-3">
                    <label class="form-label">Max Casal</label>
                    <?php $fieldErrs = $errors['max_camas_casal'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="max_camas_casal" type="number" min="0" class="form-control<?= $isInvalid?>" value="<?= htmlspecialchars($old['max_camas_casal'] ?? $quarto->max_camas_casal ?? 0) ?>" required placeholder="Ex: 2">
                    <div class="form-text">Máximo de camas de casal permitidas (capacidade).</div>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">Max Solteiro</label>
                    <?php $fieldErrs = $errors['max_camas_solteiro'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="max_camas_solteiro" type="number" min="0" class="form-control<?= $isInvalid?>" value="<?= htmlspecialchars($old['max_camas_solteiro'] ?? $quarto->max_camas_solteiro ?? 0) ?>" required placeholder="Ex: 2">
                    <div class="form-text">Máximo de camas de solteiro permitidas (capacidade).</div>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-3">
                    <label class="form-label">Valor da Diária (R$)</label>
                    <?php $fieldErrs = $errors['preco_diaria'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="preco_diaria" type="text" class="form-control<?= $isInvalid?>" value="<?= htmlspecialchars($old['preco_diaria'] ?? $quarto->preco_diaria ?? '') ?>" required placeholder="Ex: 120.00">
                    <div class="form-text">Valor da diária em reais. Use ponto como separador decimal (ex: 120.00).</div>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>

            <h6>Recursos</h6>
            <div class="row mb-3">
                <?php
                $recursos = [
                    'tem_ventilador' => 'Ventilador',
                    'tem_ar_condicionado' => 'Ar-condicionado',
                    'tem_agua_quente' => 'Água quente',
                    'tem_banheira' => 'Banheira',
                    'tem_wifi' => 'Wi-Fi',
                    'tem_frigobar' => 'Frigo-bar',
                    'tem_tv' => 'TV',
                    'e_friendly_pet' => 'Friendly Pet',
                    'e_acessivel' => 'Acessível'
                ];
                foreach($recursos as $key => $label):
                    $checked = !empty($old[$key]) ? 'checked' : (!empty($quarto->{$key}) ? 'checked' : '');
                ?>
                    <div class="col-md-3 form-check">
                        <input class="form-check-input" type="checkbox" name="<?= $key ?>" id="<?= $key ?>" <?= $checked ?> >
                        <label class="form-check-label" for="<?= $key ?>"><?= $label ?></label>
                    </div>
                <?php endforeach; ?>
            </div>

            <button class="btn btn-success">Salvar</button>
            <a href="<?= route('quartos.index') ?>" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
