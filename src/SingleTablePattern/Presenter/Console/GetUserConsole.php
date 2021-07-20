<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Presenter\Console;

use Ferror\SingleTablePattern\Domain\User;
use Ferror\SingleTablePattern\Domain\UserIdentifier;
use Ferror\SingleTablePattern\Domain\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Uuid;

final class GetUserConsole extends Command
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('user:get');
        $this->setDescription('Gets user');
        $this->addArgument('identifier', InputArgument::REQUIRED);
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = $this->userRepository->find(new UserIdentifier($input->getArgument('identifier')));

        $output->writeln($user->jsonSerialize());

        return Command::SUCCESS;
    }
}
