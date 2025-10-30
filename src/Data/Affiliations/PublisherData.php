<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Affiliations;

use VincentAuger\DataCiteSdk\Exceptions\DataCiteValidationException;

final readonly class PublisherData
{
    public function __construct(
        public string $name,
        public ?string $lang,
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
            lang: isset($data['lang']) && is_string($data['lang']) ? $data['lang'] : null,
            schemeUri: isset($data['schemeUri']) && is_string($data['schemeUri']) ? $data['schemeUri'] : null,
            publisherIdentifier: isset($data['publisherIdentifier']) && is_string($data['publisherIdentifier']) ? $data['publisherIdentifier'] : null,
            publisherIdentifierScheme: isset($data['publisherIdentifierScheme']) && is_string($data['publisherIdentifierScheme']) ? $data['publisherIdentifierScheme'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     *
     * @throws DataCiteValidationException If publisherIdentifier is provided without publisherIdentifierScheme
     */
    public function toArray(): array
    {
        // Validate conditional dependencies per DataCite Metadata Schema 4.6
        if ($this->publisherIdentifier !== null && $this->publisherIdentifierScheme === null) {
            throw new DataCiteValidationException(
                'If publisherIdentifier is used, publisherIdentifierScheme is mandatory.'
            );
        }

        if ($this->publisherIdentifierScheme !== null && $this->publisherIdentifier === null) {
            throw new DataCiteValidationException(
                'publisherIdentifierScheme cannot be used without publisherIdentifier.'
            );
        }

        $array = ['name' => $this->name];

        if ($this->lang !== null) {
            $array['lang'] = $this->lang;
        }

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
