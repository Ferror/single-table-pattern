<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Domain;

final class User implements \JsonSerializable
{
    public const PREFIX = 'USR';

    public function __construct(
        private UserIdentifier $identifier,
        private string $name
    )
    {
    }

    public function getIdentifier(): UserIdentifier
    {
        return $this->identifier;
    }

    public function jsonSerialize(): array
    {
        return [
            'id' => $this->identifier->toString(),
            'name' => $this->name,
        ];
    }
}
