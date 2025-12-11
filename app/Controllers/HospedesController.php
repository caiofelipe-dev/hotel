<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Router;
use App\Models\Bookings\Hospede;

use function session_get;
use function session_set;
use function session_forget;

class HospedesController extends Controller
{
    public function create()
    {
        return view('hospedes.create');
    }

    public function index()
    {
        try {
            $hospedes = Hospede::all();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            $hospedes = [];
        }
        return view('hospedes.index', ['title' => 'Hóspedes', 'hospedes' => $hospedes]);
    }

    public function edit($id)
    {
        try {
            $hospede = Hospede::find($id);
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            return Router::getRouteByName('hospedes.index')->redirect();
        }
        if (!$hospede) {
            session_set('errors', ['not_found' => 'Hóspede não encontrado.']);
            return Router::getRouteByName('hospedes.index')->redirect();
        }
        return view('hospedes.edit', ['title' => 'Editar Hóspede', 'hospede' => $hospede]);
    }

    public function update($id)
    {
        $data = $this->extractData();
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('hospedes.edit')->setParamns(['id' => $id])->redirect();
        }

        try {
            $model = Hospede::find($id);
            if (!$model) {
                session_set('errors', ['not_found' => 'Hóspede não encontrado.']);
                return Router::getRouteByName('hospedes.index')->redirect();
            }
            $model->save($data);
            session_forget('errors');
            session_forget('old');
            return Router::getRouteByName('hospedes.index')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao atualizar o hóspede.']);
            session_set('old', $data);
            return Router::getRouteByName('hospedes.edit')->setParamns(['id' => $id])->redirect();
        }
    }

    public function destroy($id)
    {
        try {
            $model = Hospede::find($id);
            if ($model) {
                $model->delete();
            } else {
                session_set('errors', ['not_found' => 'Hóspede não encontrado.']);
            }
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao remover o hóspede.']);
        }
        return Router::getRouteByName('hospedes.index')->redirect();
    }

    public function store()
    {
        $data = $this->extractData();
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('hospedes.create')->redirect();
        }

        try {
            if (Hospede::create($data)) {
                session_forget('errors');
                session_forget('old');
                return Router::getRouteByName('hospedes.index')->redirect();
            }
            session_set('errors', ['db' => 'Erro ao criar o hóspede.']);
            session_set('old', $data);
            return Router::getRouteByName('hospedes.create')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao criar o hóspede.']);
            session_set('old', $data);
            return Router::getRouteByName('hospedes.create')->redirect();
        }
    }

    private function extractData()
    {
        return Request::only(
            'nome', 'email', 'telefone', 'endereco',
            'nacionalidade', 'data_nascimento', 'cpf'
        );
    }

    private function validate($data)
    {
        $labels = [
            'nome' => 'Nome',
            'email' => 'Email',
            'telefone' => 'Telefone',
            'endereco' => 'Endereço',
            'nacionalidade' => 'Nacionalidade',
            'data_nascimento' => 'Data de Nascimento',
            'cpf' => 'CPF',
        ];

        $errors = [];

        $v = new \Fmk\Facades\Validate($labels['nome'], $data['nome'] ?? null);
        $v->required();
        if (!$v->check()) $errors['nome'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['email'], $data['email'] ?? null);
        $v->required();
        if (!$v->check()) $errors['email'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['telefone'], $data['telefone'] ?? null);
        $v->required();
        if (!$v->check()) $errors['telefone'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['endereco'], $data['endereco'] ?? null);
        $v->required();
        if (!$v->check()) $errors['endereco'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['nacionalidade'], $data['nacionalidade'] ?? null);
        $v->required();
        if (!$v->check()) $errors['nacionalidade'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['data_nascimento'], $data['data_nascimento'] ?? null);
        $v->required();
        if (!$v->check()) $errors['data_nascimento'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['cpf'], $data['cpf'] ?? null);
        $v->required();
        if (!$v->check()) $errors['cpf'] = $v->getErrors();

        return $errors;
    }
}
