<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data;

final readonly class ActivityData
{
    public function __construct(
        public string $id,
        public string $type,
        public ActivityAttributes $attributes,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_string($data['id']));
        assert(is_string($data['type']));
        assert(is_array($data['attributes']));

        /** @var array<string, mixed> $attributesData */
        $attributesData = $data['attributes'];

        return new self(
            id: $data['id'],
            type: $data['type'],
            attributes: ActivityAttributes::fromArray($attributesData),
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'type' => $this->type,
            'attributes' => $this->attributes->toArray(),
        ];
    }
}
