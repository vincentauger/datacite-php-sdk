<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Enums\ResourceTypeGeneral;

/**
 * Represents DataCite Property 10: ResourceType
 *
 * A description of the resource. The recommended content is a single term
 * paired with resourceTypeGeneral (e.g., "Census Data" + "Dataset" = "Dataset/Census Data").
 *
 * @see https://datacite-metadata-schema.readthedocs.io/en/4.6/properties/resourcetype/
 */
final readonly class ResourceType
{
    /**
     * @param  ResourceTypeGeneral  $resourceTypeGeneral  The general type of the resource (mandatory).
     * @param  string|null  $resourceType  A specific description of the resource type. While the DataCite documentation states this is required, it is often null in API responses, so it's optional here.
     */
    public function __construct(
        public ResourceTypeGeneral $resourceTypeGeneral,
        public ?string $resourceType = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['resourceTypeGeneral']));

        return new self(
            resourceTypeGeneral: ResourceTypeGeneral::from($data['resourceTypeGeneral']),
            resourceType: isset($data['resourceType']) && is_string($data['resourceType']) ? $data['resourceType'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'resourceTypeGeneral' => $this->resourceTypeGeneral->value,
        ];

        if ($this->resourceType !== null) {
            $array['resourceType'] = $this->resourceType;
        }

        return $array;
    }
}
