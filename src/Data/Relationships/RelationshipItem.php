<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Relationships;

final readonly class RelationshipItem
{
    public function __construct(
        public string $id,
        public string $type,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            id: $data['id'],
            type: $data['type'],
        );
    }
}
