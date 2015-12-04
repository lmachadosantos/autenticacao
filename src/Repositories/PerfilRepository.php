<?php
namespace MentesNotaveis\Autenticacao\Repositories;

use Respect\Relational\Mapper;

class PerfilRepository implements RepositoryInterface
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function obtem($id)
    {
        $perfil = $this->mapper->perfil(array(
            'id' => "{$id}"
        ))->fetch();
        
        return $perfil;
    }

    public function obtemLista()
    {
        $perfis = $this->mapper->perfil->fetchAll();
        
        return $perfis;
    }
}