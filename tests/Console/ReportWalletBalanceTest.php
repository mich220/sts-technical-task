<?php

declare(strict_types=1);

namespace App\Tests\Console;

use App\Tests\Cases\WalletTransactionTestCase;
use App\Wallet\Domain\Entity\BankAccount;
use App\Wallet\Domain\Entity\Wallet;
use App\Wallet\Infrastructure\Repository\BankAccountRepository;
use PHPUnit\Framework\Attributes\Test;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ReportWalletBalanceTest extends WalletTransactionTestCase
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
    public function itCanReportWalletBalanceToCsv(): void
    {
        /** @var BankAccount $bankAccount */
        list($bankAccount, $wallet) = $this->createWallet(950);
        //        $bankAccount->addFundsToWallet($wallet->getId(), 150);
        $this->getService(BankAccountRepository::class)->save($bankAccount);

        $application = new Application(self::$kernel);
        $command = $application->find('app:report:wallet-history');
        $commandTester = new CommandTester($command);
        $commandTester->execute(['accountId' => $bankAccount->getId(), 'walletId' => $wallet->getId()]);

        $this->assertDirectoryExists('/application/var/generated');
        $this->assertDirectoryIsReadable('/application/var/generated');
        $this->assertFileExists(sprintf('/application/var/generated/wallet_%s_history.csv', $wallet->getId()));
    }
}
