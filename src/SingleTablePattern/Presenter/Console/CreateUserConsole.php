<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Presenter\Console;

use Ferror\SingleTablePattern\Domain\User;
use Ferror\SingleTablePattern\Domain\UserIdentifier;
use Ferror\SingleTablePattern\Domain\UserRepository;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Uid\Uuid;

final class CreateUserConsole extends Command
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
        parent::__construct();
    }

    protected function configure(): void
    {
        $this->setName('users:create');
        $this->setDescription('POST /users/{uuid}');
    }

    public function execute(InputInterface $input, OutputInterface $output): int
    {
        $user = new User(
            new UserIdentifier(Uuid::v1()->jsonSerialize()),
            'user-name'
        );
        $this->userRepository->save($user);

        $output->writeln($user->jsonSerialize());

        return Command::SUCCESS;
    }
}
