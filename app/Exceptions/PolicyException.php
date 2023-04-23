<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;

class PolicyException extends AuthorizationException
{
    public function __construct($message = "Usuário não autorizado a realizar a ação!")
    {
        parent::__construct($message,403);
    }
}