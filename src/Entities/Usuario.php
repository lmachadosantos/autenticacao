<?php
namespace Autenticacao\Entities;

use Respect\Validation\Validator;
use Respect\Validation\Exceptions\ValidationException;

class Usuario implements EntityInterface
{

    protected $id;

    protected $login;

    protected $senha;

    public function __construct()
    {}

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
        if (! Validator::stringType()->notEmpty()
            ->noWhitespace()
            ->length(8, 14)
            ->validate($login)) {
            throw new \Exception();
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
            ->length(4, 8);
        
        try {
            $senhaValidador->check($senha);
            $this->senha = $senha;
        } catch (ValidationException $exception) {
            print_r($exception->getMainMessage());
        }
    }
}