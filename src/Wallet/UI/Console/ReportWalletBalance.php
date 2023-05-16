<?php

declare(strict_types=1);

namespace App\Wallet\UI\Console;

use App\Shared\Messenger\CommandBus;
use App\Wallet\Application\Message\GenerateTransactionHistoryCommand;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(name: 'app:report:wallet-history')]
class ReportWalletBalance extends Command
{
    public function __construct(private readonly CommandBus $commandBus)
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setDescription('Report wallet history');
        $this->addArgument('accountId', InputArgument::REQUIRED, 'Account ID');
        $this->addArgument('walletId', InputArgument::REQUIRED, 'Wallet ID');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->commandBus->dispatch(new GenerateTransactionHistoryCommand(
            (int) $input->getArgument('accountId'),
            (int) $input->getArgument('walletId')
        ));

        return self::SUCCESS;
    }
}
