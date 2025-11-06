<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Bem vindo, <?= $user ?? 'Visitante' ?></h1>
    <small class="text-muted"><?php echo date('d/m/Y H:i'); ?></small>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-body">
                Esta é a página inicial usando o template SB Admin como padrão.
            </div>
        </div>
    </div>
</div>
<?php
