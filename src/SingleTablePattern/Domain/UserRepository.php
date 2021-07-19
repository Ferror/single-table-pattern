<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Domain;

interface UserRepository
{
    public function find(UserIdentifier $identifier): User;
}
