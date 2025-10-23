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

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['title']));

        return new self(
            lang: isset($data['lang']) && is_string($data['lang']) ? $data['lang'] : null,
            title: $data['title'],
            titleType: isset($data['titleType']) && is_string($data['titleType']) ? $data['titleType'] : null,
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

        if ($this->titleType !== null) {
            $array['titleType'] = $this->titleType;
        }

        return $array;
    }
}
