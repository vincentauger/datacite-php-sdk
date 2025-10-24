<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

final readonly class MetaItem
{
    public function __construct(
        public string $id,
        public string $title,
        public int $count,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['id']));
        assert(is_string($data['title']));
        assert(is_numeric($data['count']));

        return new self(
            id: $data['id'],
            title: $data['title'],
            count: (int) $data['count'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'count' => $this->count,
        ];
    }
}
