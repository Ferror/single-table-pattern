<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Domain;

interface UserRepository
{
    public function find(UserIdentifier $identifier): User;
    public function save(User $user): void;
    public function delete(UserIdentifier $identifier): void;
}
