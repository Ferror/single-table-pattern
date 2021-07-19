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

        return new User(
            $identifier,
            $result['name']
        );
    }
}
