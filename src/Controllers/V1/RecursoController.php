<?php
namespace MentesNotaveis\Autenticacao\Controllers\V1;

use stdClass;
use Respect\Rest\Routable;
use Respect\Relational\Mapper;
use MentesNotaveis\Autenticacao\Entities\Recurso;
use MentesNotaveis\Autenticacao\Repositories\RecursoRepository;
use MentesNotaveis\Autenticacao\Repositories\PapelRepository;

class RecursoController implements Routable
{

    private $mapper;

    public function __construct(Mapper $mapper)
    {
        $this->mapper = $mapper;
    }

    public function get($id = null)
    {
        $resposta = new stdClass();
        $resposta->success = false;
        
        $recursoRepository = new RecursoRepository($this->mapper);
        
        if ($id !== null) {
            $recurso = $recursoRepository->obtem($id);
            
            if ($recurso) {
                $resposta->success = true;
                $resposta->recurso = $recurso->obtemCopia();
            }
        } else {
            $recursos = $recursoRepository->obtemLista();
            $resposta->success = true;
            
            foreach ($recursos as $recurso) {
                $resposta->recurso[] = $recurso->obtemCopia();
            }
        }
        
        return $resposta;
    }

    public function post()
    {
        parse_str(file_get_contents('php://input'), $_REQUEST);
        
        $recursoInput = (! empty($_REQUEST['recurso'])) ? $_REQUEST['recurso'] : null;
        $recursoUrl = (! empty($_REQUEST['recursoUrl'])) ? $_REQUEST['recursoUrl'] : null;
        $papelId = (! empty($_REQUEST['papel'])) ? $_REQUEST['papel'] : null;
        
        $resposta = new stdClass();
        $resposta->success = false;
        
        $papelRepository = new PapelRepository($this->mapper);
        $papel = $papelRepository->obtem($papelId);
        
        if ($papel) {
            $recurso = new Recurso();
            
            $recurso->definePapelId($papel->obtemId());
            $recurso->defineRecurso($recursoInput);
            $recurso->defineRecursoUrl($recursoUrl);
            
            $this->mapper->recurso->persist($recurso);
            $this->mapper->flush();
            
            $resposta->success = true;
            $resposta->recurso = $recurso->obtemCopia();
        }
        
        return $resposta;
    }

    public function put($id)
    {
        parse_str(file_get_contents('php://input'), $_REQUEST);
        
        $id = (int) $id;
        $recursoInput = (! empty($_REQUEST['recurso'])) ? $_REQUEST['recurso'] : null;
        $recursoUrl = (! empty($_REQUEST['recursoUrl'])) ? $_REQUEST['recursoUrl'] : null;
        
        $resposta = new stdClass();
        $resposta->success = false;
        
        $recursoRepository = new RecursoRepository($this->mapper);
        
        $recurso = $recursoRepository->obtem($id);
        
        if ($recurso) {
            $recurso->defineRecurso($recursoInput);
            $recurso->defineRecursoUrl($recursoUrl);
            $recurso->defineAtualizadoEm(date('Y-m-d H:i:s'));
            
            $this->mapper->recurso->persist($recurso);
            $this->mapper->flush();
            
            $resposta->success = true;
            $resposta->recurso = $recurso->obtemCopia();
        }
        return $resposta;
    }
}