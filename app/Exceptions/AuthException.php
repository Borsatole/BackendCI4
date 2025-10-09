<?php

namespace App\Exceptions;

use Exception;

class AuthException extends Exception
{
    // Usuário
    public static function naoExiste(): self
    {
        return new self('Usuário não encontrado', 404);
    }

    public static function senhaIncorreta(): self
    {
        return new self('Senha incorreta', 400);
    }

    public static function naoAutorizado(): self
    {
        return new self('Nível não autorizado', 403);
    }

    public static function naoAtivo(): self
    {
        return new self('Usuário não está ativo', 403);
    }

    public static function naoPossuiNivelDeAcesso(): self
    {
        return new self('Usuário não tem nível de acesso cadastrado', 403);
    }

    // Token
    public static function tokenNaoGerado(): self
    {
        return new self('Token não gerado', 500);
    }

    public static function tokenNaoFornecido(): self
    {
        return new self('Token não fornecido', 401);
    }

    public static function tokenInvalido(): self
    {
        return new self('Token inválido ou expirado', 401);
    }

    public static function tokenExpirado(): self
    {
        return new self('Token expirado', 401);
    }
}
