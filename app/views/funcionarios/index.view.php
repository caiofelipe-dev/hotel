<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0">Funcionários Cadastrados</h5>
        <a href="<?= route('funcionarios.create') ?>" class="btn btn-primary">Cadastrar Funcionário</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Login</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>CPF</th>
                        <th>Telefone</th>
                        <th>Ativo</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($funcionarios)): ?>
                        <?php foreach ($funcionarios as $f): ?>
                            <?php
                            $isObject = is_object($f);
                            $get = function($key) use ($f, $isObject) {
                                if ($isObject) return $f->$key ?? null;
                                return $f[$key] ?? null;
                            };
                            $id = $get('id') ?? '';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($get('login') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('nome') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('email') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('cpf') ?? '') ?></td>
                                <td><?= htmlspecialchars($get('telefone') ?? '') ?></td>
                                <td>
                                    <span class="badge badge-<?= $get('ativo') ? 'success' : 'danger' ?>">
                                        <?= $get('ativo') ? 'Sim' : 'Não' ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?= route('funcionarios.edit')->setParamns(['id' => $id]) ?>" class="btn btn-sm btn-secondary">Editar</a>
                                        <form method="post" action="<?= route('funcionarios.destroy')->setParamns(['id' => $id]) ?>" class="m-0" onsubmit="return confirm('Confirma exclusão?');">
                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">Nenhum funcionário cadastrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
