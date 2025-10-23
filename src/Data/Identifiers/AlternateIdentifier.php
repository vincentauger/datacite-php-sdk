<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class AlternateIdentifier
{
    public function __construct(
        public string $alternateIdentifierType,
        public string $alternateIdentifier,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            alternateIdentifierType: $data['alternateIdentifierType'],
            alternateIdentifier: $data['alternateIdentifier'],
        );
    }

    public function toArray(): array
    {
        return [
            'alternateIdentifierType' => $this->alternateIdentifierType,
            'alternateIdentifier' => $this->alternateIdentifier,
        ];
    }
}
