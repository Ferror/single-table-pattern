<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Domain;

use JetBrains\PhpStorm\Pure;

final class UserIdentifier
{
    private string $identifier;

    public function __construct(string $identifier)
    {
        $this->identifier = $identifier;
    }

    public function toString(): string
    {
        return $this->identifier;
    }

    #[Pure]
    public function __toString(): string
    {
        return $this->toString();
    }
}
