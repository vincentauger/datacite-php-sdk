<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

/**
 * Event relationships container.
 *
 * Contains subject (subj) and object (obj) relationships.
 */
final readonly class EventRelationships
{
    public function __construct(
        public EventRelationshipItem $subj,
        public EventRelationshipItem $obj,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_array($data['subj']));
        assert(is_array($data['obj']));

        /** @var array<string, mixed> $subj */
        $subj = $data['subj'];

        /** @var array<string, mixed> $obj */
        $obj = $data['obj'];

        return new self(
            subj: EventRelationshipItem::fromArray($subj),
            obj: EventRelationshipItem::fromArray($obj),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'subj' => $this->subj->toArray(),
            'obj' => $this->obj->toArray(),
        ];
    }
}
