<?php
namespace MentesNotaveis\Autenticacao\Repositories;

use Respect\Relational\Mapper;

class RecursoRepository implements RepositoryInterface
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function obtem($id)
    {
        $recurso = $this->mapper->recurso(array(
            'id' => "{$id}"
        ))->fetch();
        
        return $recurso;
    }

    public function obtemLista()
    {
        $recursos = $this->mapper->recurso->fetchAll();
        return $recursos;
    }
}