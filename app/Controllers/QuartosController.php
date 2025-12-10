<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Router;
use App\Models\Quarto;

// helpers de sessão adicionados para simplificar acesso (session_get / session_set)
use function session_get;
use function session_set;
use function session_forget;

class QuartosController extends Controller
{
    public function create()
    {
        return view('quartos.create');
    }

    public function index()
    {
        try {
            $quartos = Quarto::all();
        } catch (\Throwable $e) {
            // Erro ao acessar banco — retorna lista vazia e registra mensagem de sessão
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            $quartos = [];
        }
        return view('quartos.index', ['title' => 'Quartos', 'quartos' => $quartos]);
    }

    public function edit($id)
    {
        try {
            $quarto = Quarto::find($id);
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            return Router::getRouteByName('quartos.index')->redirect();
        }
        if (!$quarto) {
            // registro não encontrado
            session_set('errors', ['not_found' => 'Quarto não encontrado.']);
            return Router::getRouteByName('quartos.index')->redirect();
        }
        return view('quartos.edit', ['title' => 'Editar Quarto', 'quarto' => $quarto]);
    }

    public function update($id)
    {
        // mapeamento para os nomes das colunas do banco (storage/sql/blank.sql)
        $data = Request::only(
            'numero',
            'descricao',
            'preco_diaria',
            'qtd_camas_casal',
            'qtd_camas_solteiro',
            'max_camas_casal',
            'max_camas_solteiro',
            'tem_ventilador',
            'tem_ar_condicionado',
            'tem_agua_quente',
            'tem_banheira',
            'tem_wifi',
            'tem_frigobar',
            'tem_tv',
            'e_friendly_pet',
            'e_acessivel'
        );

        // normaliza checkboxes para 1/0
        $checkboxes = ['tem_ventilador','tem_ar_condicionado','tem_agua_quente','tem_banheira','tem_wifi','tem_frigobar','tem_tv','e_friendly_pet','e_acessivel'];
        foreach ($checkboxes as $cb) {
            $data[$cb] = !empty($data[$cb]) ? 1 : 0;
        }

        // Normaliza preço (aceita formatos: 340,33 ou 1.234,33 ou 1234.33)
        if (isset($data['preco_diaria'])) {
            $data['preco_diaria'] = $this->normalizeDecimal($data['preco_diaria']);
        }

        // Validação servidor-side (reaproveita método privado)
        $errors = $this->validateQuarto($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('quartos.edit')->setParamns(['id' => $id])->redirect();
        }

        try {
            $model = Quarto::find($id);
            if (!$model) {
                session_set('errors', ['not_found' => 'Quarto não encontrado.']);
                return Router::getRouteByName('quartos.index')->redirect();
            }
            $model->save($data);
            session_forget('errors');
            session_forget('old');
            return Router::getRouteByName('quartos.index')->redirect();
        } catch (\Throwable $e) {
            // erro ao persistir no banco
            session_set('errors', ['db' => 'Erro ao atualizar o quarto.']);
            session_set('old', $data);
            return Router::getRouteByName('quartos.edit')->setParamns(['id' => $id])->redirect();
        }
    }

    public function destroy($id)
    {
        try {
            $model = Quarto::find($id);
            if ($model) {
                $model->delete();
            } else {
                session_set('errors', ['not_found' => 'Quarto não encontrado.']);
            }
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao remover o quarto.']);
        }
        return Router::getRouteByName('quartos.index')->redirect();
    }

    public function store()
    {
        // mapear para as colunas do banco conforme storage/sql/blank.sql
        $data = Request::only(
            'numero',
            'descricao',
            'preco_diaria',
            'qtd_camas_casal',
            'qtd_camas_solteiro',
            'max_camas_casal',
            'max_camas_solteiro',
            'tem_ventilador',
            'tem_ar_condicionado',
            'tem_agua_quente',
            'tem_banheira',
            'tem_wifi',
            'tem_frigobar',
            'tem_tv',
            'e_friendly_pet',
            'e_acessivel'
        );

        // normaliza checkboxes
        $checkboxes = ['tem_ventilador','tem_ar_condicionado','tem_agua_quente','tem_banheira','tem_wifi','tem_frigobar','tem_tv','e_friendly_pet','e_acessivel'];
        foreach ($checkboxes as $cb) {
            $data[$cb] = !empty($data[$cb]) ? 1 : 0;
        }

        // Normaliza preço (aceita formatos: 340,33 ou 1.234,33 ou 1234.33)
        if (isset($data['preco_diaria'])) {
            $data['preco_diaria'] = $this->normalizeDecimal($data['preco_diaria']);
        }

        // preencher timestamps para fallback em sessão
        $now = date('Y-m-d H:i:s');
        if (empty($data['criado_em'])) {
            $data['criado_em'] = $now;
        }
        $data['atualizado_em'] = $now;

        // Validação servidor-side (reaproveita método privado)
        $errors = $this->validateQuarto($data);
        if (!empty($errors)){
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('quartos.create')->redirect();
        }

        // Persistir no banco
        try {
            $created = Quarto::create($data);
            if ($created) {
                session_forget('errors');
                session_forget('old');
                return Router::getRouteByName('quartos.index')->redirect();
            }
            // se create não retornou, considerar erro
            session_set('errors', ['db' => 'Erro ao criar o quarto.']);
            session_set('old', $data);
            return Router::getRouteByName('quartos.create')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao criar o quarto: ' . $e->getMessage()]);
            session_set('old', $data);
            return Router::getRouteByName('quartos.create')->redirect();
        }
    }

    // Validação comum reaproveitável para create/update
    private function validateQuarto(array $data): array
    {
        $labels = [
            'descricao' => 'Descrição',
            'preco_diaria' => 'Preço diária',
            'qtd_camas_casal' => 'Camas de casal',
            'qtd_camas_solteiro' => 'Camas de solteiro',
            'max_camas_casal' => 'Máx. camas casal',
            'max_camas_solteiro' => 'Máx. camas solteiro',
        ];

        $errors = [];

        // numero — exige inteiro (não aceita decimais)
        $v = new \Fmk\Facades\Validate($labels['numero'] ?? 'Número', $data['numero'] ?? null);
        $v->required();
        $v->integer(0, 999999);
        if (!$v->check()) $errors['numero'] = $v->getErrors();

        // descrição
        $v = new \Fmk\Facades\Validate($labels['descricao'], $data['descricao'] ?? null);
        $v->required();
        if (!$v->check()) $errors['descricao'] = $v->getErrors();

        // preço
        $v = new \Fmk\Facades\Validate($labels['preco_diaria'], $data['preco_diaria'] ?? null);
        $v->decimal2();
        if (!$v->check()) $errors['preco_diaria'] = $v->getErrors();

        // inteiros não-negativos (por campo)
        foreach (['qtd_camas_casal','qtd_camas_solteiro','max_camas_casal','max_camas_solteiro'] as $intField){
            $v = new \Fmk\Facades\Validate($labels[$intField], $data[$intField] ?? null);
            $v->integer(0, 255);
            if (!$v->check()) $errors[$intField] = $v->getErrors();
        }

        return $errors;
    }

    // Converte uma string numérica brasileira ou internacional para formato com ponto decimal
    private function normalizeDecimal($value)
    {
        $s = trim((string)$value);
        if ($s === '') return $s;
        // Se contém vírgula e ponto, assume ponto como separador de milhares
        if (strpos($s, ',') !== false && strpos($s, '.') !== false) {
            $s = str_replace('.', '', $s);
            $s = str_replace(',', '.', $s);
            return $s;
        }
        // Caso contenha apenas vírgula, substitui por ponto
        if (strpos($s, ',') !== false) {
            $s = str_replace(',', '.', $s);
            return $s;
        }
        // caso já esteja com ponto ou sem separadores
        return $s;
    }
}
