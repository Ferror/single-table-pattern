<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Presenter\Console;

use Ferror\SingleTablePattern\Domain\UserIdentifier;
use Ferror\SingleTablePattern\Domain\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class DeleteUserConsole extends Command
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('users:delete');
        $this->setDescription('DELETE /users/{uuid}');
        $this->addArgument('identifier', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->userRepository->delete(new UserIdentifier($input->getArgument('identifier')));

        $output->writeln('Success');

        return Command::SUCCESS;
    }
}
