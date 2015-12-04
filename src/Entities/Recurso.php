<?php
namespace MentesNotaveis\Autenticacao\Entities;

use stdClass;
use Exception;
use Respect\Validation\Validator;

class Recurso implements EntityInterface
{

    protected $id;

    protected $papel_id;

    protected $recurso;

    protected $recurso_url;

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

    public function obtemPapelId()
    {
        return $this->papel_id;
    }

    public function definePapelId($papelId)
    {
        $this->papel_id = $papelId;
    }

    public function obtemRecurso()
    {
        return $this->recurso;
    }

    public function defineRecurso($recurso)
    {
        $recursoValidador = Validator::stringType()->notEmpty()
            ->length(1, 255)
            ->validate($recurso);
        
        if (! $recursoValidador) {
            throw new Exception();
        }
        
        $this->recurso = $recurso;
    }

    public function obtemRecursoUrl()
    {
        return $this->recurso_url;
    }

    public function defineRecursoUrl($recursoUrl)
    {
        $$recursoUrlValidador = Validator::stringType()->notEmpty()
            ->length(1, 255)
            ->validate($recursoUrl);
        
        if (! $recursoUrlValidador) {
            throw new Exception();
        }
        
        $this->recurso_url = $recursoUrl;
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
        $recurso = new stdClass();
        $recurso->id = $this->obtemId();
        $recurso->papel_id = $this->obtemPapelId();
        $recurso->recurso = $this->obtemRecurso();
        $recurso->recurso_url = $this->obtemRecursoUrl();
        
        return $recurso;
    }
}