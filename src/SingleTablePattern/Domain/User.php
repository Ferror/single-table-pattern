<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Domain;

final class User
{
    public const PREFIX = 'USR';

    public function __construct(
        private UserIdentifier $identifier,
        private string $name
    )
    {
    }
}
