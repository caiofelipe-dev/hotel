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
        return view('quartos.create', ['title' => 'Cadastrar Quarto']);
    }

    public function index()
    {
        try {
            $quartos = Quarto::all();
        } catch (\Throwable $e) {
            $quartos = session_get('quartos', []);
        }
        return view('quartos.index', ['title' => 'Quartos', 'quartos' => $quartos]);
    }

    public function edit($id)
    {
        try {
            $quarto = Quarto::find($id);
        } catch (\Throwable $e) {
            $list = session_get('quartos', []);
            $quarto = null;
            foreach ($list as $item) {
                if (isset($item['id']) && $item['id'] == $id) {
                    $quarto = (object) $item;
                    break;
                }
            }
        }
        if (!$quarto) {
            return view('quartos.index', ['title' => 'Quartos', 'quartos' => session_get('quartos', [])]);
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

        // Validação servidor-side (erros por campo)
        $labels = [
            'descricao' => 'Descrição',
            'preco_diaria' => 'Preço diária',
            'qtd_camas_casal' => 'Camas de casal',
            'qtd_camas_solteiro' => 'Camas de solteiro',
            'max_camas_casal' => 'Máx. camas casal',
            'max_camas_solteiro' => 'Máx. camas solteiro',
        ];

        $errors = [];

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

        if (!empty($errors)) {
            // envia erros e valores antigos para a sessão e volta para o formulário
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('quartos.edit')->setParamns(['id' => $id])->redirect();
        }

        try {
            $model = Quarto::find($id);
            if ($model) {
                $model->save($data);
                session_forget('errors');
                session_forget('old');
                return Router::getRouteByName('quartos.index')->redirect();
            }
        } catch (\Throwable $e) {
            // fallback: atualizar lista na sessão
            $list = session_get('quartos', []);
            foreach ($list as &$item) {
                if (isset($item['id']) && $item['id'] == $id) {
                    $item = array_merge($item, $data);
                    break;
                }
            }
            session_set('quartos', $list);
            session_forget('errors');
            session_forget('old');
            return Router::getRouteByName('quartos.index')->redirect();
        }

        return Router::getRouteByName('quartos.index')->redirect();
    }

    public function destroy($id)
    {
        try {
            $model = Quarto::find($id);
            if ($model) {
                $model->delete();
                return Router::getRouteByName('quartos.index')->redirect();
            }
        } catch (\Throwable $e) {
            $list = session_get('quartos', []);
            $new = [];
            foreach ($list as $item) {
                if (!(isset($item['id']) && $item['id'] == $id)) {
                    $new[] = $item;
                }
            }
            session_set('quartos', $new);
            return Router::getRouteByName('quartos.index')->redirect();
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

        // preencher timestamps para fallback em sessão
        $now = date('Y-m-d H:i:s');
        if (empty($data['criado_em'])) {
            $data['criado_em'] = $now;
        }
        $data['atualizado_em'] = $now;

        // Validação servidor-side (erros por campo com labels amigáveis)
        $labels = [
            'descricao' => 'Descrição',
            'preco_diaria' => 'Preço diária',
            'qtd_camas_casal' => 'Camas de casal',
            'qtd_camas_solteiro' => 'Camas de solteiro',
            'max_camas_casal' => 'Máx. camas casal',
            'max_camas_solteiro' => 'Máx. camas solteiro',
        ];

        $errors = [];

        // numero
        $v = new \Fmk\Facades\Validate($labels['numero'] ?? 'Número', $data['numero'] ?? null);
        $v->required();
        $v->maxLength(20);
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

        if (!empty($errors)){
            session_set('errors', $errors);
            session_set('old', $data);
            return Router::getRouteByName('quartos.create')->redirect();
        }

        // Persistir
        try {
            if (class_exists(Quarto::class)) {
                $created = Quarto::create($data);
                if ($created) {
                    session_forget('errors');
                    session_forget('old');
                    return Router::getRouteByName('quartos.index')->redirect();
                }
            }
        } catch (\Throwable $e) {
            // fallback: salvar em sessão
            $data['id'] = time();
            session_push('quartos', $data);
            session_forget('errors');
            session_forget('old');
            return Router::getRouteByName('quartos.index')->redirect();
        }

        // fallback padrão caso create não tenha retornado objeto
        $data['id'] = time();
        session_push('quartos', $data);
        session_forget('errors');
        session_forget('old');
        return Router::getRouteByName('quartos.index')->redirect();
    }
}
