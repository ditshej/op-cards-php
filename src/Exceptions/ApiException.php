<?php

namespace Ditshej\OpCards\Exceptions;

class ApiException extends \RuntimeException
{
    public function getStatusCode(): int
    {
        return $this->getCode();
    }
}
