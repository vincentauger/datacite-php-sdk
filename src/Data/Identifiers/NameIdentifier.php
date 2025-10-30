<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

use VincentAuger\DataCiteSdk\Exceptions\DataCiteValidationException;

final readonly class NameIdentifier
{
    public function __construct(
        public ?string $schemeUri,
        public ?string $nameIdentifier,
        public ?string $nameIdentifierScheme,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['nameIdentifier']) || $data['nameIdentifier'] === null);
        assert(is_string($data['nameIdentifierScheme']) || $data['nameIdentifierScheme'] === null);

        return new self(
            schemeUri: isset($data['schemeUri']) && is_string($data['schemeUri']) ? $data['schemeUri'] : null,
            nameIdentifier: $data['nameIdentifier'] ?? null,
            nameIdentifierScheme: $data['nameIdentifierScheme'] ?? null,
        );
    }

    /**
     * @return array<string, mixed>
     *
     * @throws DataCiteValidationException If nameIdentifier is provided without nameIdentifierScheme
     */
    public function toArray(): array
    {
        // Validate conditional dependencies per DataCite Metadata Schema 4.6
        if ($this->nameIdentifier !== null && $this->nameIdentifierScheme === null) {
            throw new DataCiteValidationException(
                'If nameIdentifier is used, nameIdentifierScheme is mandatory.'
            );
        }

        if ($this->nameIdentifierScheme !== null && $this->nameIdentifier === null) {
            throw new DataCiteValidationException(
                'nameIdentifierScheme cannot be used without nameIdentifier.'
            );
        }

        $array = [
            'nameIdentifier' => $this->nameIdentifier,
            'nameIdentifierScheme' => $this->nameIdentifierScheme,
        ];

        if ($this->schemeUri !== null) {
            $array['schemeUri'] = $this->schemeUri;
        }

        return $array;
    }
}
