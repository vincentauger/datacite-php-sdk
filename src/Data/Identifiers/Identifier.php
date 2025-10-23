<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class Identifier
{
    public function __construct(
        public string $identifier,
        public string $identifierType,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            identifier: $data['identifier'],
            identifierType: $data['identifierType'],
        );
    }

    public function toArray(): array
    {
        return [
            'identifier' => $this->identifier,
            'identifierType' => $this->identifierType,
        ];
    }
}
