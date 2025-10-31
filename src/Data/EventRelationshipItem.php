<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

/**
 * Event relationship item (subj or obj).
 *
 * Wraps the relationship data object.
 */
final readonly class EventRelationshipItem
{
    public function __construct(
        public EventRelationshipData $data,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_array($data['data']));

        /** @var array<string, mixed> $itemData */
        $itemData = $data['data'];

        return new self(
            data: EventRelationshipData::fromArray($itemData),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'data' => $this->data->toArray(),
        ];
    }
}
