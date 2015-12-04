<?php
define('BASE_URL', '/');
define('APPLICATION_PATH', dirname(realpath(__FILE__)) . '/../');
define('APPLICATION_ENVIRONMENT', 'desenvolvimento');

switch (APPLICATION_ENVIRONMENT) {
    case 'desenvolvimento':
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
        break;
    case 'teste':
    case 'producao':
        error_reporting(0);
        break;
    default:
        exit('O ambiente do aplicativo não está definida corretamente .');
}

require_once (APPLICATION_PATH . '/vendor/autoload.php');

$container = \MentesNotaveis\Autenticacao\Container::obtemInstancia();

$mapper = $container->mapper;
$mapper->entityNamespace = '\\MentesNotaveis\\Autenticacao\\Entities\\';

$router = $container->router;

$router->any(BASE_URL . "public/index.php/usuario/*", "\\MentesNotaveis\\Autenticacao\\Controllers\\V1\\UsuarioController", array(
    $container->mapper
))->accept(array(
    'text/html' => function ($obj) {
        var_dump($obj);
    },
    'application/json' => function ($obj) {
        echo json_encode($obj);
    }
));

$router->any(BASE_URL . "public/index.php/perfil/*", "\\MentesNotaveis\\Autenticacao\\Controllers\\V1\\PerfilController", array(
    $container->mapper
))->accept(array(
    'text/html' => function ($obj) {
        var_dump($obj);
    },
    'application/json' => function ($obj) {
        echo json_encode($obj);
    }
));

$router->any(BASE_URL . "public/index.php/papel/*", "\\MentesNotaveis\\Autenticacao\\Controllers\\V1\\PapelController", array(
    $container->mapper
))->accept(array(
    'text/html' => function ($obj) {
        var_dump($obj);
    },
    'application/json' => function ($obj) {
        echo json_encode($obj);
    }
));

$router->any(BASE_URL . "public/index.php/recurso/*", "\\MentesNotaveis\\Autenticacao\\Controllers\\V1\\RecursoController", array(
    $container->mapper
))->accept(array(
    'text/html' => function ($obj) {
        var_dump($obj);
    },
    'application/json' => function ($obj) {
        echo json_encode($obj);
    }
));

echo $router->run();