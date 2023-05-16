<?php

declare(strict_types=1);

namespace App\Wallet\Domain\Exception;

class CannotWithdrawFundsFromWalletException extends \Exception
{
    public function __construct(string $message = 'Insufficient funds.', int $code = 0, ?\Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
