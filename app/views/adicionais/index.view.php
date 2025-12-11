<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0">Adicionais Cadastrados</h5>
        <a href="<?= route('adicionais.create') ?>" class="btn btn-primary">Cadastrar Adicional</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Descrição</th>
                        <th>Ícone</th>
                        <th>Valor Referência</th>
                        <th>Disponível</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($adicionais)): ?>
                        <?php foreach ($adicionais as $a): ?>
                            <?php
                            $isObject = is_object($a);
                            $get = function($key) use ($a, $isObject) {
                                if ($isObject) return $a->$key ?? null;
                                return $a[$key] ?? null;
                            };
                            $id = $get('id') ?? '';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($get('descricao') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('icone') ?? '') ?></td>
                                <td>R$ <?= htmlspecialchars(number_format((float)($get('valor_referencia') ?? 0), 2, ',', '.')) ?></td>
                                <td>
                                    <span class="badge badge-<?= $get('disponivel') ? 'success' : 'danger' ?>">
                                        <?= $get('disponivel') ? 'Sim' : 'Não' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?= route('adicionais.edit')->setParamns(['id' => $id]) ?>" class="btn btn-sm btn-secondary">Editar</a>
                                        <form method="post" action="<?= route('adicionais.destroy')->setParamns(['id' => $id]) ?>" class="m-0" onsubmit="return confirm('Confirma exclusão?');">
                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center">Nenhum adicional cadastrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
