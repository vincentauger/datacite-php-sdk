<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\GeoLocation;

final readonly class GeoLocationPoint
{
    public function __construct(
        public float $pointLatitude,
        public float $pointLongitude,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            pointLatitude: $data['pointLatitude'],
            pointLongitude: $data['pointLongitude'],
        );
    }

    public function toArray(): array
    {
        return [
            'pointLatitude' => $this->pointLatitude,
            'pointLongitude' => $this->pointLongitude,
        ];
    }
}
