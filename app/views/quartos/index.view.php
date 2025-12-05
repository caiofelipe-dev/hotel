<div class="card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="m-0">Quartos Cadastrados</h5>
        <a href="<?= route('quartos.create') ?>" class="btn btn-primary">Cadastrar Quarto</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nº</th>
                        <th>Descrição</th>
                        <th>Camas Casal</th>
                        <th>Camas Solteiro</th>
                        <th>Max Casal</th>
                        <th>Max Solteiro</th>
                        <th>Recursos</th>
                        <th>Preço Diária (R$)</th>
                        <th>Criado Em</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($quartos)): ?>
                        <?php foreach ($quartos as $q): ?>
                            <?php
                            // $q may be object (DB) or array (session)
                            $item = is_object($q) ? (array)$q : $q;
                            $id = $item['id'] ?? '';
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($item['numero'] ?? $item['id'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['descricao'] ?? '') ?></td>
                                <td><?= htmlspecialchars($item['qtd_camas_casal'] ?? 0) ?></td>
                                <td><?= htmlspecialchars($item['qtd_camas_solteiro'] ?? 0) ?></td>
                                <td><?= htmlspecialchars($item['max_camas_casal'] ?? 0) ?></td>
                                <td><?= htmlspecialchars($item['max_camas_solteiro'] ?? 0) ?></td>
                                <td>
                                    <?php
                                    $flags = [];
                                    foreach(['tem_ventilador','tem_ar_condicionado','tem_agua_quente','tem_banheira','tem_wifi','tem_frigobar','tem_tv','e_friendly_pet','e_acessivel'] as $f){
                                        if(!empty($item[$f])) $flags[] = ucfirst(str_replace(['tem_','e_','_'], ['', '', ' '], $f));
                                    }
                                    echo htmlspecialchars(implode(', ', $flags));
                                    ?>
                                </td>
                                <td><?= htmlspecialchars(number_format($item['preco_diaria'] ?? 0,2,',','.')) ?></td>
                                <td>
                                    <?php
                                        $created = $item['criado_em'] ?? '';
                                        if (!empty($created) && strtotime($created) !== false) {
                                            echo htmlspecialchars(date('d/m/Y H:i', strtotime($created)));
                                        } else {
                                            echo htmlspecialchars($created);
                                        }
                                    ?>
                                </td>
                                <td>
                                    <div class="d-flex flex-wrap gap-2">
                                        <a href="<?= route('quartos.edit')->setParamns(['id' => $id]) ?>" class="btn btn-sm btn-secondary">Editar</a>
                                        <form method="post" action="<?= route('quartos.destroy')->setParamns(['id' => $id]) ?>" class="m-0" onsubmit="return confirm('Confirma exclusão?');">
                                            <button class="btn btn-sm btn-danger">Excluir</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10" class="text-center">Nenhum quarto cadastrado</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
