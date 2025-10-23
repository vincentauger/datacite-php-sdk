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

    public static function fromArray(array $data): self
    {
        return new self(
            lang: $data['lang'] ?? null,
            description: $data['description'],
            descriptionType: $data['descriptionType'],
        );
    }

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
