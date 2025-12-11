<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Router;
use App\Models\Employees\Funcionario;
use App\Models\Employees\Cargo;

use function session_get;
use function session_set;
use function session_forget;

class FuncionariosController extends Controller
{
    public function create()
    {
        try {
            $cargos = Cargo::all();
        } catch (\Throwable $e) {
            $cargos = [];
        }
        return view('funcionarios.create', ['cargos' => $cargos]);
    }

    public function index()
    {
        try {
            $funcionarios = Funcionario::all();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            $funcionarios = [];
        }
        return view('funcionarios.index', ['title' => 'Funcionários', 'funcionarios' => $funcionarios]);
    }

    public function edit($id)
    {
        try {
            $funcionario = Funcionario::find($id);
            $cargos = Cargo::all();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            return Router::getRouteByName('funcionarios.index')->redirect();
        }
        if (!$funcionario) {
            session_set('errors', ['not_found' => 'Funcionário não encontrado.']);
            return Router::getRouteByName('funcionarios.index')->redirect();
        }
        return view('funcionarios.edit', ['title' => 'Editar Funcionário', 'funcionario' => $funcionario, 'cargos' => $cargos]);
    }

    public function update($id)
    {
        $data = $this->extractData();
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('funcionarios.edit')->setParamns(['id' => $id])->redirect();
        }

        try {
            $model = Funcionario::find($id);
            if (!$model) {
                session_set('errors', ['not_found' => 'Funcionário não encontrado.']);
                return Router::getRouteByName('funcionarios.index')->redirect();
            }
            $model->save($data);
            session_forget('errors');
            session_forget('old');
            return Router::getRouteByName('funcionarios.index')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao atualizar o funcionário.']);
            session_set('old', $data);
            return Router::getRouteByName('funcionarios.edit')->setParamns(['id' => $id])->redirect();
        }
    }

    public function destroy($id)
    {
        try {
            $model = Funcionario::find($id);
            if ($model) {
                $model->delete();
            } else {
                session_set('errors', ['not_found' => 'Funcionário não encontrado.']);
            }
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao remover o funcionário.']);
        }
        return Router::getRouteByName('funcionarios.index')->redirect();
    }

    public function store()
    {
        $data = $this->extractData();
        $data['senha'] = password_hash($data['senha'] ?? '', PASSWORD_BCRYPT);
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('funcionarios.create')->redirect();
        }

        try {
            if (Funcionario::create($data)) {
                session_forget('errors');
                session_forget('old');
                return Router::getRouteByName('funcionarios.index')->redirect();
            }
            session_set('errors', ['db' => 'Erro ao criar o funcionário.']);
            session_set('old', $data);
            return Router::getRouteByName('funcionarios.create')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao criar o funcionário.']);
            session_set('old', $data);
            return Router::getRouteByName('funcionarios.create')->redirect();
        }
    }

    private function extractData()
    {
        return Request::only(
            'login', 'senha', 'nome', 'email', 'ativo',
            'nivel_acesso', 'cpf', 'rg', 'rg_expedidor',
            'telefone', 'cargos_id'
        );
    }

    private function validate($data)
    {
        $labels = [
            'login' => 'Login',
            'senha' => 'Senha',
            'nome' => 'Nome',
            'email' => 'Email',
            'cargos_id' => 'Cargo',
            'cpf' => 'CPF',
        ];

        $errors = [];

        $v = new \Fmk\Facades\Validate($labels['login'], $data['login'] ?? null);
        $v->required();
        if (!$v->check()) $errors['login'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['senha'], $data['senha'] ?? null);
        $v->required();
        if (!$v->check()) $errors['senha'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['nome'], $data['nome'] ?? null);
        $v->required();
        if (!$v->check()) $errors['nome'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['email'], $data['email'] ?? null);
        $v->required();
        if (!$v->check()) $errors['email'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['cargos_id'], $data['cargos_id'] ?? null);
        $v->required();
        if (!$v->check()) $errors['cargos_id'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['cpf'], $data['cpf'] ?? null);
        $v->required();
        if (!$v->check()) $errors['cpf'] = $v->getErrors();

        return $errors;
    }
}
