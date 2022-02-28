<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Presenter\Console;

use Ferror\SingleTablePattern\Domain\Criteria;
use Ferror\SingleTablePattern\Domain\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class GetAllUserConsole extends Command
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('users:get');
        $this->setDescription('GET /users');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $users = $this->userRepository->get(Criteria::create());

        foreach ($users as $user) {
            $output->writeln($user);
        }

        return Command::SUCCESS;
    }
}
