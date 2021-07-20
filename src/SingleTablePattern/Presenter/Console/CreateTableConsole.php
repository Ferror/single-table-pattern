<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Presenter\Console;

use Ferror\SingleTablePattern\Infrastructure\Aws\Dynamodb\DynamoDatabase;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class CreateTableConsole extends Command
{
    public function __construct(
        private DynamoDatabase $database
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('dynamodb:table:create');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->database->createTable();

        return Command::SUCCESS;
    }
}
