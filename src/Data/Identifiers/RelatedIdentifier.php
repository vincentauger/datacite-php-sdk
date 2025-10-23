<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

final readonly class RelatedIdentifier
{
    public function __construct(
        public ?string $schemeUri,
        public ?string $schemeType,
        public string $relationType,
        public string $relatedIdentifier,
        public ?string $resourceTypeGeneral,
        public string $relatedIdentifierType,
        public ?string $relatedMetadataScheme,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            schemeUri: $data['schemeUri'] ?? null,
            schemeType: $data['schemeType'] ?? null,
            relationType: $data['relationType'],
            relatedIdentifier: $data['relatedIdentifier'],
            resourceTypeGeneral: $data['resourceTypeGeneral'] ?? null,
            relatedIdentifierType: $data['relatedIdentifierType'],
            relatedMetadataScheme: $data['relatedMetadataScheme'] ?? null,
        );
    }

    public function toArray(): array
    {
        $array = [
            'relationType' => $this->relationType,
            'relatedIdentifier' => $this->relatedIdentifier,
            'relatedIdentifierType' => $this->relatedIdentifierType,
        ];

        if ($this->schemeUri !== null) {
            $array['schemeUri'] = $this->schemeUri;
        }

        if ($this->schemeType !== null) {
            $array['schemeType'] = $this->schemeType;
        }

        if ($this->resourceTypeGeneral !== null) {
            $array['resourceTypeGeneral'] = $this->resourceTypeGeneral;
        }

        if ($this->relatedMetadataScheme !== null) {
            $array['relatedMetadataScheme'] = $this->relatedMetadataScheme;
        }

        return $array;
    }
}
