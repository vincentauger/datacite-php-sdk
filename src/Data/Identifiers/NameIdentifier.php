<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

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
     */
    public function toArray(): array
    {
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
