<?php

declare(strict_types=1);

namespace App\Middleware;

class Validator
{
  public function string($data) : string|bool
  {
    if(!is_string($data)) return false;
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    $data = filter_var($data, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    if(is_string($data)) return $data;
    else return false;
  }

  public function email($data) : string|bool
  {
    if(!is_string($data)) return '';
    $data = strip_tags($data);
    $data = htmlspecialchars($data);
    $data = filter_var($data, FILTER_VALIDATE_EMAIL);
    if(is_string($data)) return $data;
    else return false;
  }

  public function int($data) : int|bool
  {
    if(!is_int($data)) return false;
    $data = filter_var($data, FILTER_VALIDATE_INT);
    if(is_int($data)) return $data;
    else return false;
  }

  public function bool($data) : bool
  {
    if(!is_bool($data)) return false;
    $data = filter_var($data, FILTER_VALIDATE_BOOLEAN);
    if(is_bool($data)) return $data;
    else return false;
  }
}