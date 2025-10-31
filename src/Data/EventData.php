<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

/**
 * Event data response.
 *
 * Represents a single event from the DataCite Events API.
 */
final readonly class EventData
{
    public function __construct(
        public string $id,
        public string $type,
        public EventAttributes $attributes,
        public EventRelationships $relationships,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['id']));
        assert(is_string($data['type']));
        assert(is_array($data['attributes']));
        assert(is_array($data['relationships']));

        /** @var array<string, mixed> $attributes */
        $attributes = $data['attributes'];

        /** @var array<string, mixed> $relationships */
        $relationships = $data['relationships'];

        return new self(
            id: $data['id'],
            type: $data['type'],
            attributes: EventAttributes::fromArray($attributes),
            relationships: EventRelationships::fromArray($relationships),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'attributes' => $this->attributes->toArray(),
            'relationships' => $this->relationships->toArray(),
        ];
    }
}
