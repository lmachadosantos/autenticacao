<?php
namespace MentesNotaveis\Autenticacao\Repositories;

use Respect\Relational\Mapper;

class UsuarioRepository implements RepositoryInterface
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function obtem($id)
    {
        $usuario = $this->mapper->usuario(array(
            'id' => "{$id}"
        ))->fetch();
        
        return $usuario;
    }

    public function obtemLista()
    {
        $usuarios = $this->mapper->usuario->fetchAll();
        
        return $usuarios;
    }

    public function loginExiste($login)
    {
        $usuario = $this->mapper->usuario(array(
            'login' => $login
        ))->fetch();
        
        if ($usuario)
            return true;
        else
            return false;
    }
}