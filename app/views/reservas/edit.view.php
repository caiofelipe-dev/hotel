<div class="card">
    <div class="card-header"><h5>Editar Reserva</h5></div>
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
            
            $isObject = is_object($reserva);
            $get = function($key) use ($reserva, $isObject, $old) {
                if (!empty($old[$key])) return $old[$key];
                if ($isObject) return $reserva->$key ?? null;
                return $reserva[$key] ?? null;
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
        <form method="post" action="<?= route('reservas.update')->setParamns(['id' => $reserva->id]) ?>">
            <div class="row">
                <div class="mb-3 col-md-6">
                    <label class="form-label">Hóspede</label>
                    <?php $fieldErrs = $errors['hospedes_id'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <select name="hospedes_id" class="form-control<?= $isInvalid?>" required>
                        <option value="">Selecione um hóspede</option>
                        <?php foreach ($hospedes as $h): ?>
                            <option value="<?= $h->id ?>" <?= ($get('hospedes_id') ?? '') == $h->id ? 'selected' : '' ?>>
                                <?= htmlspecialchars($h->nome) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-6">
                    <label class="form-label">Origem da Reserva</label>
                    <?php $fieldErrs = $errors['origem_reserva'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <select name="origem_reserva" class="form-control<?= $isInvalid?>" required>
                        <option value="">Selecione</option>
                        <option value="online" <?= ($get('origem_reserva') ?? '') == 'online' ? 'selected' : '' ?>>Online</option>
                        <option value="presencial" <?= ($get('origem_reserva') ?? '') == 'presencial' ? 'selected' : '' ?>>Presencial</option>
                    </select>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="mb-3 col-md-4">
                    <label class="form-label">Data Check-in</label>
                    <?php $fieldErrs = $errors['data_checkin'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="data_checkin" type="date" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($get('data_checkin') ?? '') ?>">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">Data Check-out</label>
                    <?php $fieldErrs = $errors['data_checkout'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <input name="data_checkout" type="date" class="form-control<?= $isInvalid?>" required value="<?= htmlspecialchars($get('data_checkout') ?? '') ?>">
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
                <div class="mb-3 col-md-4">
                    <label class="form-label">Status</label>
                    <?php $fieldErrs = $errors['status'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                    <select name="status" class="form-control<?= $isInvalid?>" required>
                        <option value="">Selecione</option>
                        <option value="esperando" <?= ($get('status') ?? '') == 'esperando' ? 'selected' : '' ?>>Esperando</option>
                        <option value="confirmada" <?= ($get('status') ?? '') == 'confirmada' ? 'selected' : '' ?>>Confirmada</option>
                        <option value="encerrada" <?= ($get('status') ?? '') == 'encerrada' ? 'selected' : '' ?>>Encerrada</option>
                        <option value="cancelada" <?= ($get('status') ?? '') == 'cancelada' ? 'selected' : '' ?>>Cancelada</option>
                    </select>
                    <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                        <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                    <?php endforeach; endif; ?>
                </div>
            </div>
            <div class="mb-3">
                <label class="form-label">Valor Total (R$)</label>
                <?php $fieldErrs = $errors['valor_total'] ?? []; $isInvalid = !empty($fieldErrs) ? ' is-invalid' : ''; ?>
                <input name="valor_total" type="text" class="form-control<?= $isInvalid?>" required placeholder="0.00" value="<?= htmlspecialchars($get('valor_total') ?? '') ?>">
                <?php if(!empty($fieldErrs)): foreach($fieldErrs as $msg): ?>
                    <div class="invalid-feedback d-block"><?= htmlspecialchars($msg) ?></div>
                <?php endforeach; endif; ?>
            </div>
            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary">Atualizar</button>
                <a href="<?= route('reservas.index') ?>" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    </div>
</div>
