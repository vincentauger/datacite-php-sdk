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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_numeric($data['westBoundLongitude']));
        assert(is_numeric($data['eastBoundLongitude']));
        assert(is_numeric($data['southBoundLatitude']));
        assert(is_numeric($data['northBoundLatitude']));

        return new self(
            westBoundLongitude: (float) $data['westBoundLongitude'],
            eastBoundLongitude: (float) $data['eastBoundLongitude'],
            southBoundLatitude: (float) $data['southBoundLatitude'],
            northBoundLatitude: (float) $data['northBoundLatitude'],
        );
    }

    /**
     * @return array<string, mixed>
     */
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
