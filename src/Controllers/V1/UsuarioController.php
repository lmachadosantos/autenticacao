<?php
namespace MentesNotaveis\Autenticacao\Controllers\V1;

use stdClass;
use Respect\Rest\Routable;
use Respect\Relational\Mapper;
use MentesNotaveis\Autenticacao\Entities\Usuario;
use MentesNotaveis\Autenticacao\Repositories\UsuarioRepository;

class UsuarioController implements Routable
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
        
        $usuarioRepository = new UsuarioRepository($this->mapper);
        
        if ($id !== null) {
            $usuario = $usuarioRepository->obtem($id);
            
            if ($usuario) {
                $resposta->success = true;
                $resposta->usuario = $usuario->obtemCopia();
            }
        } else {
            $usuarios = $usuarioRepository->obtemLista();
            $resposta->success = true;
            
            foreach ($usuarios as $usuario) {
                $resposta->usuario[] = $usuario->obtemCopia();
            }
        }
        
        return $resposta;
    }

    public function post()
    {
        parse_str(file_get_contents('php://input'), $_REQUEST);
        
        $login = (! empty($_REQUEST['login'])) ? $_REQUEST['login'] : null;
        $senha = (! empty($_REQUEST['senha'])) ? $_REQUEST['senha'] : null;
        
        $resposta = new stdClass();
        $resposta->success = false;
        
        $usuarioRepository = new UsuarioRepository($this->mapper);
        
        $loginExiste = $usuarioRepository->loginExiste($login);
        
        if ($loginExiste === false) {
            $usuario = new Usuario();
            
            $usuario->defineLogin($login);
            $usuario->defineSenha($senha);
            
            $this->mapper->usuario->persist($usuario);
            $this->mapper->flush();
            
            $resposta->success = true;
            $resposta->usuario = $usuario->obtemCopia();
        }
        
        return $resposta;
    }

    public function put($id)
    {
        parse_str(file_get_contents('php://input'), $_REQUEST);
                
        $id = (int) $id;
        $senha = (! empty($_REQUEST['senha'])) ? $_REQUEST['senha'] : null;
        
        $resposta = new stdClass();
        $resposta->success = false;
        
        $usuarioRepository = new UsuarioRepository($this->mapper);
        
        $usuario = $usuarioRepository->obtem($id);
        
        if ($usuario) {
            $usuario->defineSenha($senha);
            $usuario->defineAtualizadoEm(date('Y-m-d H:i:s'));
            
            var_dump($usuario); die();
            
            $this->mapper->usuario->persist($usuario);
            $this->mapper->flush();
            
            $resposta->success = true;
            $resposta->usuario = $usuario->obtemCopia();
        }
        return $resposta;
    }
}
