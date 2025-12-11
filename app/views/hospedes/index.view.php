<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0">Hóspedes Cadastrados</h5>
        <a href="<?= route('hospedes.create') ?>" class="btn btn-primary">Cadastrar Hóspede</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Telefone</th>
                        <th>CPF</th>
                        <th>Nacionalidade</th>
                        <th>Data Nascimento</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($hospedes)): ?>
                        <?php foreach ($hospedes as $h): ?>
                            <?php
                            $isObject = is_object($h);
                            $get = function($key) use ($h, $isObject) {
                                if ($isObject) return $h->$key ?? null;
                                return $h[$key] ?? null;
                            };
                            $id = $get('id') ?? '';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($get('nome') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('email') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('telefone') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('cpf') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('nacionalidade') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('data_nascimento') ?? '') ?></td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?= route('hospedes.edit')->setParamns(['id' => $id]) ?>" class="btn btn-sm btn-secondary">Editar</a>
                                        <form method="post" action="<?= route('hospedes.destroy')->setParamns(['id' => $id]) ?>" class="m-0" onsubmit="return confirm('Confirma exclusão?');">
                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum hóspede cadastrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
