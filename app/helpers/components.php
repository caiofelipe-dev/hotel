<?php

use Fmk\Facades\Config;

/**
 * Instancia um componente e configura seus dados
 * 
 * Suporta três formas de resolução:
 * 1. Nome de classe completo (ex: 'App\Components\MenuComponent')
 * 2. Chave configurada em app/configs/components.php (ex: 'menu')
 * 3. Arquivo de view (fallback)
 * 
 * @param string $component Nome da classe, chave ou arquivo
 * @param array $data Dados a passar para setData()
 * @return Fmk\Facades\Component Instância do componente
 * @throws Exception Se o componente não for encontrado
 */
if (!function_exists('component')) {
    function component($component = NULL, array $content = [])
    {
        try {
            if(is_null($component)) {
                return (new Fmk\Facades\Component(''))->addContent($content);
            }
            // 1. Tentar instanciar pela classe diretamente
            if (class_exists($component)) {
                $instance = new $component();
                if (method_exists($instance, 'addContent')) {
                    $instance->addContent($content);
                }
                return $instance;
            }

            // 2. Tentar buscar pela configuração
            $componentClass = Config::get("components.$component");
            if (class_exists($componentClass)) {
                $instance = new $componentClass();
                if (method_exists($instance, 'addContent')) {
                    $instance->addContent($content);
                }
                return $instance;
            }

            // 3. Fallback: arquivo de view
            $instance = new Fmk\Facades\Component(component_path($component));
            $instance->setData($content);
            return $instance;
        } catch (\Exception $e) {
            throw new \Exception("Erro ao instanciar componente '{$component}': " . $e->getMessage());
        }
    }
}

/**
 * Resolve o caminho completo para um arquivo de componente
 * 
 * Converte notação com ponto em caminho de diretório e procura por:
 * 1. Arquivo .view.php
 * 2. Arquivo .php (fallback)
 * 
 * @param string $componentFile Nome do arquivo ou notação de ponto
 * @return string Caminho completo do arquivo
 */
if (!function_exists('component_path')) {
    function component_path($componentFile)
    {
        $componentFile = str_replace('.', DIRECTORY_SEPARATOR, $componentFile);
        $basePath = defined('VIEW_PATH') ? constant('VIEW_PATH') : (defined('APP_PATH') ? constant('APP_PATH') . '/views/' : 'views/');
        $extension = defined('VIEW_EXT') ? constant('VIEW_EXT') : '.view.php';
        
        $filePath = $basePath . $componentFile . $extension;
        if (!file_exists($filePath)) {
            $filePath = $basePath . $componentFile . '.php';
        }
        
        return $filePath;
    }
}
