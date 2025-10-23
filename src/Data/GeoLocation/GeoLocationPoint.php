<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\GeoLocation;

final readonly class GeoLocationPoint
{
    public function __construct(
        public float $pointLatitude,
        public float $pointLongitude,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_numeric($data['pointLatitude']));
        assert(is_numeric($data['pointLongitude']));

        return new self(
            pointLatitude: (float) $data['pointLatitude'],
            pointLongitude: (float) $data['pointLongitude'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'pointLatitude' => $this->pointLatitude,
            'pointLongitude' => $this->pointLongitude,
        ];
    }
}
