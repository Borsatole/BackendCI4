<?php

namespace App\Exceptions;

use Exception;

class NivelException extends Exception
{
    public static function naoEncontrado(): self
    {
        return new self('Nível não encontrado', 404);
    }

    public static function nomeObrigatorio(): self
    {
        return new self('O campo nome é obrigatório', 400);
    }

    public static function nomeDuplicado(): self
    {
        return new self('Já existe um nível com este nome', 400);
    }

    public static function erroCriar(array $errors = []): self
    {
        $message = 'Erro ao criar nível';
        if (!empty($errors)) {
            $message .= ': ' . implode(', ', $errors);
        }
        return new self($message, 400);
    }

    public static function erroAtualizar(array $errors = []): self
    {
        $message = 'Erro ao atualizar nível';
        if (!empty($errors)) {
            $message .= ': ' . implode(', ', $errors);
        }
        return new self($message, 400);
    }

    public static function erroDeletar(): self
    {
        return new self('Erro ao deletar nível', 400);
    }
}