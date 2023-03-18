<?php

declare(strict_types = 1);

namespace App\Exceptions;

class ComponentNotFoundException extends \Exception
{
    protected $message = 'Component not found';
}