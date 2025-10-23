<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\GeoLocation;

final readonly class GeoLocationPolygon
{
    /**
     * @param  GeoLocationPoint[]  $polygonPoint
     */
    public function __construct(
        public array $polygonPoint,
        public ?GeoLocationPoint $inPolygonPoint = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_array($data['polygonPoint']));

        /** @var array<string, mixed> $polygonPointData */
        $polygonPointData = $data['polygonPoint'];

        $inPolygonPointData = null;
        if (isset($data['inPolygonPoint']) && is_array($data['inPolygonPoint'])) {
            /** @var array<string, mixed> $pointArray */
            $pointArray = $data['inPolygonPoint'];
            $inPolygonPointData = GeoLocationPoint::fromArray($pointArray);
        }

        return new self(
            polygonPoint: [GeoLocationPoint::fromArray($polygonPointData)],
            inPolygonPoint: $inPolygonPointData,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'polygonPoint' => array_map(
                fn (GeoLocationPoint $point): array => $point->toArray(),
                $this->polygonPoint
            ),
        ];

        if ($this->inPolygonPoint instanceof \VincentAuger\DataCiteSdk\Data\GeoLocation\GeoLocationPoint) {
            $array['inPolygonPoint'] = $this->inPolygonPoint->toArray();
        }

        return $array;
    }
}
