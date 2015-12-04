<?php
namespace MentesNotaveis\Autenticacao\Entities;

use stdClass;
use Exception;
use Respect\Validation\Validator;

class Papel implements EntityInterface
{

    protected $id;

    protected $perfil_id;

    protected $titulo;

    protected $descricao;

    protected $criado_em;

    protected $atualizado_em;

    protected $ativo;

    public function __construct()
    {
        $this->criado_em = date('Y-m-d H:i:s');
        $this->ativo = true;
    }

    public function obtemId()
    {
        return $this->id;
    }

    public function obtemPerfilId()
    {
        return $this->perfil_id;
    }

    public function definePerfilId($perfilId)
    {
        $this->perfil_id = $perfilId;
    }

    public function obtemTitulo()
    {
        return $this->titulo;
    }

    public function defineTitulo($titulo)
    {
        $tituloValidador = Validator::stringType()->notEmpty()
            ->length(1, 120)
            ->validate($titulo);
        
        if (! $tituloValidador) {
            throw new Exception();
        }
        
        $this->titulo = $titulo;
    }

    public function obtemDescricao()
    {
        return $this->descricao;
    }

    public function defineDescricao($descricao)
    {
        $descricaoValidador = Validator::stringType()->notEmpty()
            ->length(1, 255)
            ->validate($descricao);
        
        if (! $descricaoValidador) {
            throw new Exception();
        }
        
        $this->descricao = $descricao;
    }

    public function defineAtualizadoEm($atualizadoEm)
    {
        $atualizadoEmValidador = Validator::date('Y-m-d H:i:s')->validate($atualizadoEm);
        
        if (! $atualizadoEmValidador) {
            throw new Exception();
        }
        
        $this->atualizado_em = $atualizadoEm;
    }

    public function obtemCopia()
    {
        $papel = new stdClass();
        $papel->id = $this->obtemId();
        $papel->perfil_id = $this->obtemPerfilId();
        $papel->titulo = $this->obtemTitulo();
        $papel->descricao = $this->obtemDescricao();
        
        return $papel;
    }
}