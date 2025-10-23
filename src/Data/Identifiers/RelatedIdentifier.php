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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['relationType']));
        assert(is_string($data['relatedIdentifier']));
        assert(is_string($data['relatedIdentifierType']));

        return new self(
            schemeUri: isset($data['schemeUri']) && is_string($data['schemeUri']) ? $data['schemeUri'] : null,
            schemeType: isset($data['schemeType']) && is_string($data['schemeType']) ? $data['schemeType'] : null,
            relationType: $data['relationType'],
            relatedIdentifier: $data['relatedIdentifier'],
            resourceTypeGeneral: isset($data['resourceTypeGeneral']) && is_string($data['resourceTypeGeneral']) ? $data['resourceTypeGeneral'] : null,
            relatedIdentifierType: $data['relatedIdentifierType'],
            relatedMetadataScheme: isset($data['relatedMetadataScheme']) && is_string($data['relatedMetadataScheme']) ? $data['relatedMetadataScheme'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
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
