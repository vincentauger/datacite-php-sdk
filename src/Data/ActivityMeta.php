<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

final readonly class ActivityMeta
{
    public function __construct(
        public int $total,
        public int $totalPages,
        public int $page,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_numeric($data['total']));
        assert(is_numeric($data['totalPages']));
        assert(is_numeric($data['page']));

        return new self(
            total: (int) $data['total'],
            totalPages: (int) $data['totalPages'],
            page: (int) $data['page'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'total' => $this->total,
            'totalPages' => $this->totalPages,
            'page' => $this->page,
        ];
    }
}
