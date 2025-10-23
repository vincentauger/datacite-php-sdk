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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        $geoLocationPointData = null;
        if (isset($data['geoLocationPoint']) && is_array($data['geoLocationPoint'])) {
            /** @var array<string, mixed> $pointArray */
            $pointArray = $data['geoLocationPoint'];
            $geoLocationPointData = GeoLocationPoint::fromArray($pointArray);
        }

        $geoLocationBoxData = null;
        if (isset($data['geoLocationBox']) && is_array($data['geoLocationBox'])) {
            /** @var array<string, mixed> $boxArray */
            $boxArray = $data['geoLocationBox'];
            $geoLocationBoxData = GeoLocationBox::fromArray($boxArray);
        }

        return new self(
            geoLocationPlace: isset($data['geoLocationPlace']) && is_string($data['geoLocationPlace']) ? $data['geoLocationPlace'] : null,
            geoLocationPoint: $geoLocationPointData,
            geoLocationBox: $geoLocationBoxData,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [];

        if ($this->geoLocationPlace !== null) {
            $array['geoLocationPlace'] = $this->geoLocationPlace;
        }

        if ($this->geoLocationPoint instanceof \VincentAuger\DataCiteSdk\Data\GeoLocation\GeoLocationPoint) {
            $array['geoLocationPoint'] = $this->geoLocationPoint->toArray();
        }

        if ($this->geoLocationBox instanceof \VincentAuger\DataCiteSdk\Data\GeoLocation\GeoLocationBox) {
            $array['geoLocationBox'] = $this->geoLocationBox->toArray();
        }

        return $array;
    }
}
