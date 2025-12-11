<div class="container mt-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="m-0">Detalhes da Sua Reserva</h5>
                </div>
                <div class="card-body">
                    <?php
                        $isObject = is_object($reserva);
                        $get = function($key) use ($reserva, $isObject) {
                            if ($isObject) return $reserva->$key ?? null;
                            return $reserva[$key] ?? null;
                        };
                    ?>
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">ID da Reserva</h6>
                            <p class="h5"><?= htmlspecialchars($get('id') ?? '') ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Status</h6>
                            <p>
                                <span class="badge badge-<?= $get('status') === 'confirmada' ? 'success' : ($get('status') === 'cancelada' ? 'danger' : 'warning') ?>">
                                    <?= htmlspecialchars($get('status') ?? '') ?>
                                </span>
                            </p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Data de Check-in</h6>
                            <p class="h5"><?= htmlspecialchars($get('data_checkin') ?? '') ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Data de Check-out</h6>
                            <p class="h5"><?= htmlspecialchars($get('data_checkout') ?? '') ?></p>
                        </div>
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Valor Total</h6>
                            <p class="h5">R$ <?= htmlspecialchars(number_format((float)($get('valor_total') ?? 0), 2, ',', '.')) ?></p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Origem da Reserva</h6>
                            <p class="h5"><?= htmlspecialchars($get('origem_reserva') ?? '') ?></p>
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <strong>Informações Importantes:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Verifique os detalhes da sua reserva acima</li>
                            <li>Você pode usar este link para acessar sua reserva a qualquer momento</li>
                            <li>Para modificações, entre em contato conosco</li>
                        </ul>
                    </div>

                    <div class="d-flex gap-2">
                        <button class="btn btn-primary" onclick="window.print()">Imprimir</button>
                        <a href="<?= route('home') ?>" class="btn btn-secondary">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
