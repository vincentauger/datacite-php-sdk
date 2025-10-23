<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Metadata;

final readonly class Description
{
    public function __construct(
        public ?string $lang,
        public string $description,
        public string $descriptionType,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['description']));
        assert(is_string($data['descriptionType']));

        return new self(
            lang: isset($data['lang']) && is_string($data['lang']) ? $data['lang'] : null,
            description: $data['description'],
            descriptionType: $data['descriptionType'],
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'description' => $this->description,
            'descriptionType' => $this->descriptionType,
        ];

        if ($this->lang !== null) {
            $array['lang'] = $this->lang;
        }

        return $array;
    }
}
