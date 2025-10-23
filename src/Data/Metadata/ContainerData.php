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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        if ($data === []) {
            return new self;
        }

        return new self(
            type: isset($data['type']) && is_string($data['type']) ? $data['type'] : null,
            title: isset($data['title']) && is_string($data['title']) ? $data['title'] : null,
            firstPage: isset($data['firstPage']) && is_string($data['firstPage']) ? $data['firstPage'] : null,
        );
    }

    /**
     * @return array<string, mixed>
     */
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
