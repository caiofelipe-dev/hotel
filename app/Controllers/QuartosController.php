<?php

namespace App\Controllers;

use Fmk\Facades\Controller;
use Fmk\Facades\Request;
use Fmk\Facades\Session;
use Fmk\Facades\Router;
use App\Models\Quarto;

class QuartosController extends Controller
{
    public function create()
    {
        return view('quartos.create', ['title' => 'Cadastrar Quarto']);
    }

    public function store()
    {
        // collect expected fields from the request
        $data = Request::only(
            'descricao',
            'numero',
            'cama_casal_min',
            'cama_casal_max',
            'cama_solteiro_min',
            'cama_solteiro_max',
            'arcondicionado',
            'banheiro',
            'frigobar',
            'tm',
            'secador',
            'agua_quente',
            'hidro',
            'valor'
        );

        // normalize checkbox values (present => 1, otherwise 0)
        $checkboxes = ['arcondicionado','banheiro','frigobar','tm','secador','agua_quente','hidro'];
        foreach ($checkboxes as $cb) {
            $data[$cb] = !empty($data[$cb]) ? 1 : 0;
        }

        // Try to persist via model if DB is configured; otherwise save to session list
        try {
            if (class_exists(Quarto::class)) {
                // This will attempt DB insert; if DB not configured this may throw
                $created = Quarto::create($data);
                if ($created) {
                    // redirect to home
                    return Router::getRouteByName('home')->redirect();
                }
            }
        } catch (\Throwable $e) {
            // fallback: store in session
            $list = Session::getInstance()->quartos ?? [];
            $list[] = $data;
            Session::getInstance()->quartos = $list;
            // return a simple confirmation view
            return view('quartos.created', ['data' => $data, 'title' => 'Quarto Criado']);
        }

        // if we get here, fallback to session storage
        $list = Session::getInstance()->quartos ?? [];
        $list[] = $data;
        Session::getInstance()->quartos = $list;
        return view('quartos.created', ['data' => $data, 'title' => 'Quarto Criado']);
    }
}
