<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Infrastructure\Aws\Dynamodb;

use Ferror\SingleTablePattern\Domain\User;
use Ferror\SingleTablePattern\Domain\UserIdentifier;
use Ferror\SingleTablePattern\Domain\UserRepository as UserRepositoryInterface;

final class UserRepository implements UserRepositoryInterface
{
    public function __construct(
        private DynamoDatabase $database
    ) {
    }

    public function find(UserIdentifier $identifier): User
    {
        $result = $this->database->getItem('PK1', \sprintf('%s#%s', User::PREFIX, $identifier->toString()));

        return new User($identifier, $result['name']);
    }

    public function create(User $user): void
    {
        $this->database->createItem(
            \array_merge(
                ['PK1' => \sprintf('%s#%s', User::PREFIX, $user->getIdentifier()->toString())],
                $user->jsonSerialize(),
            )
        );
    }

    public function delete(UserIdentifier $identifier): void
    {
        $this->database->deleteItem('PK1', \sprintf('%s#%s', User::PREFIX, $identifier->toString()));
    }

    public function getAll(): array
    {
        return $this->database->getAll();
    }
}
