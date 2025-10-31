<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

/**
 * Response wrapper for DataCite Event Data list queries.
 *
 * @see https://support.datacite.org/docs/eventdata-guide
 */
final readonly class ListEventData
{
    /**
     * @param  EventData[]  $data
     */
    public function __construct(
        public array $data,
        public EventMeta $meta,
        public ListLinks $links,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_array($data['data']));
        assert(is_array($data['meta']));
        assert(is_array($data['links']));

        /** @var array<array<string, mixed>> $eventsData */
        $eventsData = $data['data'];
        /** @var array<string, mixed> $metaData */
        $metaData = $data['meta'];
        /** @var array<string, mixed> $linksData */
        $linksData = $data['links'];

        return new self(
            data: array_map(
                fn (array $item): EventData => EventData::fromArray($item),
                $eventsData
            ),
            meta: EventMeta::fromArray($metaData),
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
                fn (EventData $event): array => $event->toArray(),
                $this->data
            ),
            'meta' => $this->meta->toArray(),
            'links' => $this->links->toArray(),
        ];
    }
}
