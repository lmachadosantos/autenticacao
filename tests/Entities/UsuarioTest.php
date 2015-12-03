<?php

namespace Autenticacao\Entities;

class UsuarioTest extends \PHPUnit_Framework_TestCase
{
    
    protected $usuario;
    
    public function __construct() {
        parent::__construct();
        $this->usuario = new Usuario();        
    }
    
    /**
     * @expectedException \Exception
     */
    public function testaSeDefineLoginComMenosDeOitoCaracteres() {
         $loginComMenosDeOitoCaracteres = 'jovemod';
         $this->usuario->defineLogin($loginComMenosDeOitoCaracteres);
    }
    
    /**
     * @expectedException \Exception
     */
    public function testaSeDefineLoginComMaisDeQuatorzeCaracteres() {
        $loginComMaisDeQuatorzeCaracteres = 'jovemodjjjjjjjj';
        $this->usuario->defineLogin($loginComMaisDeQuatorzeCaracteres);
    }
    
    /**
     * @expectedException \Exception
     */
    public function testaSeDefineLoginVazioOuNulo() {
        $this->usuario->defineLogin('');
        $this->usuario->defineLogin(null);
    }
    
    /**
     * @expectedException \Exception
     */
    public function testaSeDefineLoginComEspacoEmBranco() {
        $this->usuario->defineLogin('Leandro Machado');
    }
    
    public function testaSeDefineLoginValido() {
        $this->assertNull($this->usuario->defineLogin('asdfghji'));
        $this->assertNull($this->usuario->defineLogin('asdfghjkkkkkk9'));
    }
    
    
}

?>