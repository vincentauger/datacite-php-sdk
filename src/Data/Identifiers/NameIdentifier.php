<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class NameIdentifier
{
    public function __construct(
        public ?string $schemeUri,
        public string $nameIdentifier,
        public string $nameIdentifierScheme,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            schemeUri: $data['schemeUri'] ?? null,
            nameIdentifier: $data['nameIdentifier'],
            nameIdentifierScheme: $data['nameIdentifierScheme'],
        );
    }

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
