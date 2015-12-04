<?php
namespace MentesNotaveis\Autenticacao\Entities;

use stdClass;
use Exception;
use Respect\Validation\Validator;

class Usuario implements EntityInterface
{

    protected $id;

    protected $login;

    protected $senha;

    protected $criado_em;

    protected $atualizado_em;

    protected $ativo;

    public function __construct()
    {
        $this->criado_em = date('Y-d-m H:i:s');
        $this->ativo = true;
    }

    public function obtemId()
    {
        return $this->id;
    }

    public function obtemLogin()
    {
        return $this->login;
    }

    public function defineLogin($login)
    {
        $loginValidador = Validator::stringType()->notEmpty()
            ->noWhitespace()
            ->length(8, 14)
            ->validate($login);
        
        if (! $loginValidador) {
            throw new Exception();
        }
        
        $this->login = $login;
    }

    public function obtemSenha()
    {
        return $this->senha;
    }

    public function defineSenha($senha)
    {        
        $senhaValidador = Validator::alnum()->notEmpty()
            ->noWhitespace()
            ->length(4, 8)
            ->validate($senha);
        
        if (! $senhaValidador) {
            throw new Exception();
        }
        
        $this->senha = md5($senha);
    }
    
    public function defineAtualizadoEm($atualizadoEm)
    {
        $atualizadoEmValidador = Validator::date('Y-m-d H:i:s')->validate($atualizadoEm);
        
        if(! $atualizadoEmValidador){
            throw new Exception();
        }
        
        $this->atualizado_em = $atualizadoEm;
    }
    
    public function obtemCopia()
    {
        $usuario = new stdClass();
        $usuario->id = $this->obtemId();
        $usuario->login = $this->obtemLogin();
        
        return $usuario;
    }
}