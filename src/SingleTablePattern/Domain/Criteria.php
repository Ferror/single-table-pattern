<?php
declare(strict_types=1);

namespace Ferror\SingleTablePattern\Domain;

class Criteria
{
    public static function create(): self
    {
        return new self();
    }
}
