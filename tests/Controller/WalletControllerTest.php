<?php

declare(strict_types=1);

namespace App\Tests\Controller;

use App\Shared\Response\StsJsonResponse;
use App\Tests\Cases\WalletTransactionTestCase;
use App\Wallet\Domain\Entity\BankAccount;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Infrastructure\Repository\BankAccountRepository;
use PHPUnit\Framework\Attributes\Test;

class WalletControllerTest extends WalletTransactionTestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->truncateEntities([
            BankAccount::class,
            Wallet::class,
        ]);
    }

    #[Test]
    public function itCanCreateWallet(): void
    {
        $bankAccount = new BankAccount();
        /** @var BankAccountRepository $bankAccountRepository */
        $bankAccountRepository = $this->getService(BankAccountRepository::class);
        $bankAccountRepository->save($bankAccount);

        $this->assertCount(0, $bankAccount->getWallets());
        $this->makeRequest(
            'POST',
            "/account/{$bankAccount->getId()}/wallet"
        );

        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(StsJsonResponse::HTTP_CREATED);
        $bankAccountRepository->find($bankAccount->getId());
        $this->assertCount(1, $bankAccount->getWallets());
    }

    #[Test]
    public function itCanShowWalletBalance(): void
    {
        $balance = 550;
        list($bankAccount, $wallet) = $this->createWallet($balance);

        $response = $this->makeRequest(
            'GET',
            "/account/{$bankAccount->getId()}/wallet/{$wallet->getId()}"
        );
        $this->assertResponseIsSuccessful();
        $this->assertResponseStatusCodeSame(StsJsonResponse::HTTP_OK);
        $responseData = $this->getResponseResults($response);
        $this->assertArrayHasKey('data', $responseData);
        $this->assertIsArray($responseData['data']);
        $this->assertArrayHasKey('balance', $responseData['data']);
        $this->assertSame($balance, $responseData['data']['balance']);
    }
}
