<?php

namespace App\Exceptions;

use Exception;

class UsuarioException extends Exception
{
    public static function naoEncontrado(): self
    {
        return new self('Usuário não encontrado', 404);
    }

    public static function nomeObrigatorio(): self
    {
        return new self('O campo nome é obrigatório', 400);
    }

    public static function nomeDuplicado(): self
    {
        return new self('Já existe um usuário com este nome', 400);
    }

    public static function erroCriar(array $errors = []): self
    {
        $message = 'Erro ao criar usuário';
        if (!empty($errors)) {
            $message .= ': ' . implode(', ', $errors);
        }
        return new self($message, 400);
    }

    public static function erroAtualizar(array $errors = []): self
    {
        $message = 'Erro ao atualizar usuário';
        if (!empty($errors)) {
            $message .= ': ' . implode(', ', $errors);
        }
        return new self($message, 400);
    }

    public static function erroDeletar(): self
    {
        return new self('Erro ao deletar usuário', 400);
    }
}