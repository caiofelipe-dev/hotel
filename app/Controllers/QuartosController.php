<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Router;
use App\Models\Rooms\Quarto;

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
        var_dump(new Quarto);
        try {
            $quartos = Quarto::all();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => "Erro ao acessar o banco de dados, se liga: $e."]);
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
            session_set('errors', ['not_found' => 'Quarto não encontrado.']);
            return Router::getRouteByName('quartos.index')->redirect();
        }
        return view('quartos.edit', ['title' => 'Editar Quarto', 'quarto' => $quarto]);
    }

    public function update($id)
    {
        $data = $this->extractData();
        $data = $this->normalizeCheckboxes($data);
        $data = $this->normalizeDecimal($data, 'preco_diaria');

        $errors = $this->validate($data);
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
        $data = $this->extractData();
        $data = $this->normalizeCheckboxes($data);
        $data = $this->normalizeDecimal($data, 'preco_diaria');

        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('quartos.create')->redirect();
        }

        try {
            if (Quarto::create($data)) {
                session_forget('errors');
                session_forget('old');
                return Router::getRouteByName('quartos.index')->redirect();
            }
            session_set('errors', ['db' => 'Erro ao criar o quarto.']);
            session_set('old', $data);
            return Router::getRouteByName('quartos.create')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao criar o quarto.']);
            session_set('old', $data);
            return Router::getRouteByName('quartos.create')->redirect();
        }
    }

    private function extractData()
    {
        return Request::only(
            'numero', 'descricao', 'preco_diaria',
            'qtd_camas_casal', 'qtd_camas_solteiro',
            'max_camas_casal', 'max_camas_solteiro',
            'tem_ventilador', 'tem_ar_condicionado',
            'tem_agua_quente', 'tem_banheira', 'tem_wifi',
            'tem_frigobar', 'tem_tv', 'e_friendly_pet', 'e_acessivel'
        );
    }

    private function normalizeCheckboxes($data)
    {
        $checkboxes = ['tem_ventilador', 'tem_ar_condicionado', 'tem_agua_quente',
                       'tem_banheira', 'tem_wifi', 'tem_frigobar', 'tem_tv',
                       'e_friendly_pet', 'e_acessivel'];
        foreach ($checkboxes as $cb) {
            $data[$cb] = !empty($data[$cb]) ? 1 : 0;
        }
        return $data;
    }

    private function normalizeDecimal($data, $field)
    {
        if (isset($data[$field])) {
            $s = trim((string)$data[$field]);
            if (strpos($s, ',') !== false && strpos($s, '.') !== false) {
                $s = str_replace('.', '', $s);
                $s = str_replace(',', '.', $s);
            } elseif (strpos($s, ',') !== false) {
                $s = str_replace(',', '.', $s);
            }
            $data[$field] = $s;
        }
        return $data;
    }

    private function validate($data)
    {
        $labels = [
            'numero' => 'Número',
            'descricao' => 'Descrição',
            'preco_diaria' => 'Preço diária',
            'qtd_camas_casal' => 'Camas de casal',
            'qtd_camas_solteiro' => 'Camas de solteiro',
            'max_camas_casal' => 'Máx. camas casal',
            'max_camas_solteiro' => 'Máx. camas solteiro',
        ];

        $errors = [];

        $v = new \Fmk\Facades\Validate($labels['numero'], $data['numero'] ?? null);
        $v->required();
        if (!$v->check()) $errors['numero'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['descricao'], $data['descricao'] ?? null);
        $v->required();
        if (!$v->check()) $errors['descricao'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['preco_diaria'], $data['preco_diaria'] ?? null);
        $v->decimal2();
        if (!$v->check()) $errors['preco_diaria'] = $v->getErrors();

        foreach (['qtd_camas_casal', 'qtd_camas_solteiro', 'max_camas_casal', 'max_camas_solteiro'] as $f) {
            $v = new \Fmk\Facades\Validate($labels[$f], $data[$f] ?? null);
            $v->integer(0, 255);
            if (!$v->check()) $errors[$f] = $v->getErrors();
        }

        return $errors;
    }
}
