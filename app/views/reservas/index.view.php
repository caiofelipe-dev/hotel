<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0">Reservas Cadastradas</h5>
        <a href="<?= route('reservas.create') ?>" class="btn btn-primary">Criar Reserva</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Hóspede</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Valor Total</th>
                        <th>Origem</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($reservas)): ?>
                        <?php foreach ($reservas as $r): ?>
                            <?php
                            $isObject = is_object($r);
                            $get = function($key) use ($r, $isObject) {
                                if ($isObject) return $r->$key ?? null;
                                return $r[$key] ?? null;
                            };
                            $id = $get('id') ?? '';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($id) ?></td>
                                <td><?= htmlspecialchars($get('hospedes_id') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('data_checkin') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('data_checkout') ?? '') ?></td>
                                <td>
                                    <span class="badge badge-<?= $get('status') === 'confirmada' ? 'success' : ($get('status') === 'cancelada' ? 'danger' : 'warning') ?>">
                                        <?= htmlspecialchars($get('status') ?? '') ?>
                                    </span>
                                </td>
                                <td>R$ <?= htmlspecialchars(number_format((float)($get('valor_total') ?? 0), 2, ',', '.')) ?></td>
                                <td><?= htmlspecialchars($get('origem_reserva') ?? '') ?></td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?= route('reservas.edit')->setParamns(['id' => $id]) ?>" class="btn btn-sm btn-secondary">Editar</a>
                                        <form method="post" action="<?= route('reservas.destroy')->setParamns(['id' => $id]) ?>" class="m-0" onsubmit="return confirm('Confirma exclusão?');">
                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8" class="text-center">Nenhuma reserva cadastrada</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
