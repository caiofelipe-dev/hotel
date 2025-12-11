<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0">Cargos Cadastrados</h5>
        <a href="<?= route('cargos.create') ?>" class="btn btn-primary">Cadastrar Cargo</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Nível de Acesso</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($cargos)): ?>
                        <?php foreach ($cargos as $c): ?>
                            <?php
                            $isObject = is_object($c);
                            $get = function($key) use ($c, $isObject) {
                                if ($isObject) return $c->$key ?? null;
                                return $c[$key] ?? null;
                            };
                            $id = $get('id') ?? '';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($get('nome') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('descricao') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('nivel_acesso') ?? '') ?></td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?= route('cargos.edit')->setParamns(['id' => $id]) ?>" class="btn btn-sm btn-secondary">Editar</a>
                                        <form method="post" action="<?= route('cargos.destroy')->setParamns(['id' => $id]) ?>" class="m-0" onsubmit="return confirm('Confirma exclusão?');">
                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Nenhum cargo cadastrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
