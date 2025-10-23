<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class AlternateIdentifier
{
    public function __construct(
        public string $alternateIdentifierType,
        public string $alternateIdentifier,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['alternateIdentifierType']));
        assert(is_string($data['alternateIdentifier']));

        return new self(
            alternateIdentifierType: $data['alternateIdentifierType'],
            alternateIdentifier: $data['alternateIdentifier'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'alternateIdentifierType' => $this->alternateIdentifierType,
            'alternateIdentifier' => $this->alternateIdentifier,
        ];
    }
}
