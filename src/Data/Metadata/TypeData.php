<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Enums\ResourceTypeGeneral;

final readonly class TypeData
{
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
