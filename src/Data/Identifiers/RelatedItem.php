<?php

declare(strict_types=1);

namespace VincentAuger\DataCiteSdk\Data\Identifiers;

use VincentAuger\DataCiteSdk\Data\Metadata\Title;

final readonly class RelatedItem
{
    /**
     * @param  Title[]  $titles
     */
    public function __construct(
        public array $titles,
        public string $relationType,
        public string $relatedItemType,
        public ?RelatedItemIdentifier $relatedItemIdentifier = null,
    ) {}

    /**
     * @param  array<string, mixed>  $data
     */
    public static function fromArray(array $data): self
    {
        assert(is_array($data['titles']));
        assert(is_string($data['relationType']));
        assert(is_string($data['relatedItemType']));

        /** @var array<array<string, mixed>> $titlesData */
        $titlesData = $data['titles'];

        $relatedItemIdentifierData = null;
        if (isset($data['relatedItemIdentifier']) && is_array($data['relatedItemIdentifier'])) {
            /** @var array<string, mixed> $identifierArray */
            $identifierArray = $data['relatedItemIdentifier'];
            $relatedItemIdentifierData = RelatedItemIdentifier::fromArray($identifierArray);
        }

        return new self(
            titles: array_map(
                fn (array $item): Title => Title::fromArray($item),
                $titlesData
            ),
            relationType: $data['relationType'],
            relatedItemType: $data['relatedItemType'],
            relatedItemIdentifier: $relatedItemIdentifierData,
        );
    }

    /**
     * @return array<string, mixed>
     */
    public function toArray(): array
    {
        $array = [
            'titles' => array_map(fn (Title $title): array => $title->toArray(), $this->titles),
            'relationType' => $this->relationType,
            'relatedItemType' => $this->relatedItemType,
        ];

        if ($this->relatedItemIdentifier instanceof \VincentAuger\DataCiteSdk\Data\Identifiers\RelatedItemIdentifier) {
            $array['relatedItemIdentifier'] = $this->relatedItemIdentifier->toArray();
        }

        return $array;
    }
}
