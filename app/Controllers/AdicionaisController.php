<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Router;
use App\Models\AdicionalTipo;

use function session_get;
use function session_set;
use function session_forget;

class AdicionaisController extends Controller
{
    public function create()
    {
        return view('adicionais.create');
    }

    public function index()
    {
        try {
            $adicionais = AdicionalTipo::all();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            $adicionais = [];
        }
        return view('adicionais.index', ['title' => 'Adicionais', 'adicionais' => $adicionais]);
    }

    public function edit($id)
    {
        try {
            $adicional = AdicionalTipo::find($id);
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            return Router::getRouteByName('adicionais.index')->redirect();
        }
        if (!$adicional) {
            session_set('errors', ['not_found' => 'Adicional não encontrado.']);
            return Router::getRouteByName('adicionais.index')->redirect();
        }
        return view('adicionais.edit', ['title' => 'Editar Adicional', 'adicional' => $adicional]);
    }

    public function update($id)
    {
        $data = $this->extractData();
        $data = $this->normalizeDecimal($data, 'valor_referencia');
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('adicionais.edit')->setParamns(['id' => $id])->redirect();
        }

        try {
            $model = AdicionalTipo::find($id);
            if (!$model) {
                session_set('errors', ['not_found' => 'Adicional não encontrado.']);
                return Router::getRouteByName('adicionais.index')->redirect();
            }
            $model->save($data);
            session_forget('errors');
            session_forget('old');
            return Router::getRouteByName('adicionais.index')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao atualizar o adicional.']);
            session_set('old', $data);
            return Router::getRouteByName('adicionais.edit')->setParamns(['id' => $id])->redirect();
        }
    }

    public function destroy($id)
    {
        try {
            $model = AdicionalTipo::find($id);
            if ($model) {
                $model->delete();
            } else {
                session_set('errors', ['not_found' => 'Adicional não encontrado.']);
            }
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao remover o adicional.']);
        }
        return Router::getRouteByName('adicionais.index')->redirect();
    }

    public function store()
    {
        $data = $this->extractData();
        $data = $this->normalizeDecimal($data, 'valor_referencia');
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('adicionais.create')->redirect();
        }

        try {
            if (AdicionalTipo::create($data)) {
                session_forget('errors');
                session_forget('old');
                return Router::getRouteByName('adicionais.index')->redirect();
            }
            session_set('errors', ['db' => 'Erro ao criar o adicional.']);
            session_set('old', $data);
            return Router::getRouteByName('adicionais.create')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao criar o adicional.']);
            session_set('old', $data);
            return Router::getRouteByName('adicionais.create')->redirect();
        }
    }

    private function extractData()
    {
        return Request::only('descricao', 'icone', 'valor_referencia', 'disponivel');
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
            'descricao' => 'Descrição',
            'valor_referencia' => 'Valor de Referência',
        ];

        $errors = [];

        $v = new \Fmk\Facades\Validate($labels['descricao'], $data['descricao'] ?? null);
        $v->required();
        if (!$v->check()) $errors['descricao'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['valor_referencia'], $data['valor_referencia'] ?? null);
        $v->decimal2();
        if (!$v->check()) $errors['valor_referencia'] = $v->getErrors();

        return $errors;
    }
}
