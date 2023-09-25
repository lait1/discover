<?php
declare(strict_types=1);

namespace App\Application;

use App\Domain\ExchangeService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class ParserExchangeCommand extends Command
{
    private ExchangeService $exchangeService;

    public function __construct(ExchangeService $exchangeService)
    {
        parent::__construct('parse:exchange');
        $this->exchangeService = $exchangeService;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Start parsing');

        $this->exchangeService->parseExchange();

        $output->writeln('end parsing');

        return Command::SUCCESS;
    }
}
