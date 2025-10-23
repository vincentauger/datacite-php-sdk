<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\GeoLocation;

final readonly class GeoLocation
{
    public function __construct(
        public ?string $geoLocationPlace = null,
        public ?GeoLocationPoint $geoLocationPoint = null,
        public ?GeoLocationBox $geoLocationBox = null,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            geoLocationPlace: $data['geoLocationPlace'] ?? null,
            geoLocationPoint: isset($data['geoLocationPoint'])
                ? GeoLocationPoint::fromArray($data['geoLocationPoint'])
                : null,
            geoLocationBox: isset($data['geoLocationBox'])
                ? GeoLocationBox::fromArray($data['geoLocationBox'])
                : null,
        );
    }

    public function toArray(): array
    {
        $array = [];

        if ($this->geoLocationPlace !== null) {
            $array['geoLocationPlace'] = $this->geoLocationPlace;
        }

        if ($this->geoLocationPoint !== null) {
            $array['geoLocationPoint'] = $this->geoLocationPoint->toArray();
        }

        if ($this->geoLocationBox !== null) {
            $array['geoLocationBox'] = $this->geoLocationBox->toArray();
        }

        return $array;
    }
}
