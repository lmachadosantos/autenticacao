<?php
namespace Autenticacao\Controllers\V1;

use Respect\Rest\Routable;
use Respect\Relational\Mapper;

class PapelController implements Routable
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }
}