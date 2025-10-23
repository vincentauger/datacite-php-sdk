<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\GeoLocation;

final readonly class GeoLocationBox
{
    public function __construct(
        public float $westBoundLongitude,
        public float $eastBoundLongitude,
        public float $southBoundLatitude,
        public float $northBoundLatitude,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            westBoundLongitude: $data['westBoundLongitude'],
            eastBoundLongitude: $data['eastBoundLongitude'],
            southBoundLatitude: $data['southBoundLatitude'],
            northBoundLatitude: $data['northBoundLatitude'],
        );
    }

    public function toArray(): array
    {
        return [
            'westBoundLongitude' => $this->westBoundLongitude,
            'eastBoundLongitude' => $this->eastBoundLongitude,
            'southBoundLatitude' => $this->southBoundLatitude,
            'northBoundLatitude' => $this->northBoundLatitude,
        ];
    }
}
