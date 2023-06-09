<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Exception;

class WalletNotFoundException extends \Exception
{
    public function __construct(string $message = 'Wallet not found.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
