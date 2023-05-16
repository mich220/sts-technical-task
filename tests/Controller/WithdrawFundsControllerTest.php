<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Shared\Response\StsJsonResponse;
use App\Tests\Cases\WalletTransactionTestCase;
use App\Wallet\Domain\Entity\BankAccount;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Domain\Entity\WalletTransaction;
use App\Wallet\Domain\Enum\WalletTransactionType;
use PHPUnit\Framework\Attributes\Test;

class WithdrawFundsControllerTest extends WalletTransactionTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->truncateEntities([
            BankAccount::class,
            Wallet::class,
            WalletTransaction::class,
        ]);
    }

    #[Test]
    public function itCanWithdrawFunds(): void
    {
        list($bankAccount, $wallet) = $this->createWallet(1250);

        $this->makeRequest(
            'PUT',
            "/account/{$bankAccount->getId()}/wallet/{$wallet->getId()}/withdraw",
            [
                'accountId' => $bankAccount->getId(),
                'walletId' => $wallet->getId(),
                'amount' => 1000,
            ]
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(StsJsonResponse::HTTP_OK);
        $this->assertWalletTransactionSuccessful(
            $bankAccount->getId(),
            250,
            1000,
            WalletTransactionType::WITHDRAW
        );
    }

    public function validDataProvider(): void
    {
    }

    public function invalidDataProvider(): void
    {
    }
}
