<?php
namespace MentesNotaveis\Autenticacao\Controllers\V1;

use stdClass;
use Respect\Rest\Routable;
use Respect\Relational\Mapper;
use MentesNotaveis\Autenticacao\Entities\Perfil;
use MentesNotaveis\Autenticacao\Repositories\PerfilRepository;
use MentesNotaveis\Autenticacao\Repositories\UsuarioRepository;

class PerfilController implements Routable
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
        
        $perfilRepository = new PerfilRepository($this->mapper);
        
        if ($id !== null) {
            $perfil = $perfilRepository->obtem($id);
            
            if ($perfil) {
                $resposta->success = true;
                $resposta->perfil = $perfil->obtemCopia();
            }
        } else {
            $perfis = $perfilRepository->obtemLista();
            $resposta->success = true;
            
            foreach ($perfis as $perfil) {
                $resposta->perfil[] = $perfil->obtemCopia();
            }
        }
        
        return $resposta;
    }

    public function post()
    {
        parse_str(file_get_contents('php://input'), $_REQUEST);
        
        $titulo = (! empty($_REQUEST['titulo'])) ? $_REQUEST['titulo'] : null;
        $descricao = (! empty($_REQUEST['descricao'])) ? $_REQUEST['descricao'] : null;
        $usuarioId = (! empty($_REQUEST['usuario'])) ? $_REQUEST['usuario'] : null;
        
        $resposta = new stdClass();
        $resposta->success = false;
        
        $usuarioRepository = new UsuarioRepository($this->mapper);
        $usuario = $usuarioRepository->obtem($usuarioId);
        
        if ($usuario) {
            $perfil = new Perfil();
            
            $perfil->defineUsuarioId($usuario->obtemId());
            $perfil->defineTitulo($titulo);
            $perfil->defineDescricao($descricao);
            
            $this->mapper->perfil->persist($perfil);
            $this->mapper->flush();
            
            $resposta->success = true;
            $resposta->perfil = $perfil->obtemCopia();
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
        
        $perfilRepository = new PerfilRepository($this->mapper);
        
        $perfil = $perfilRepository->obtem($id);
        
        if ($perfil) {
            $perfil->defineTitulo($titulo);
            $perfil->defineDescricao($descricao);
            $perfil->defineAtualizadoEm(date('Y-m-d H:i:s'));
            
            $this->mapper->perfil->persist($perfil);
            $this->mapper->flush();
            
            $resposta->success = true;
            $resposta->perfil = $perfil->obtemCopia();
        }
        return $resposta;
    }
}