<?php

declare(strict_types = 1);

namespace App\Exceptions;

class GameNotFoundException extends \Exception
{
    protected $message = 'Game not found';
}