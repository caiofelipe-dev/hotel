<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Router;
use App\Models\Employees\Cargo;

use function session_get;
use function session_set;
use function session_forget;

class CargosController extends Controller
{
    public function create()
    {
        return view('cargos.create');
    }

    public function index()
    {
        try {
            $cargos = Cargo::all();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            $cargos = [];
        }
        return view('cargos.index', ['title' => 'Cargos', 'cargos' => $cargos]);
    }

    public function edit($id)
    {
        try {
            $cargo = Cargo::find($id);
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            return Router::getRouteByName('cargos.index')->redirect();
        }
        if (!$cargo) {
            session_set('errors', ['not_found' => 'Cargo não encontrado.']);
            return Router::getRouteByName('cargos.index')->redirect();
        }
        return view('cargos.edit', ['title' => 'Editar Cargo', 'cargo' => $cargo]);
    }

    public function update($id)
    {
        $data = $this->extractData();
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('cargos.edit')->setParamns(['id' => $id])->redirect();
        }

        try {
            $model = Cargo::find($id);
            if (!$model) {
                session_set('errors', ['not_found' => 'Cargo não encontrado.']);
                return Router::getRouteByName('cargos.index')->redirect();
            }
            $model->save($data);
            session_forget('errors');
            session_forget('old');
            return Router::getRouteByName('cargos.index')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao atualizar o cargo.']);
            session_set('old', $data);
            return Router::getRouteByName('cargos.edit')->setParamns(['id' => $id])->redirect();
        }
    }

    public function destroy($id)
    {
        try {
            $model = Cargo::find($id);
            if ($model) {
                $model->delete();
            } else {
                session_set('errors', ['not_found' => 'Cargo não encontrado.']);
            }
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao remover o cargo.']);
        }
        return Router::getRouteByName('cargos.index')->redirect();
    }

    public function store()
    {
        $data = $this->extractData();
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('cargos.create')->redirect();
        }

        try {
            if (Cargo::create($data)) {
                session_forget('errors');
                session_forget('old');
                return Router::getRouteByName('cargos.index')->redirect();
            }
            session_set('errors', ['db' => 'Erro ao criar o cargo.']);
            session_set('old', $data);
            return Router::getRouteByName('cargos.create')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao criar o cargo.']);
            session_set('old', $data);
            return Router::getRouteByName('cargos.create')->redirect();
        }
    }

    private function extractData()
    {
        return Request::only('nome', 'descricao', 'nivel_acesso');
    }

    private function validate($data)
    {
        $labels = ['nome' => 'Nome', 'nivel_acesso' => 'Nível de Acesso'];

        $errors = [];

        $v = new \Fmk\Facades\Validate($labels['nome'], $data['nome'] ?? null);
        $v->required();
        if (!$v->check()) $errors['nome'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['nivel_acesso'], $data['nivel_acesso'] ?? null);
        $v->required();
        if (!$v->check()) $errors['nivel_acesso'] = $v->getErrors();

        return $errors;
    }
}
