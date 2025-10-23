<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Affiliations;

final readonly class Affiliation
{
    public function __construct(
        public string $name,
        public ?string $schemeUri,
        public ?string $affiliationIdentifier,
        public ?string $affiliationIdentifierScheme,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            schemeUri: $data['schemeUri'] ?? null,
            affiliationIdentifier: $data['affiliationIdentifier'] ?? null,
            affiliationIdentifierScheme: $data['affiliationIdentifierScheme'] ?? null,
        );
    }

    public function toArray(): array
    {
        $array = ['name' => $this->name];

        if ($this->schemeUri !== null) {
            $array['schemeUri'] = $this->schemeUri;
        }

        if ($this->affiliationIdentifier !== null) {
            $array['affiliationIdentifier'] = $this->affiliationIdentifier;
        }

        if ($this->affiliationIdentifierScheme !== null) {
            $array['affiliationIdentifierScheme'] = $this->affiliationIdentifierScheme;
        }

        return $array;
    }
}
