<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

final readonly class DOIActivitiesData
{
    /**
     * @param  ActivityData[]  $data
     */
    public function __construct(
        public array $data,
        public ActivityMeta $meta,
        public ListLinks $links,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        // Handle both direct API response and fixture format
        $responseData = isset($data['data']) && is_string($data['data'])
            ? json_decode($data['data'], true)
            : $data;

        assert(is_array($responseData));
        assert(is_array($responseData['data']));
        assert(is_array($responseData['meta']));
        assert(is_array($responseData['links']));

        /** @var array<array<string, mixed>> $activitiesData */
        $activitiesData = $responseData['data'];
        /** @var array<string, mixed> $metaData */
        $metaData = $responseData['meta'];
        /** @var array<string, mixed> $linksData */
        $linksData = $responseData['links'];

        return new self(
            data: array_map(
                fn (array $item): ActivityData => ActivityData::fromArray($item),
                $activitiesData
            ),
            meta: ActivityMeta::fromArray($metaData),
            links: ListLinks::fromArray($linksData),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'data' => array_map(
                fn (ActivityData $activity): array => $activity->toArray(),
                $this->data
            ),
            'meta' => $this->meta->toArray(),
            'links' => $this->links->toArray(),
        ];
    }
}
