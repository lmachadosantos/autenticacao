<?php
namespace MentesNotaveis\Autenticacao\Controllers\V1;

use stdClass;
use Respect\Rest\Routable;
use Respect\Relational\Mapper;
use MentesNotaveis\Autenticacao\Entities\Papel;
use MentesNotaveis\Autenticacao\Repositories\PapelRepository;
use MentesNotaveis\Autenticacao\Repositories\PerfilRepository;

class PapelController implements Routable
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
        
        $papelRepository = new PapelRepository($this->mapper);
        
        if ($id !== null) {
            $papel = $papelRepository->obtem($id);
            
            if ($papel) {
                $resposta->success = true;
                $resposta->papel = $papel->obtemCopia();
            }
        } else {
            $papeis = $papelRepository->obtemLista();
            $resposta->success = true;
            
            foreach ($papeis as $papel) {
                $resposta->papel[] = $papel->obtemCopia();
            }
        }
        
        return $resposta;
    }

    public function post()
    {
        parse_str(file_get_contents('php://input'), $_REQUEST);
        
        $titulo = (! empty($_REQUEST['titulo'])) ? $_REQUEST['titulo'] : null;
        $descricao = (! empty($_REQUEST['descricao'])) ? $_REQUEST['descricao'] : null;
        $perfilId = (! empty($_REQUEST['perfil'])) ? $_REQUEST['perfil'] : null;
        
        $resposta = new stdClass();
        $resposta->success = false;
        
        $perfilRepository = new PerfilRepository($this->mapper);
        $perfil = $perfilRepository->obtem($perfilId);
        
        if ($perfil) {
            $papel = new Papel();
            
            $papel->definePerfilId($perfil->obtemId());
            $papel->defineTitulo($titulo);
            $papel->defineDescricao($descricao);
            
            $this->mapper->papel->persist($papel);
            $this->mapper->flush();
            
            $resposta->success = true;
            $resposta->papel = $papel->obtemCopia();
        }
        
        return $resposta;
    }

    public function put($id)
    {
        parse_str(file_get_contents('php://input'), $_REQUEST);
        
        $id = (int) $id;
        $titulo = (! empty($_REQUEST['titulo'])) ? $_REQUEST['titulo'] : null;
        $descricao = (! empty($_REQUEST['descricao'])) ? $_REQUEST['descricao'] : null;
        
        $resposta = new stdClass();
        $resposta->success = false;
        
        $papelRepository = new PapelRepository($this->mapper);
        
        $papel = $papelRepository->obtem($id);
        
        if ($papel) {
            $papel->defineTitulo($titulo);
            $papel->defineDescricao($descricao);
            $papel->defineAtualizadoEm(date('Y-m-d H:i:s'));
            
            $this->mapper->papel->persist($papel);
            $this->mapper->flush();
            
            $resposta->success = true;
            $resposta->papel = $papel->obtemCopia();
        }
        return $resposta;
    }
}