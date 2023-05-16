<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Exception;

class BankAccountNotFoundException extends \Exception
{
    public function __construct(string $message = 'Bank account not found.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
