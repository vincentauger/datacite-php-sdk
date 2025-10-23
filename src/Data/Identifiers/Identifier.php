<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class Identifier
{
    public function __construct(
        public string $identifier,
        public string $identifierType,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['identifier']));
        assert(is_string($data['identifierType']));

        return new self(
            identifier: $data['identifier'],
            identifierType: $data['identifierType'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'identifier' => $this->identifier,
            'identifierType' => $this->identifierType,
        ];
    }
}
