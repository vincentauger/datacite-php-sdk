<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class ContainerData
{
    public function __construct(
        public ?string $type = null,
        public ?string $title = null,
        public ?string $firstPage = null,
    ) {}

    public static function fromArray(array $data): self
    {
        if (empty($data)) {
            return new self;
        }

        return new self(
            type: $data['type'] ?? null,
            title: $data['title'] ?? null,
            firstPage: $data['firstPage'] ?? null,
        );
    }

    public function toArray(): array
    {
        $array = [];

        if ($this->type !== null) {
            $array['type'] = $this->type;
        }

        if ($this->title !== null) {
            $array['title'] = $this->title;
        }

        if ($this->firstPage !== null) {
            $array['firstPage'] = $this->firstPage;
        }

        return $array;
    }
}
