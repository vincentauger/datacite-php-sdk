<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

/**
 * Identifier for a related item.
 *
 * The properties relatedMetadataScheme, schemeURI, and schemeType should only be used
 * when the relationType is 'HasMetadata' or 'IsMetadataFor'.
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/properties/relateditem/#relateditemidentifier
 */
final readonly class RelatedItemIdentifier
{
    public function __construct(
        public string $relatedItemIdentifier,
        public string $relatedItemIdentifierType,
        public ?string $relatedMetadataScheme = null,
        public ?string $schemeURI = null,
        public ?string $schemeType = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['relatedItemIdentifier']));
        assert(is_string($data['relatedItemIdentifierType']));

        return new self(
            relatedItemIdentifier: $data['relatedItemIdentifier'],
            relatedItemIdentifierType: $data['relatedItemIdentifierType'],
            relatedMetadataScheme: isset($data['relatedMetadataScheme']) && is_string($data['relatedMetadataScheme']) ? $data['relatedMetadataScheme'] : null,
            schemeURI: isset($data['schemeURI']) && is_string($data['schemeURI']) ? $data['schemeURI'] : null,
            schemeType: isset($data['schemeType']) && is_string($data['schemeType']) ? $data['schemeType'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'relatedItemIdentifier' => $this->relatedItemIdentifier,
            'relatedItemIdentifierType' => $this->relatedItemIdentifierType,
        ];

        if ($this->relatedMetadataScheme !== null) {
            $array['relatedMetadataScheme'] = $this->relatedMetadataScheme;
        }

        if ($this->schemeURI !== null) {
            $array['schemeURI'] = $this->schemeURI;
        }

        if ($this->schemeType !== null) {
            $array['schemeType'] = $this->schemeType;
        }

        return $array;
    }
}
