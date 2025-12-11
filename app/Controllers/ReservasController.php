<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Router;
use App\Models\Reserva;
use App\Models\Hospede;

use function session_get;
use function session_set;
use function session_forget;

class ReservasController extends Controller
{
    public function create()
    {
        try {
            $hospedes = Hospede::all();
        } catch (\Throwable $e) {
            $hospedes = [];
        }
        return view('reservas.create', ['hospedes' => $hospedes]);
    }

    public function index()
    {
        try {
            $reservas = Reserva::all();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            $reservas = [];
        }
        return view('reservas.index', ['title' => 'Reservas', 'reservas' => $reservas]);
    }

    public function edit($id)
    {
        try {
            $reserva = Reserva::find($id);
            $hospedes = Hospede::all();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao acessar o banco de dados.']);
            return Router::getRouteByName('reservas.index')->redirect();
        }
        if (!$reserva) {
            session_set('errors', ['not_found' => 'Reserva não encontrada.']);
            return Router::getRouteByName('reservas.index')->redirect();
        }
        return view('reservas.edit', ['title' => 'Editar Reserva', 'reserva' => $reserva, 'hospedes' => $hospedes]);
    }

    public function update($id)
    {
        $data = $this->extractData();
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('reservas.edit')->setParamns(['id' => $id])->redirect();
        }

        try {
            $model = Reserva::find($id);
            if (!$model) {
                session_set('errors', ['not_found' => 'Reserva não encontrada.']);
                return Router::getRouteByName('reservas.index')->redirect();
            }
            $model->save($data);
            session_forget('errors');
            session_forget('old');
            return Router::getRouteByName('reservas.index')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao atualizar a reserva.']);
            session_set('old', $data);
            return Router::getRouteByName('reservas.edit')->setParamns(['id' => $id])->redirect();
        }
    }

    public function destroy($id)
    {
        try {
            $model = Reserva::find($id);
            if ($model) {
                $model->delete();
            } else {
                session_set('errors', ['not_found' => 'Reserva não encontrada.']);
            }
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao remover a reserva.']);
        }
        return Router::getRouteByName('reservas.index')->redirect();
    }

    public function store()
    {
        $data = $this->extractData();
        $data['token_acesso'] = bin2hex(random_bytes(32));
        $errors = $this->validate($data);
        if (!empty($errors)) {
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('reservas.create')->redirect();
        }

        try {
            if (Reserva::create($data)) {
                session_forget('errors');
                session_forget('old');
                return Router::getRouteByName('reservas.index')->redirect();
            }
            session_set('errors', ['db' => 'Erro ao criar a reserva.']);
            session_set('old', $data);
            return Router::getRouteByName('reservas.create')->redirect();
        } catch (\Throwable $e) {
            session_set('errors', ['db' => 'Erro ao criar a reserva.']);
            session_set('old', $data);
            return Router::getRouteByName('reservas.create')->redirect();
        }
    }

    public function guest($token)
    {
        try {
            $reserva = Reserva::where('token_acesso', $token)->first();
        } catch (\Throwable $e) {
            return view('error', ['message' => 'Reserva não encontrada.']);
        }
        if (!$reserva) {
            return view('error', ['message' => 'Reserva não encontrada.']);
        }
        return view('reservas.guest', ['reserva' => $reserva]);
    }

    private function extractData()
    {
        return Request::only(
            'hospedes_id', 'data_checkin', 'data_checkout',
            'status', 'valor_total', 'origem_reserva'
        );
    }

    private function validate($data)
    {
        $labels = [
            'hospedes_id' => 'Hóspede',
            'data_checkin' => 'Data de Check-in',
            'data_checkout' => 'Data de Check-out',
            'status' => 'Status',
            'valor_total' => 'Valor Total',
            'origem_reserva' => 'Origem da Reserva',
        ];

        $errors = [];

        $v = new \Fmk\Facades\Validate($labels['hospedes_id'], $data['hospedes_id'] ?? null);
        $v->required();
        if (!$v->check()) $errors['hospedes_id'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['data_checkin'], $data['data_checkin'] ?? null);
        $v->required();
        if (!$v->check()) $errors['data_checkin'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['data_checkout'], $data['data_checkout'] ?? null);
        $v->required();
        if (!$v->check()) $errors['data_checkout'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['status'], $data['status'] ?? null);
        $v->required();
        if (!$v->check()) $errors['status'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['valor_total'], $data['valor_total'] ?? null);
        $v->decimal2();
        if (!$v->check()) $errors['valor_total'] = $v->getErrors();

        $v = new \Fmk\Facades\Validate($labels['origem_reserva'], $data['origem_reserva'] ?? null);
        $v->required();
        if (!$v->check()) $errors['origem_reserva'] = $v->getErrors();

        return $errors;
    }
}
