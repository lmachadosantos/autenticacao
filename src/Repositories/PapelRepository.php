<?php
namespace MentesNotaveis\Autenticacao\Repositories;

use Respect\Relational\Mapper;

class PapelRepository implements RepositoryInterface
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function obtem($id)
    {
        $papel = $this->mapper->papel(array(
            'id' => "{$id}"
        ))->fetch();
        
        return $papel;
    }

    public function obtemLista()
    {
        $papeis = $this->mapper->papel->fetchAll();
        return $papeis;
    }
}