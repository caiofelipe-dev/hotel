<div class="row justify-content-center">
    <div class="col-lg-7">
        <div class="card o-hidden border-0 shadow-lg my-5">
            <div class="card-body p-4">
                <div class="text-center mb-3">
                    <h1 class="h4 text-gray-900 mb-2">Cadastro de Quarto</h1>
                    <p class="mb-0">Preencha os dados do quarto abaixo</p>
                </div>
                <form class="user" method="post" action="/quartos">
                    <div class="form-group">
                        <input type="text" name="numero" class="form-control form-control-user" placeholder="Número" required>
                    </div>
                    <div class="form-group">
                        <textarea name="descricao" class="form-control" placeholder="Descrição" rows="3"></textarea>
                    </div>
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <input type="number" name="cama_casal_min" class="form-control" placeholder="Casal min" min="0">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="number" name="cama_casal_max" class="form-control" placeholder="Casal max" min="0">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="number" name="cama_solteiro_min" class="form-control" placeholder="Solteiro min" min="0">
                        </div>
                        <div class="form-group col-md-3">
                            <input type="number" name="cama_solteiro_max" class="form-control" placeholder="Solteiro max" min="0">
                        </div>
                    </div>

                    <div class="form-row mb-3">
                        <div class="form-group col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="arcondicionado" id="arcond">
                                <label class="form-check-label" for="arcond">Ar Condicionado</label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="banheiro" id="banho">
                                <label class="form-check-label" for="banho">Banheiro</label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="frigobar" id="frigo">
                                <label class="form-check-label" for="frigo">Frigobar</label>
                            </div>
                        </div>
                        <div class="form-group col-md-3">
                            <input type="text" name="valor" class="form-control" placeholder="Valor (ex: 100.00)">
                        </div>
                    </div>

                    <button class="btn btn-primary btn-user btn-block" type="submit">Cadastrar Quarto</button>
                </form>
            </div>
        </div>
    </div>
</div>
