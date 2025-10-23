<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\GeoLocation;

final readonly class GeoLocation
{
    /**
     * @param  GeoLocationPolygon[]  $geoLocationPolygon
     */
    public function __construct(
        public ?string $geoLocationPlace = null,
        public ?GeoLocationPoint $geoLocationPoint = null,
        public ?GeoLocationBox $geoLocationBox = null,
        public array $geoLocationPolygon = [],
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

        $geoLocationPolygonData = [];
        if (isset($data['geoLocationPolygon']) && is_array($data['geoLocationPolygon'])) {
            /** @var array<array<string, mixed>> $polygonArray */
            $polygonArray = $data['geoLocationPolygon'];
            $geoLocationPolygonData = array_map(
                fn (array $item): GeoLocationPolygon => GeoLocationPolygon::fromArray($item),
                $polygonArray
            );
        }

        return new self(
            geoLocationPlace: isset($data['geoLocationPlace']) && is_string($data['geoLocationPlace']) ? $data['geoLocationPlace'] : null,
            geoLocationPoint: $geoLocationPointData,
            geoLocationBox: $geoLocationBoxData,
            geoLocationPolygon: $geoLocationPolygonData,
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

        if (count($this->geoLocationPolygon) > 0) {
            $array['geoLocationPolygon'] = array_map(
                fn (GeoLocationPolygon $polygon): array => $polygon->toArray(),
                $this->geoLocationPolygon
            );
        }

        return $array;
    }
}
