<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

use VincentAuger\DataCiteSdk\Enums\TitleType;

final readonly class Title
{
    public function __construct(
        public string $title,
        public ?string $lang = null,
        public ?TitleType $titleType = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['title']));

        $titleType = isset($data['titleType']) && is_string($data['titleType'])
            ? TitleType::tryFrom($data['titleType'])
            : null;

        return new self(
            title: $data['title'],
            lang: isset($data['lang']) && is_string($data['lang']) ? $data['lang'] : null,
            titleType: $titleType,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = ['title' => $this->title];

        if ($this->lang !== null) {
            $array['lang'] = $this->lang;
        }

        if ($this->titleType instanceof \VincentAuger\DataCiteSdk\Enums\TitleType) {
            $array['titleType'] = $this->titleType->value;
        }

        return $array;
    }
}
