<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

/**
 * Event relationship data object.
 *
 * Represents the data within a relationship (subj or obj).
 */
final readonly class EventRelationshipData
{
    public function __construct(
        public string $id,
        public string $type,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['id']));
        assert(is_string($data['type']));

        return new self(
            id: $data['id'],
            type: $data['type'],
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
        ];
    }
}
