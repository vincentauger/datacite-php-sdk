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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['name']));

        return new self(
            name: $data['name'],
            schemeUri: isset($data['schemeUri']) && is_string($data['schemeUri']) ? $data['schemeUri'] : null,
            publisherIdentifier: isset($data['publisherIdentifier']) && is_string($data['publisherIdentifier']) ? $data['publisherIdentifier'] : null,
            publisherIdentifierScheme: isset($data['publisherIdentifierScheme']) && is_string($data['publisherIdentifierScheme']) ? $data['publisherIdentifierScheme'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
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
