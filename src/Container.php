<?php
namespace Autenticacao;

class Container
{

    private static $instancia = null;

    private function __construct()
    {}

    public static function obtemInstancia()
    {
        if (self::$instancia == null) {
            $config = dirname(realpath(__FILE__)) . '/../config/config.ini';
            self::$instancia = new \Respect\Config\Container($config);
        }
        
        return self::$instancia;
    }
}