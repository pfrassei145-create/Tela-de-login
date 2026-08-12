<?php

namespace App\Models;

class Usuario
{
    private string $rm;
    private string $senha;
    private string $nome;
    private string $perfil;

    public function __construct(string $rm, string $senha, string $nome, string $perfil = 'Aluno')
    {
        $this->rm = $rm;
        $this->senha = $senha;
        $this->nome = $nome;
        $this->perfil = $perfil;
    }

    public function getRm(): string
    {
        return $this->rm;
    }

    public function getSenha(): string
    {
        return $this->senha;
    }

    public function getNome(): string
    {
        return $this->nome;
    }

    public function getPerfil(): string
    {
        return $this->perfil;
    }

    public function resumo(): string
    {
        return sprintf('%s - RM %s - Perfil: %s', $this->nome, $this->rm, $this->perfil);
    }

    public function dadosDaInstancia(): array
    {
        return [
            'classe' => self::class,
            'nome' => $this->nome,
            'rm' => $this->rm,
            'perfil' => $this->perfil,
            'hash' => spl_object_hash($this),
        ];
    }
}
