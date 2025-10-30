<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Affiliations;

use VincentAuger\DataCiteSdk\Exceptions\DataCiteValidationException;

final readonly class Affiliation
{
    public function __construct(
        public string $name,
        public ?string $schemeUri,
        public ?string $affiliationIdentifier,
        public ?string $affiliationIdentifierScheme,
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
            affiliationIdentifier: isset($data['affiliationIdentifier']) && is_string($data['affiliationIdentifier']) ? $data['affiliationIdentifier'] : null,
            affiliationIdentifierScheme: isset($data['affiliationIdentifierScheme']) && is_string($data['affiliationIdentifierScheme']) ? $data['affiliationIdentifierScheme'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     *
     * @throws DataCiteValidationException If affiliationIdentifier is provided without affiliationIdentifierScheme
     */
    public function toArray(): array
    {
        // Validate conditional dependencies per DataCite Metadata Schema 4.6
        if ($this->affiliationIdentifier !== null && $this->affiliationIdentifierScheme === null) {
            throw new DataCiteValidationException(
                'If affiliationIdentifier is used, affiliationIdentifierScheme is mandatory.'
            );
        }

        if ($this->affiliationIdentifierScheme !== null && $this->affiliationIdentifier === null) {
            throw new DataCiteValidationException(
                'affiliationIdentifierScheme cannot be used without affiliationIdentifier.'
            );
        }

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
