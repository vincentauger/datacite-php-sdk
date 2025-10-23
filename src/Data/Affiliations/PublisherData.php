<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Affiliations;

final readonly class PublisherData
{
    public function __construct(
        public string $name,
        public ?string $schemeUri,
        public ?string $publisherIdentifier,
        public ?string $publisherIdentifierScheme,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            name: $data['name'],
            schemeUri: $data['schemeUri'] ?? null,
            publisherIdentifier: $data['publisherIdentifier'] ?? null,
            publisherIdentifierScheme: $data['publisherIdentifierScheme'] ?? null,
        );
    }

    public function toArray(): array
    {
        $array = ['name' => $this->name];

        if ($this->schemeUri !== null) {
            $array['schemeUri'] = $this->schemeUri;
        }

        if ($this->publisherIdentifier !== null) {
            $array['publisherIdentifier'] = $this->publisherIdentifier;
        }

        if ($this->publisherIdentifierScheme !== null) {
            $array['publisherIdentifierScheme'] = $this->publisherIdentifierScheme;
        }

        return $array;
    }
}
