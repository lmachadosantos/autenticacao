<?php
namespace Autenticacao\Controllers\V1;

use Respect\Rest\Routable;
use Respect\Relational\Mapper;
use Autenticacao\Entities\Usuario;

class UsuarioController implements Routable
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function get($id)
    {

    }

    public function post()
    {
        
        $usuario = new Usuario();
        $usuario->defineLogin($_POST['login']);
        
        return $usuario;
    }
}
