<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class Title
{
    public function __construct(
        public ?string $lang,
        public string $title,
        public ?string $titleType,
    ) {}

    public static function fromArray(array $data): self
    {
        return new self(
            lang: $data['lang'] ?? null,
            title: $data['title'],
            titleType: $data['titleType'] ?? null,
        );
    }

    public function toArray(): array
    {
        $array = ['title' => $this->title];

        if ($this->lang !== null) {
            $array['lang'] = $this->lang;
        }

        if ($this->titleType !== null) {
            $array['titleType'] = $this->titleType;
        }

        return $array;
    }
}
