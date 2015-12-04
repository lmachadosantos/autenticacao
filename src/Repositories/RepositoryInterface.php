<?php 
namespace MentesNotaveis\Autenticacao\Repositories;

interface RepositoryInterface
{
    public function obtem($id);
    
    public function obtemLista();
}