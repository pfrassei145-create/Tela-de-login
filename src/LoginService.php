<?php

namespace App\Services;

use App\Models\Usuario;

class LoginService
{
    /**
     * @var Usuario[]
     */
    private array $usuarios;

    public function __construct()
    {
        $this->usuarios = [
            new Usuario('23728', '1234', 'Ana Silva', 'Aluno'),
            new Usuario('10001', 'abcd', 'Carlos Souza', 'Professor'),
        ];
    }

    public function autenticar(string $rm, string $senha): ?Usuario
    {
        foreach ($this->usuarios as $usuario) {
            if ($usuario->getRm() === $rm && $usuario->getSenha() === $senha) {
                return $usuario;
            }
        }

        return null;
    }
}
